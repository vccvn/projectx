import { Injectable } from '@angular/core';
import { inArray } from '@app/_core/helpers/utils';
import { HttpService } from '@app/_core/services/http.service';
// import { StateService } from '@app/_core/services/state.service';
import { Observable, of } from 'rxjs';
// import { RestService } from '../../../_core/services/rest.service';

import { ImageModel } from './model';
import { ImageResultModel, ImageResultsModel } from './results.model';
// import { ImageResultsModel, ImageResultModel } from './results.model';

const API_CUSTOMERS_URL = 'images';

export const imgListTypes = ['images', 'list', 'foreground', 'background'];

@Injectable({
  providedIn: 'root'
})
export class ImageService {
  results: ImageResultsModel;

  constructor(private httpService: HttpService) { }



  getAll(params: {[key:string]:any}): Observable<ImageResultsModel> {
    return this.httpService.get(API_CUSTOMERS_URL + "/list.json", params);
  }
  getImageFromUrl(url: string, params: {[key:string]:any}): Observable<ImageResultsModel> {
    return this.httpService.get(API_CUSTOMERS_URL + "/list.json", params);
  }
  
  getImages(list: string, params: {[key:string]:any}): Observable<ImageResultsModel> {
    if(!inArray(imgListTypes, list)) return of({
      data: [],
      pageCount: 0,
      total: 0,
      page: 1,
      count: 0,
      message: "image list not found",
      status: 0
    });
    if(list == "image") list = "list";
    return this.httpService.get(API_CUSTOMERS_URL + "/"+list+".json", params);
  }

  getBackgrounds(params: {[key:string]:any}): Observable<ImageResultsModel> {
    return this.httpService.get(API_CUSTOMERS_URL + "/background.json", params);
  }
  getForegrounds(params: {[key:string]:any}): Observable<ImageResultsModel> {
    return this.httpService.get(API_CUSTOMERS_URL + "/foreground.json", params);
  }

  // get(key): Observable<ImageResultModel> {
  //   return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
  // }

  get(key): Observable<ImageModel> {
    return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
  }

  create(model: ImageModel): Observable<ImageResultModel> {
    return this.httpService.post(API_CUSTOMERS_URL + "/actions.json", model);
  }

  update(model: ImageModel): Observable<ImageResultModel> {
    const key = model.id;
    // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
    return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
  }


  delete(key): Observable<ImageResultModel> {
    // return this.httpService.delete(`${API_CUSTOMERS_URL}/${key}`);
    return this.httpService.delete(`${API_CUSTOMERS_URL}/actions.json`);
  }

  search(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.httpService.get(`${API_CUSTOMERS_URL}/list.json`, query);
  }

  searchNounProject(query: { tag?: string; key?: string; collectionCode?: string }) {
    return this.httpService.get(`${API_CUSTOMERS_URL}/search/nounproject`, query);
  }

  render(params) {
    return this.httpService.download(`Images/render`, params);
  }

  getImageData(url) {
    return this.httpService.getOut(url);
  }

  useImage(ImageId): Observable<ImageResultModel> {
    return this.httpService.post(`${API_CUSTOMERS_URL}/${ImageId}/use`, {}, false);
  }
}
