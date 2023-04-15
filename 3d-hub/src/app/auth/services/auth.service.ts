import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

import { User, Role } from '../models';
import { RestService } from '@app/_core/services/rest.service';
import { SettingService } from '@app/_core/services';

@Injectable({ providedIn: 'root' })
export class AuthenticationService {
  public currentUser: Observable<User>;

  constructor(private restService: RestService, private settingService: SettingService) {}

  public get currentUserType(): string {
    const roles = [];
    if (roles.includes(Role.ADMIN)) {
      return 'ROLE_ADMIN';
    }
    if (roles.includes(Role.AGENCY)) {
      return 'ROLE_AGENCY';
    }
    if (roles.includes(Role.AFFILIATE)) {
      return 'ROLE_AFFILIATE';
    }
  }

  public get currentUserValue(): User {
    return this.settingService.user;
  }

  login(email: string, password: string) {
    return this.restService.post(`auth/login`, { email, password });
  }

  logout() {
    // remove user from local storage to log user out
    this.settingService.setUser(null);
  }
}
