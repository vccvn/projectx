import { Injectable } from '@angular/core';
import { SettingService } from '@app/_core/services';
import { OneSignalService } from 'ngx-onesignal-plus';
import { Observable, ReplaySubject } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { EventOnsignal, NotificationModel } from './model';
import { NotificationResultsModel, NotificationResultModel } from './results.model';
import { environment } from '@env/environment';

const KEY_TAG = 'user_id';
const DEFAULT_TITLE = 'Brandgos';

const API_CUSTOMERS_URL = 'notifications';
@Injectable({
  providedIn: 'root',
})
export class NotificationService {
  private onesignalConnection$ = new ReplaySubject<boolean>(1);
  event$ = new ReplaySubject<EventOnsignal>(1);
  opened$ = new ReplaySubject<EventOnsignal>(1);

  constructor(
    private restService: RestService,
    private readonly onesignal: OneSignalService,
    private readonly settingService: SettingService
  ) {}

  getAll(params: {}): Observable<NotificationResultsModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/me`, params);
  }

  get(key): Observable<NotificationResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/me/${key}`);
  }

  create(model: NotificationModel): Observable<NotificationResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  update(model: NotificationModel): Observable<NotificationResultModel> {
    const key = model.id;
    return this.restService.put(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<NotificationResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  getUnRead(): Observable<{ data: { notSeenCount: number } }> {
    return this.restService.get(API_CUSTOMERS_URL + '/countNotSeen');
  }

  connectNotification() {
    const user = this.settingService.user;
    const OneSignal = this.getOnesignalInstant();

    OneSignal.push(() => {
      this.onesignalConnection$.next(true);
      this.setupConfig();

      this.getSubscriptionState().then((state) => {
        if (state.isPushEnabled) {
        } else {
          if (state.isOptedOut) {
            /* Opted out, opt them back in */
            OneSignal.setSubscription(true);
          } else {
            OneSignal.registerForPushNotifications();
          }
        }
      });
    });

    this.setupInfo(user);
    this.setupChangeSubcription(user);
    this.setupListenNotification();
    this.setupNotificationOpened();
  }

  private setupConfig() {
    console.log('setupConfig');
    const OneSignal = this.getOnesignalInstant();
    if (!OneSignal.isPushNotificationsSupported()) {
      return alert('Browser is not support push notifications');
    }
    const DEFAULT_URL = environment.domain;
    console.log(DEFAULT_URL);
    OneSignal.setDefaultNotificationUrl(DEFAULT_URL);
    OneSignal.setDefaultTitle(DEFAULT_TITLE);
  }

  private setupInfo(user) {
    const OneSignal = this.getOnesignalInstant();
    OneSignal.setExternalUserId(`${user.userId}`);
    OneSignal.sendTag(KEY_TAG, `${user.userId}`);
  }

  logoutInfo() {
    const OneSignal = this.getOnesignalInstant();
    OneSignal.removeExternalUserId();
    OneSignal.deleteTag(KEY_TAG);
  }

  private setupChangeSubcription(user) {
    const OneSignal = this.getOnesignalInstant();
    OneSignal.on('subscriptionChange', (isSubscribed) => {
      if (isSubscribed) {
        OneSignal.setExternalUserId(`${user.userId}`);
        OneSignal.sendTag(KEY_TAG, `${user.userId}`);
      } else {
        OneSignal.removeExternalUserId();
        OneSignal.deleteTag(KEY_TAG);
      }
    });
  }

  private setupListenNotification() {
    const OneSignal = this.getOnesignalInstant();
    OneSignal.push(() => {
      OneSignal.on('notificationDisplay', (event: EventOnsignal) => {
        console.log('event', event);
        this.event$.next(event);
      });
    });
  }

  private setupNotificationOpened() {
    const OneSignal = this.getOnesignalInstant();
    console.log('setupNotificationOpened');
    OneSignal.push([
      'addListenerForNotificationOpened',
      (event) => {
        console.log('addListenerForNotificationOpened:', event);
        this.opened$.next(event);
      },
    ]);
  }

  private getSubscriptionState() {
    const OneSignal = this.getOnesignalInstant();

    return Promise.all([OneSignal.isPushNotificationsEnabled(), OneSignal.isOptedOut()]).then((result) => {
      const isPushEnabled = result[0];
      const isOptedOut = result[1];

      return {
        isPushEnabled,
        isOptedOut,
      };
    });
  }

  private getOnesignalInstant() {
    const keyOneSignal = 'OneSignal';
    const instant = window[keyOneSignal];
    if (!instant) {
      throw new Error('Empty OneSignal');
    }

    return instant;
  }
}
