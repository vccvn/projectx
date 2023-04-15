import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { App, Layout, SettingsNotify } from './setting.model';
import { User } from '@app/auth/models';

export const LAYOUT = 'layout';

export const USER = 'user';

export const APP = 'app';

export const ROLES = 'roles';

export const PATHS = 'paths';

@Injectable({
  providedIn: 'root',
})
export class SettingService {
  private notify$ = new Subject<SettingsNotify>();

  private appIn: App;
  private userIn: { user: User; accessToken: string; expiresIn: string };

  private layoutIn: Layout;
  
  private rolesIn: Array<string>;
  private pathsIn: Set<string>;

  urls = {
    login: '/auth/login',
  };

  constructor() {}

  private get(key: string) {
    return JSON.parse(localStorage.getItem(key) || 'null') || null;
  }

  private set(key: string, value: any) {
    localStorage.setItem(key, JSON.stringify(value));
  }

  private remove(key: string) {
    localStorage.removeItem(key);
  }

  get layout(): Layout {
    if (!this.layoutIn) {
      this.layoutIn = {
        fixed: true,
        collapsed: false,
        boxed: false,
        lang: null,
        ...this.get(LAYOUT),
      };
      this.set(LAYOUT, this.layoutIn);
    }
    return this.layoutIn as Layout;
  }

  get roles(): Array<string> {
    if (!this.rolesIn) {
      this.rolesIn = this.get(ROLES);
      this.set(ROLES, this.rolesIn);
    }
    return this.rolesIn;
  }

  get paths(): Set<string> {
    if (!this.pathsIn) {
      this.pathsIn = new Set(this.get(PATHS));
      this.set(PATHS, this.pathsIn);
    }
    return this.pathsIn;
  }

  get app(): App {
    if (!this.appIn) {
      this.appIn = {
        year: new Date().getFullYear(),
        ...this.get(APP),
      };
      this.set(APP, this.appIn);
    }
    return this.appIn as App;
  }

  get user(): User {
    if (!this.userIn) {
      this.userIn = { ...this.get(USER) };
      this.set(USER, this.userIn);
    }
    return this.userIn.user as User;
  }

  get auth(): { accessToken: string; refeshToken: string; expiresIn: string } {
    if (!this.userIn) {
      this.userIn = { ...this.get(USER) };
      this.set(USER, this.userIn);
    }
    return {
      accessToken: this.userIn.accessToken,
      refeshToken: this.userIn.accessToken,
      expiresIn: this.userIn.expiresIn,
    };
  }

  get notify(): Observable<SettingsNotify> {
    return this.notify$.asObservable();
  }

  setLayout(name: string | Layout, value?: any): boolean {
    if (typeof name === 'string') {
      this.layout[name] = value;
    } else {
      this.layoutIn = name;
    }
    this.set(LAYOUT, this.layoutIn);
    this.notify$.next({ type: 'layout', name, value } as any);
    return true;
  }

  setApp(value: App) {
    this.appIn = value;
    this.set(APP, value);
    this.notify$.next({ type: 'app', value });
    return true;
  }

  setUser(value: any) {
    if (value === null) {
      this.remove(USER);
      return true;
    }

    this.userIn = value;
    this.set(USER, value);
    this.notify$.next({ type: 'user', value });
    return true;
  }

  setRoles(value: Array<string>) {
    if (value === null) {
      this.remove(ROLES);
      return true;
    }

    this.rolesIn = value;
    this.set(ROLES, value);
    this.notify$.next({ type: ROLES, value });
    return true;
  }

  setPaths(value: Array<string>) {
    if (value === null) {
      this.remove(PATHS);
      return true;
    }

    this.pathsIn = new Set(value);
    this.set(PATHS, value);
    this.notify$.next({ type: PATHS, value });
    return true;
  }
}
