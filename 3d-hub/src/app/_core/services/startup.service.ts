import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { zip } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { SettingService } from './setting/setting.service';
import { TranslateService } from '@ngx-translate/core';
import { MenuService } from '@delon/theme';

@Injectable({ providedIn: 'root' })
export class StartupService {
  constructor(
    private httpClient: HttpClient,
    private settingService: SettingService,
    private translateService: TranslateService,
    private menuService: MenuService
  ) {}

  init(): void {}

  load(): Promise<any> {
    return new Promise((resolve) => {
      zip(this.httpClient.get(`assets/data/i18n/vi-data.json`), this.httpClient.get('assets/data/app-data.json'))
        .pipe(
          catchError(([langData, appData]) => {
            resolve(null);
            return [langData, appData];
          })
        )
        .subscribe(
          ([langData, appData]) => {
            // setting language data
            this.translateService.setTranslation('vi', langData);
            this.translateService.setDefaultLang('vi');

            this.settingService.setApp(appData?.app);
            this.settingService.setPaths(appData?.paths);

            this.setupMenu(appData.menu);
          },
          () => {},
          () => {
            resolve(null);
          }
        );
    });
  }

  setupMenu(myMenu) {
    const menuItems = myMenu.map((item) => this.buildMenuItem(item));
    this.menuService.add([
      {
        group: true,
        children: menuItems,
      },
    ]);
  }

  buildMenuItem(item) {
    let childrenItem = [];
    if (Array.isArray(item.children)) {
      childrenItem = item.children.map((c) => this.buildMenuItem(c));
    }
    return {
      text: item.text,
      i18n: item.text,
      icon: item.iconCode,
      link: item.link,
      children: childrenItem,
    };
  }

  getMenuData(menuDefault, myRoleData, hasAdminRole) {
    try {
      const myMenu = JSON.parse(myRoleData?.webMenu);
      return myMenu?.children || [];
    } catch (error) {
      return hasAdminRole ? menuDefault : [];
    }
  }
}
