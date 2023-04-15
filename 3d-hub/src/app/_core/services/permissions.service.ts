import { Injectable } from '@angular/core';
import { environment } from '@env/environment';

import { Observable, of } from 'rxjs';
import { SettingService } from './setting/setting.service';

@Injectable()
export class PermissionsService {
  private readonly WORKFLOW_EVENTS = Object.freeze(environment.workflow);
  private userRoles: Array<string> = [];

  constructor(private settingService: SettingService) {}

  public checkAuthorization(path: any): Observable<boolean> {
    if (!this.userRoles) {
      const roles = this.settingService.roles || [];
      this.userRoles = roles;
    }
    return of(this.doCheckAuthorization(path));
  }

  public checkAuthorizationSync(path: any): boolean {
    if (this.userRoles.length < 1) {
      const roles = this.settingService.roles || [];
      this.userRoles = roles;
      this.doCheckAuthorization(path);
    }
    return this.doCheckAuthorization(path);
  }

  private doCheckAuthorization(path: any): boolean {
    const paths = this.settingService.paths;
    return paths.has(path);
  }

  private parsePath(path: any): string[] {
    if (typeof path === 'string') {
      return path.split('.');
    }
    if (Array.isArray(path)) {
      return path;
    }
    return [];
  }

  private findEntry(currentObject: any, keys: string[], index = 0) {
    const key = keys[index];
    if (currentObject[key] && index < keys.length - 1) {
      return this.findEntry(currentObject[key], keys, index + 1);
    } else if (currentObject[key] && index === keys.length - 1) {
      return currentObject[key];
    } else {
      return false;
    }
  }
}
