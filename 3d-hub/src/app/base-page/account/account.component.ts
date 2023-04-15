import { Component, ChangeDetectionStrategy, ChangeDetectorRef, OnDestroy, AfterViewInit, ElementRef, OnInit } from '@angular/core';
import { Router, ActivationEnd } from '@angular/router';
import { fromEvent, Subscription } from 'rxjs';
import { filter, debounceTime } from 'rxjs/operators';
import { _HttpClient } from '@delon/theme';
import { SettingService } from '@app/_core/services';

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class SettingComponent implements OnInit, AfterViewInit, OnDestroy {
  private resize$: Subscription;
  private router$: Subscription;
  mode = 'horizontal';
  title: string;
  userRole: string;

  menusSetup: any[] = [
    {
      key: 'Profile',
      title: 'Profile',
      path: '/account/profile',
    },
    {
      key: 'change-password',
      title: 'Change your password',
      path: '/account/change-password',
    },
    {
      key: 'Transactions',
      title: 'Transactions',
      path: '/account/transactions',
    },
    {
      key: 'Notification',
      title: 'Notifications',
      path: '/account/notifications',
    },
  ];

  menus: any[] = [];
  constructor(private router: Router, private cdr: ChangeDetectorRef, private el: ElementRef, private settingService: SettingService) {
    this.router$ = this.router.events.pipe(filter((e) => e instanceof ActivationEnd)).subscribe(() => this.setActive());
  }

  ngOnInit() {
    this.menus = this.getMenus();
    this.setActive();
  }
  private setActive() {
    const key = this.router.url.substr(this.router.url.lastIndexOf('/') + 1);
    this.menus.forEach((m) => {
      m.selected = m.key === key;
    });

    this.title = this.menus.find((w) => w.selected)?.title;
  }

  to(item: any) {
    this.router.navigateByUrl(`/account/${item.key}`);
  }

  private resize() {
    const el = this.el.nativeElement as HTMLElement;
    let mode = 'horizontal';
    const { offsetWidth } = el;
    if (offsetWidth < 641 && offsetWidth > 400) {
      mode = 'horizontal';
    }
    if (window.innerWidth < 768 && offsetWidth > 400) {
      mode = 'horizontal';
    }
    this.mode = mode;
    this.cdr.detectChanges();
  }

  getMenus() {
    // const roles = this.settingService.roles;
    return this.menusSetup;
    // this.getMenuWithRoles(this.menusSetup, roles);
  }

  getMenuWithRoles(menus, roles) {
    return menus.reduce((current, item) => {
      if (!Array.isArray(item.roles)) {
        return current;
      }
      const itemFound = item.roles.find((r) => {
        return roles.includes(r);
      });

      if (!itemFound) {
        return current;
      }

      if (!Array.isArray(item.childs)) {
        current.push(item);
        return current;
      }

      const childs = this.getMenuWithRoles(item.childs, roles);
      if (childs.length < 1) {
        return current;
      }
      item.childs = childs;
      current.push(item);
      return current;
    }, []);
  }

  ngAfterViewInit(): void {
    this.resize$ = fromEvent(window, 'resize')
      .pipe(debounceTime(200))
      .subscribe(() => this.resize());
  }

  ngOnDestroy(): void {
    this.resize$.unsubscribe();
    this.router$.unsubscribe();
  }
}
