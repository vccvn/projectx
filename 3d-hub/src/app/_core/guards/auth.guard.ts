import { Injectable } from '@angular/core';
import { Router, CanActivate } from '@angular/router';

import { SettingService } from '../services';

@Injectable({ providedIn: 'root' })
export class AuthGuard implements CanActivate {
  constructor(private router: Router, private settingService: SettingService) {}

  canActivate() {
    const auth = this.settingService.auth;
    if (auth && typeof auth.accessToken === 'string') {
      return true;
    }

    this.router.navigate(['/auth/login']);
    return false;
  }
}
