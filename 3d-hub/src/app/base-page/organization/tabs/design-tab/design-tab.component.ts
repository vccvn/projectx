import { ChangeDetectionStrategy, ChangeDetectorRef, Component, OnInit } from '@angular/core';

import { Observable, Subject } from 'rxjs';
import { takeUntil } from 'rxjs/operators';

import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { DocumentModel, DocumentsActions } from '@app/base-page/_store/document';

@Component({
  selector: 'app-design-tab',
  templateUrl: './design-tab.component.html',
  styleUrls: ['./design-tab.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class DesignTabComponent implements OnInit {
  private unsubscribe$: Subject<void> = new Subject();

  documents$: Observable<Array<DocumentModel>>;
  documentsEnd$: Observable<boolean>;
  loading$: Observable<boolean>;

  items: Array<{ groupKey: number; key: number; num: number; model: Partial<DocumentModel> }> = [];

  limit = 3;
  page = 0;

  constructor(private store$: Store<fromApp.PageState>, private cd: ChangeDetectorRef) {}

  ngOnInit(): void {
    this.loading$ = this.store$.select(fromApp.getOrganizationDocumentsLoading);
    this.documents$ = this.store$.select(fromApp.getOrganizationDocuments);
    this.documentsEnd$ = this.store$.select(fromApp.getOrganizationDocumentsEnd);
    this.documents$.pipe(takeUntil(this.unsubscribe$)).subscribe((res) => {});
    this.fetchData();
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
    } = {
      page: this.page,
      limit: this.limit,
    };

    this.store$.dispatch(DocumentsActions.getOrganizationDocuments({ payload: params }));
  }
}
