import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';
import { HttpClient } from '@angular/common/http';
import { SettingModel } from './model';
import { SettingResultsModel, SettingResultModel } from './results.model';

const API_CUSTOMERS_URL = 'settings';

@Injectable()
export class SettingService {
  constructor(private restService: RestService, private http: HttpClient) {}

  getAll(params: {}): Observable<SettingResultsModel> {
    return this.restService.get(API_CUSTOMERS_URL + '/server', params);
  }

  get(key): Observable<SettingResultModel> {
    return this.restService.get(API_CUSTOMERS_URL + '/server' + key);
  }

  create(model: SettingModel): Observable<SettingResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  update(model: SettingModel): Observable<SettingResultModel> {
    const key = model.id;
    return this.restService.put(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  updateFast(model: SettingModel): Observable<SettingResultModel> {
    // const key = model.id;
    return this.restService.put(API_CUSTOMERS_URL + '/domain', model);
  }

  updateAccount(model: {
    email: string;
    password: string;
  }): Observable<SettingResultModel> {
    return this.restService.put(API_CUSTOMERS_URL + '/account', model);
  }

  updateChrome(model: {
    directoryChrome: string;
    isRunBackground: boolean;
  }): Observable<SettingResultModel> {
    return this.restService.put(API_CUSTOMERS_URL + '/chrome', model);
  }

  checkHealth(url: string): Observable<any> {
    return this.http.get<any>(url + '/settings/health');
  }

  runLogin(): Observable<any> {
    return this.restService.post(API_CUSTOMERS_URL + '/login-account');
  }

  delete(key): Observable<SettingResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }
}
