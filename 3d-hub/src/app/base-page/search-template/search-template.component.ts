import { ChangeDetectionStrategy, Component, OnInit } from '@angular/core';

import { Observable } from 'rxjs';

import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { TemplateModel, TemplatesActions } from '@app/base-page/_store/template';

@Component({
  selector: 'app-search-template',
  templateUrl: './search-template.component.html',
  styleUrls: ['./search-template.component.scss'],
})
export class SearchTemplateComponent implements OnInit {
  templates$: Observable<Array<TemplateModel>>;
  templatesEnd$: Observable<boolean>;
  loading$: Observable<boolean>;

  limit = 8;
  page = 0;

  fulltext: string;
  maxHeight = 200;

  constructor(private store$: Store<fromApp.PageState>) {}

  ngOnInit(): void {
    this.loading$ = this.store$.select(fromApp.getSearchTemplatesLoading);
    this.templates$ = this.store$.select(fromApp.getSearchTemplates);
    this.templatesEnd$ = this.store$.select(fromApp.getSearchTemplatesEnd);
  }

  onLoadMore() {
    this.page += 1;
    this.fetchData();
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
      q?: string;
    } = {
      page: this.page - 1,
      limit: this.limit,
    };

    if (typeof this.fulltext === 'string') {
      params.q = this.fulltext;
    }

    this.store$.dispatch(TemplatesActions.searchTemplates({ payload: params }));
  }
}
