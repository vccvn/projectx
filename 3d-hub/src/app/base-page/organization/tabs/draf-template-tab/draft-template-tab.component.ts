import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';

import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { DraftTemplateModel, DraftTemplatesActions } from '@app/base-page/_store/drafttemplate';
import { environment } from '@env/environment';
import { SettingService } from '@app/_core/services';

@Component({
  selector: 'app-draft-template-tab',
  templateUrl: './draft-template-tab.component.html',
  styleUrls: ['./draft-template-tab.component.scss'],
})
export class DraftTemplateTabComponent implements OnInit {
  templates$: Observable<Array<DraftTemplateModel>>;
  templatesEnd$: Observable<boolean>;
  loading$: Observable<boolean>;

  limit = 8;
  page = 0;

  fulltext: string;
  maxHeight = 200;

  url = environment.apiUrl + 'admin/api/drafttemplates/zip';
  headers = { Authorization: 'Bearer ' + this.settingService.auth.accessToken, Accept: '*/*' };

  constructor(private store$: Store<fromApp.PageState>, private cd: ChangeDetectorRef, private readonly settingService: SettingService) {}

  ngOnInit(): void {
    this.loading$ = this.store$.select(fromApp.getDraftTemplatesLoading);
    this.templates$ = this.store$.select(fromApp.getDraftTemplates);
    this.templatesEnd$ = this.store$.select(fromApp.getDraftTemplatesEnd);
  }

  onLoadMore() {
    this.page += 1;
    this.fetchData();
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
      sort?: string;
      q?: string;
    } = {
      page: this.page - 1,
      limit: this.limit,
    };

    if (typeof this.fulltext === 'string') {
      params.q = this.fulltext;
    }

    this.store$.dispatch(DraftTemplatesActions.getDraftTemplates({ payload: params }));
  }
}
