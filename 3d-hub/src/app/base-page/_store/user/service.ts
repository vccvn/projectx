import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { UserModel, PasswordModel } from './model';
import { UserResultsModel, UserResultModel } from './results.model';

const API_CUSTOMERS_URL = 'users';

@Injectable()
export class UserService {
  changePassword: any;
  constructor(private restService: RestService) {}

  getAll(params: {}): Observable<UserResultsModel> {
    return this.restService.get(API_CUSTOMERS_URL, params);
  }

  get(key): Observable<UserResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: UserModel): Observable<UserResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  update(model: UserModel): Observable<UserResultModel> {
    const key = model.id;
    return this.restService.put(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<UserResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  getProfile(): Observable<UserResultModel> {
    return this.restService.get(`${API_CUSTOMERS_URL}/profile`);
  }

  updateProfilePassword(model: PasswordModel): Observable<UserResultModel> {
    return this.restService.put(`changeMyPassword`, model);
  }

  changeMyPassword(params: PasswordModel): Observable<UserResultModel> {
    return this.restService.put(`changeMyPassword`, params);
  }
}
