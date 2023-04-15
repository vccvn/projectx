import { Injectable } from '@angular/core';
import { HttpService } from '@app/_core/services/http.service';
import { Observable } from 'rxjs';
// import { RestService } from '../../../_core/services/rest.service';

import { CategoryModel } from './model';
import { CategoryResultModel, CategoryResultsModel } from './results.model';
// import { CategoryResultsModel, CategoryResultModel } from './results.model';

const API_CUSTOMERS_URL = 'categories';


@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  results: CategoryResultsModel;

  constructor(private httpService: HttpService) { }



  getAll(params: {}): Observable<CategoryResultsModel> {
    return this.httpService.get(API_CUSTOMERS_URL + "/list", params);
  }

  // get(key): Observable<CategoryResultModel> {
  //   return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
  // }

  get(key): Observable<CategoryModel> {
    return this.httpService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: CategoryModel): Observable<CategoryResultModel> {
    return this.httpService.post(API_CUSTOMERS_URL + "/create", model);
  }

  update(model: CategoryModel): Observable<CategoryResultModel> {
    const key = model.id;
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
    return this.httpService.patch(`${API_CUSTOMERS_URL}/update`, model);
  }


  delete(key): Observable<CategoryResultModel> {
    return this.httpService.delete(`${API_CUSTOMERS_URL}/${key}`);
    // return this.httpService.delete(`${API_CUSTOMERS_URL}/actions.json`);
  }

  search(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.httpService.get(`${API_CUSTOMERS_URL}/list`, query);
  }

  searchNounProject(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.httpService.get(`${API_CUSTOMERS_URL}/search/nounproject`, query);
  }

  render(params) {
    return this.httpService.download(API_CUSTOMERS_URL + `/render`, params);
  }

  getCategoryData(url) {
    return this.httpService.getOut(url);
  }

  useCategory(CategoryId): Observable<CategoryResultModel> {
    return this.httpService.post(`${API_CUSTOMERS_URL}/${CategoryId}/use`, {}, false);
  }
}
