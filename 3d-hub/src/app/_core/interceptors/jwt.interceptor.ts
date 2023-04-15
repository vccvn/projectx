import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable } from 'rxjs';
import { SettingService } from '../services';

@Injectable()
export class JwtInterceptor implements HttpInterceptor {
  constructor(private settingService: SettingService) {}

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const auth = this.settingService.auth;
    if (request.url.includes('original.cjson')) {
      return next.handle(request);
    }

    if (auth && typeof auth.accessToken === 'string') {
      request = request.clone({
        setHeaders: {
          Authorization: `Bearer ${auth.accessToken}`,
        },
      });
    }

    return next.handle(request);
  }
}
