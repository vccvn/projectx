import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { DocumentModel } from './model';
import { DocumentResultsModel, DocumentResultModel } from './results.model';

const API_CUSTOMERS_URL = 'documents';

@Injectable()
export class DocumentService {
  constructor(private restService: RestService) {}

  getAll(params: {}): Observable<DocumentResultsModel> {
    return this.restService.get(API_CUSTOMERS_URL, params);
  }

  getOrganizationDocuments(params: { organizationId: string }): Observable<DocumentResultsModel> {
    return this.restService.get(`web/organizations/${params.organizationId}/users/ok/designs/shared`, params);
  }

  getMyDocuments(params: { organizationId: string; userId: string; limit?: number; page?: number }): Observable<DocumentResultsModel> {
    console.log('getMyDocuments');
    return this.restService.get(`web/organizations/${params.organizationId}/users/ok/designs/all`, params);
  }

  get(key): Observable<DocumentResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: DocumentModel): Observable<DocumentResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  update(model: DocumentModel): Observable<DocumentResultModel> {
    const key = model.id;
    return this.restService.patch(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<DocumentResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  search(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.restService.get(`${API_CUSTOMERS_URL}/search/all`, query);
  }

  render(params) {
    return this.restService.download(`documents/render`, params);
  }

  getDocumentData(url) {
    return this.restService.getOut(url);
  }
}
