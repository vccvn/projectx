import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { DraftTemplateModel } from './model';
import { DraftTemplateResultsModel, DraftTemplateResultModel } from './results.model';

const API_CUSTOMERS_URL = 'drafttemplates';

@Injectable()
export class DraftTemplateService {
  constructor(private restService: RestService) {}

  getAll(params: {}): Observable<DraftTemplateResultsModel> {
    return this.restService.get(API_CUSTOMERS_URL, params);
  }

  get(key): Observable<DraftTemplateResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: DraftTemplateModel): Observable<DraftTemplateResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  update(model: DraftTemplateModel): Observable<DraftTemplateResultModel> {
    const key = model.id;
    return this.restService.patch(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<DraftTemplateResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  search(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.restService.get(`${API_CUSTOMERS_URL}/search/all`, query);
  }

  getDraftTemplateData(url) {
    return this.restService.getOut(url);
  }
}
