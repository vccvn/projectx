import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { TeamModel } from './model';
import { TeamResultsModel, TeamResultModel } from './results.model';
import { UserResultsModel } from '../user';

const API_CUSTOMERS_URL = '/team';

@Injectable()
export class TeamService {
  constructor(private restService: RestService) {}

  getAll(params: {}): Observable<TeamResultsModel> {
    return this.restService.get(API_CUSTOMERS_URL, params);
  }

  get(key): Observable<TeamResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: TeamModel): Observable<TeamResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  update(model: TeamModel): Observable<TeamResultModel> {
    const key = model.id;
    return this.restService.put(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<TeamResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  getMembers(key): Observable<UserResultsModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/${key}/members`);
  }
}
