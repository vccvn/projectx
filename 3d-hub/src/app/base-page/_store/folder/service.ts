import { Injectable } from '@angular/core';
import { SettingService } from '@app/_core/services';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { FolderModel } from './model';
import { FolderResultsModel, FolderResultModel } from './results.model';

const API_CUSTOMERS_URL = 'folders';

@Injectable()
export class FolderService {
  constructor(private restService: RestService, private readonly setttingSerivce: SettingService) {}

  getAll(params: {}): Observable<FolderResultsModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}`, params);
  }

  get(key): Observable<FolderResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: FolderModel): Observable<FolderResultModel> {
    const user = this.setttingSerivce.user;
    return this.restService.post(`web/organizations/${user.organizationId}/users/${user.id}/folders`, model);
  }

  update(model: FolderModel): Observable<FolderResultModel> {
    const key = model.id;
    return this.restService.put(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<FolderResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  getFolders(model: FolderModel): Observable<FolderResultsModel> {
    const user = this.setttingSerivce.user;
    return this.restService.get(`web/organizations/${user.organizationId}/users/${user.id}/folders`, model);
  }
}
