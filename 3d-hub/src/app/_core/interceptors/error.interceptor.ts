import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Router } from '@angular/router';

import { Observable, throwError, of } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { AuthenticationService } from '../../auth/services';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
  constructor(private authenticationService: AuthenticationService, private router: Router) {}

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(
      catchError((err) => {
        if ([401].indexOf(err.status) !== -1) {
          // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
          this.authenticationService.logout();

          // tslint:disable-next-line: deprecation
          this.router.navigate(['/auth/login']);
        }
        const error = err.message || err.name || err.statusText;
        return throwError(err.error);
      })
    );
  }
}
