import { Component, OnInit, OnDestroy, ChangeDetectionStrategy, ChangeDetectorRef } from '@angular/core';
import { Router } from '@angular/router';

import { Subject, Observable } from 'rxjs';
import { takeUntil } from 'rxjs/operators';

import { Store } from '@ngrx/store';
import * as fromBusiness from '@app/base-page/_store';
import { NotificationModel, NotificationsActions } from '@app/base-page/_store/notification';

@Component({
  selector: 'app-notification',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class NotificationListComponent implements OnInit, OnDestroy {
  title = 'Thông báo từ hệ thống';

  private unsubscribe$: Subject<void> = new Subject();
  notifications$: Observable<NotificationModel[]>;
  loading$: Observable<boolean>;
  pagination$: Observable<any>;

  limit = 10;
  page = 1;
  totalRecords = 0;

  q = {
    fulltext: '',
  };

  expandSet = new Set<number>();
  constructor(private store$: Store<fromBusiness.PageState>, private cd: ChangeDetectorRef, private router: Router) {}

  ngOnInit(): void {
    this.notifications$ = this.store$.select(fromBusiness.getNotifications);

    this.pagination$ = this.store$.select(fromBusiness.getNotificationsPagination);
    this.loading$ = this.store$.select(fromBusiness.getNotificationsLoading);

    this.pagination$.pipe(takeUntil(this.unsubscribe$)).subscribe((res) => {
      this.page = res.page + 1;
      this.limit = res.limit;
      this.totalRecords = res.totalRecords;
      this.cd.detectChanges();
    });

    this.searchData();
  }

  ngOnDestroy() {
    this.unsubscribe$.next();
    this.unsubscribe$.complete();
  }

  select(notify: NotificationModel) {
    this.loadNotificationDetail(notify.id);
    this.goOutByNotification(notify);
  }

  goOutByNotification(notify) {
    const keyObjectId = 'objectId';
    const keyObjectType = 'objectType';
    switch (notify[keyObjectType]) {
      case 'Project':
        this.router.navigate(['page/projects/', notify[keyObjectId], 'genaral']);
        break;
      default:
        break;
    }
  }

  onExpandChange(id: number, checked: boolean): void {
    if (checked) {
      this.expandSet.add(id);
      this.loadNotificationDetail(id);
    } else {
      this.expandSet.delete(id);
    }
  }

  searchData(reset = false): void {
    if (reset) {
      this.page = 1;
    }
    this.fetchData();
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
      sort?: string;
    } = {
      page: this.page - 1,
      limit: this.limit,
    };

    this.store$.dispatch(NotificationsActions.getNotifications({ payload: params }));
  }

  loadNotificationDetail(id: number) {
    this.store$.dispatch(NotificationsActions.getNotification({ payload: { notificationId: id } }));
  }
}
