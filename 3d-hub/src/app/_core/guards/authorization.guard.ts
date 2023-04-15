import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';

import { PermissionsService } from '../services';

@Injectable({ providedIn: 'root' })
export class AuthorizationGuard implements CanActivate {
  constructor(private permissionsService: PermissionsService) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    const pageFormRoot = route.pathFromRoot
      .filter((p) => p.routeConfig && p.routeConfig.path !== '')
      .map((p) => '/' + p.routeConfig.path)
      .join('');
    return this.permissionsService.checkAuthorizationSync(`pages.${pageFormRoot}`);
  }
}
