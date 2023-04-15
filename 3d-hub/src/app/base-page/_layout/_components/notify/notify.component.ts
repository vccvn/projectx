import { AfterViewInit, ChangeDetectionStrategy, ChangeDetectorRef, Component, NgZone, OnInit } from '@angular/core';
import { NoticeIconList, NoticeIconSelect, NoticeItem } from '@delon/abc/notice-icon';
import { Store } from '@ngrx/store';

import formatDistanceToNow from 'date-fns/formatDistanceToNow';
import * as fromNotification from '@app/base-page/_store/notification';
import { NzI18nService } from 'ng-zorro-antd/i18n';
import { Observable } from 'rxjs';
import { EventOnsignal, NotificationsActions, NotificationService } from '@app/base-page/_store/notification';
import { Router } from '@angular/router';

@Component({
  selector: 'app-notify',
  templateUrl: './notify.component.html',
  styleUrls: ['./notify.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LayoutProWidgetNotifyComponent implements OnInit, AfterViewInit {
  notifications: NoticeItem[] = [
    {
      title: 'Thông báo từ hệ thống',
      list: [],
      emptyText: 'Bạn đã đọc tất cả',
      emptyImage: '/assets/icons/icon-big-notify.svg',
      clearText: '...',
    },
  ];

  unRead$ = new Observable<number>();
  loading$ = new Observable<boolean>();

  count = 0;
  constructor(
    private router: Router,
    private nzI18n: NzI18nService,
    private cdr: ChangeDetectorRef,
    private notificationService: NotificationService,
    private store$: Store<fromNotification.NotificationState>
  ) {}

  ngOnInit() {
    this.listenNotifications();
    this.listenNotificationUnRead();
    // this.loadNotificationUnRead();
  }

  ngAfterViewInit() {
    this.setupNotification();
  }

  setupNotification() {
    setTimeout((e) => {
      this.notificationService.connectNotification();
    }, 3000);

    this.notificationService.event$.subscribe({
      next: (event: EventOnsignal) => {
        if (event && event.data) {
          const data = { ...event.data, title: event.heading, createdTime: new Date().toISOString() };
          this.store$.dispatch(
            NotificationsActions.addNotification({
              payload: { message: data },
            })
          );
        }
      },
    });

    this.notificationService.opened$.subscribe({
      next: (res: EventOnsignal) => {
        console.log(res);
        if (res && res.data) {
          const keyId = 'id';
          this.loadNotificationDetail(res.data[keyId]);
          this.goOutByNotification(res.data);
        }
      },
    });
  }

  listenNotifications() {
    this.loading$ = this.store$.select(fromNotification.getNotificationsLoading);
    this.store$.select(fromNotification.getNotifications).subscribe((notifications) => {
      this.notifications = this.getNoticeData(notifications);
      this.cdr.detectChanges();
    });
  }

  listenNotificationUnRead() {
    this.unRead$ = this.store$.select(fromNotification.getNotificationUnRead);
    this.unRead$.subscribe((count) => {
      this.count = count;
      this.cdr.detectChanges();
    });
  }

  getNoticeData(notices: NoticeIconList[]): NoticeItem[] {
    const data = this.notifications.slice();

    data.forEach((i) => (i.list = []));

    notices.forEach((item) => {
      const newItem = { ...item };
      if (typeof newItem.createdTime === 'string') {
        newItem.datetime = new Date(newItem.createdTime);
      }
      if (newItem.datetime) {
        newItem.datetime = formatDistanceToNow(newItem.datetime as Date, {
          locale: this.nzI18n.getDateLocale(),
        });
      }
      if (newItem.objectType === 'Project') {
        newItem.avatar = '/assets/icons/project.svg';
      }
      if (newItem.objectType === 'ProductRequirement') {
        newItem.avatar = '/assets/icons/preq.svg';
      }
      if (newItem.objectType === 'GoodsIssueReq') {
        newItem.avatar = '/assets/icons/preq.svg';
      }
      if (newItem.objectType === 'TransportReq') {
        newItem.avatar = '/assets/icons/treq.svg';
      }

      if (newItem.objectType === 'Trip') {
        newItem.avatar = '/assets/icons/treq.svg';
      }

      if (newItem.seen) {
        newItem.read = newItem.seen;
      }
      data[0].list.push(newItem);
    });

    return data;
  }

  select(res: NoticeIconSelect) {
    const keyId = 'id';
    const notify = res.item;

    this.loadNotificationDetail(notify[keyId]);
    this.goOutByNotification(notify);

    this.count = 0;
    this.cdr.detectChanges();
  }

  goOutByNotification(notify) {
    const keyObjectId = 'objectId';
    const keyObjectType = 'objectType';
    const objectType = notify[keyObjectType];
    const objectId = notify[keyObjectId];

    switch (objectType) {
      case 'Project':
        this.router.navigate(['page/projects', objectId, 'genaral']);
        break;
      case 'ProductRequirement':
        this.router.navigate(['page/product-requirements', objectId, 'detail']);
        break;
      case 'GoodsIssueReq':
        this.router.navigate(['page/stocks']);
        break;
      case 'TransportReq':
        this.router.navigate(['page/transport-requests']);
        break;
      case 'Trip':
        this.router.navigate(['page/trips']);
        break;
      default:
        break;
    }
  }

  loadNotificationUnRead() {
    this.store$.dispatch(NotificationsActions.getNotificationUnRead());
  }

  loadNotifications() {
    // this.store$.dispatch(NotificationsActions.getNotifications({ payload: {} }));
  }

  loadNotificationDetail(id: number) {
    this.store$.dispatch(NotificationsActions.getNotification({ payload: { notificationId: id } }));
  }
}
