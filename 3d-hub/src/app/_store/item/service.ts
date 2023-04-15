import { Injectable } from '@angular/core';
import { HttpService } from '@app/_core/services/http.service';
import { Observable } from 'rxjs';
import { CategoryResultsModel } from '../category';

import { ItemModel } from './model';
import { ItemResultModel, ItemResultsModel } from './results.model';

const API_CUSTOMERS_URL = 'items';


@Injectable({
  providedIn: 'root'
})
export class ItemService {
  results: ItemResultsModel;

  constructor(private httpService: HttpService) { }



  getAll(params: {}): Observable<ItemResultsModel> {
    return this.httpService.get(API_CUSTOMERS_URL + "/list", params);
  }

  getByCategories(params: {}): Observable<CategoryResultsModel> {
    return this.httpService.get(API_CUSTOMERS_URL + "/category", params);
  }

  // get(key): Observable<ItemResultModel> {
  //   return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
  // }

  get(key): Observable<ItemModel> {
    return this.httpService.get(`${API_CUSTOMERS_URL}/${key}`);
  }

  create(model: ItemModel): Observable<ItemResultModel> {
    return this.httpService.post(API_CUSTOMERS_URL + "/create", model);
  }

  update(model: ItemModel): Observable<ItemResultModel> {
    const key = model.id;
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
    return this.httpService.put(`${API_CUSTOMERS_URL}/update/${key}`, model);
  }


  updateSize(model: ItemModel): Observable<ItemResultModel> {
    const key = model.id;
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
    return this.httpService.put(`${API_CUSTOMERS_URL}/size/${key}`, model);
  }


  updateThumbnail(model: ItemModel): Observable<ItemResultModel> {
    const key = model.id;
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
    return this.httpService.put(`${API_CUSTOMERS_URL}/thumbnail/${key}`, model);
  }


  delete(key): Observable<ItemResultModel> {
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
    return this.httpService.download(API_CUSTOMERS_URL + '/render', params);
  }

  getItemData(url) {
    return this.httpService.getOut(url);
  }

  useItem(ItemId): Observable<ItemResultModel> {
    return this.httpService.post(`${API_CUSTOMERS_URL}/${ItemId}/use`, {}, false);
  }
}
