import { Component, OnInit } from '@angular/core';

import { Observable } from 'rxjs';

import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { TemplateModel, TemplatesActions } from '../_store/template';
@Component({
  selector: 'app-your-template',
  templateUrl: './your-template.component.html',
  styleUrls: ['./your-template.component.scss'],
})
export class YourTemplateComponent implements OnInit {
  templates$: Observable<Array<TemplateModel>>;
  templatesEnd$: Observable<boolean>;
  loading$: Observable<boolean>;

  limit = 8;
  page = 0;

  fulltext: string;
  maxHeight = 200;

  constructor(private store$: Store<fromApp.PageState>) {}

  ngOnInit(): void {
    this.loading$ = this.store$.select(fromApp.getYourTemplatesLoading);
    this.templates$ = this.store$.select(fromApp.getYourTemplates);
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

    this.store$.dispatch(TemplatesActions.getYourTemplates({ payload: params }));
  }
}
