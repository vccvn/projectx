import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router';

import { AuthenticationService } from '../../auth/services';

@Injectable({ providedIn: 'root' })
export class UnAuthGuard implements CanActivate {
  constructor(private authenticationService: AuthenticationService) {}

  canActivate() {
    // this.authenticationService.logout();
    return true;
  }
}
