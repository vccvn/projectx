import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { TemplateModel } from './model';
import { TemplateResultsModel, TemplateResultModel } from './results.model';

const API_CUSTOMERS_URL = 'templates';

@Injectable()
export class TemplateService {
  constructor(private restService: RestService) {}

  getAll(params: {}): Observable<TemplateResultsModel> {
    return this.restService.get(API_CUSTOMERS_URL, params);
  }

  searchTemplates(params: {}): Observable<TemplateResultsModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/search`, params);
  }

  getMyTemplates(params: { organizationId: string; userId: string; limit?: number; page?: number }): Observable<TemplateResultsModel> {
    return this.restService.get(`organization/${params.organizationId}/user/${params.userId}/templates/all`, params);
  }

  getTemplateGroups(params: {}): Observable<TemplateResultsModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/templategroups`, params);
  }

  get(key): Observable<TemplateResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: TemplateModel): Observable<TemplateResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  update(model: TemplateModel): Observable<TemplateResultModel> {
    const key = model.id;
    return this.restService.patch(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<TemplateResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  search(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.restService.get(`${API_CUSTOMERS_URL}/search/all`, query);
  }

  searchNounProject(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.restService.get(`${API_CUSTOMERS_URL}/search/nounproject`, query);
  }

  render(params) {
    return this.restService.download(`templates/render`, params);
  }

  getTemplateData(url) {
    return this.restService.getOut(url);
  }
}
