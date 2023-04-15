import { NgModule, APP_INITIALIZER } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';

import { HTTP_INTERCEPTORS, HttpClient } from '@angular/common/http';
import { JwtInterceptor, ErrorInterceptor } from '@app/_core/interceptors';
import { services, StartupService } from '@app/_core/services';

import { TranslateModule, TranslateLoader } from '@ngx-translate/core';

import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { StoreModule } from '@ngrx/store';
import { EffectsModule } from '@ngrx/effects';
import { StoreDevtoolsModule } from '@ngrx/store-devtools';

import { AppComponent } from './app.component';
import { reducers, metaReducers } from './_store';
import { AuthModule } from './auth/auth.module';
import { AppUIModule } from './app-ui.module';
import { AppRoutingModule } from './app-routing.module';

import { NgxOneSignalModule } from 'ngx-onesignal-plus';

import { SharedModule } from './_shared/shared.module';

import en from '@angular/common/locales/en';
import { registerLocaleData } from '@angular/common';
import { environment } from '../environments/environment';
import { ServiceWorkerModule } from '@angular/service-worker';
import { SHARE_SERVICES } from './_shared/shared-services';

registerLocaleData(en);

export function I18nHttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http, `assets/data/i18n/`, '.json');
}

export function StartupServiceFactory(startupService: StartupService) {
  return () => startupService.load();
}

const APPINIT_PROVIDES = [
  StartupService,
  {
    provide: APP_INITIALIZER,
    useFactory: StartupServiceFactory,
    deps: [StartupService],
    multi: true,
  },
];

@NgModule({
  declarations: [AppComponent],
  imports: [
    CommonModule,
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    AppUIModule,
    AuthModule,
    SharedModule,
    BrowserAnimationsModule,

    EffectsModule.forRoot([]),

    StoreModule.forRoot(reducers, {
      metaReducers,
      runtimeChecks: {
        strictStateImmutability: true,
        strictActionImmutability: true,
      },
    }),

    !environment.production ? StoreDevtoolsModule.instrument() : [],
    TranslateModule.forRoot({
      loader: {
        provide: TranslateLoader,
        useFactory: I18nHttpLoaderFactory,
        deps: [HttpClient],
      },
    }),
    NgxOneSignalModule.forRoot({
      appId: 'abc',
      autoRegister: false,
      autoResubscribe: false,

      notificationClickHandlerMatch: 'exact',
      notificationClickHandlerAction: 'navigate',
      notifyButton: {
        enable: true,
      },
    }),

    ServiceWorkerModule.register('OneSignalSDKWorker.js', {
      enabled: true,
    }),
  ],
  providers: [
    ...services,

    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    ...APPINIT_PROVIDES,
    ...SHARE_SERVICES
  ],
  bootstrap: [AppComponent],
  exports: [TranslateModule, RouterModule],
})
export class AppModule {}
