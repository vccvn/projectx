import { Component, OnInit } from '@angular/core';

import { Observable } from 'rxjs';

import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { DocumentModel, DocumentsActions } from '../_store/document';

@Component({
  selector: 'app-your-upload',
  templateUrl: './your-upload.component.html',
  styleUrls: ['./your-upload.component.scss'],
})
export class YourUploadComponent implements OnInit {
  documents$: Observable<Array<DocumentModel>>;
  documentsEnd$: Observable<boolean>;
  loading$: Observable<boolean>;

  limit = 8;
  page = 0;

  fulltext: string;
  maxHeight = 200;

  constructor(private store$: Store<fromApp.PageState>) {}

  ngOnInit(): void {
    this.loading$ = this.store$.select(fromApp.getYourDocumentsLoading);
    this.documents$ = this.store$.select(fromApp.getYourDocuments);
  }

  onLoadMore() {
    this.page += 1;
    this.fetchData();
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
    } = {
      page: this.page - 1,
      limit: this.limit,
    };

    this.store$.dispatch(DocumentsActions.getYourDocuments({ payload: params }));
  }
}
