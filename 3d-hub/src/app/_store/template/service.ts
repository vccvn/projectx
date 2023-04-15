import { Injectable } from '@angular/core';
import { HttpService } from '@app/_core/services/http.service';
import { Observable } from 'rxjs';
import { CategoryResultsModel } from '../category';

import { TemplateModel } from './model';
import { TemplateResultModel, TemplateResultsModel } from './results.model';

const API_CUSTOMERS_URL = 'templates';


@Injectable({
    providedIn: 'root'
})
export class TemplateService {
    results: TemplateResultsModel;

    constructor(private httpService: HttpService) { }



    getAll(params: {}): Observable<TemplateResultsModel> {
        return this.httpService.get(API_CUSTOMERS_URL + "/list", params);
    }

    // get(key): Observable<TemplateResultModel> {
    //   return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
    // }

    get(key): Observable<TemplateModel> {
        return this.httpService.get(`${API_CUSTOMERS_URL}/detail/${key}`);
    }

    getByCategories(params: {}): Observable<CategoryResultsModel> {
        return this.httpService.get(API_CUSTOMERS_URL + "/categories", params);
    }
    create(model: TemplateModel): Observable<TemplateResultModel> {
        return this.httpService.post(API_CUSTOMERS_URL + "/create", model);
    }

    update(model: TemplateModel): Observable<TemplateResultModel> {
        const key = model.id;
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
        return this.httpService.put(`${API_CUSTOMERS_URL}/update/${key}`, model);
    }


    updateThumbnail(model: TemplateModel): Observable<TemplateResultModel> {
        const key = model.id;
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
        return this.httpService.put(`${API_CUSTOMERS_URL}/thumbnail/${key}`, model);
    }



    delete(key): Observable<TemplateResultModel> {
        // return this.httpService.delete(`${API_CUSTOMERS_URL}/${key}`);
        return this.httpService.delete(`${API_CUSTOMERS_URL}/delete/${key}`);
    }

    search(query: { tag?: string; key?: string; collectionCode?: string }) {
        return this.httpService.get(`${API_CUSTOMERS_URL}/list`, query);
    }

    searchNounProject(query: { tag?: string; key?: string; collectionCode?: string }) {
        return this.httpService.get(`${API_CUSTOMERS_URL}/search/nounproject`, query);
    }

    render(params) {
        return this.httpService.download(`Templates/render`, params);
    }

    getTemplateData(url) {
        return this.httpService.getOut(url);
    }

    useTemplate(TemplateId): Observable<TemplateResultModel> {
        return this.httpService.post(`${API_CUSTOMERS_URL}/${TemplateId}/use`, {}, false);
    }
}
