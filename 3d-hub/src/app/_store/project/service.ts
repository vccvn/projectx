import { Injectable } from '@angular/core';
import { HttpService } from '@app/_core/services/http.service';
import { Observable } from 'rxjs';
import { CategoryResultsModel } from '../category';

import { ProjectModel } from './model';
import { ProjectResultModel, ProjectResultsModel } from './results.model';

const API_CUSTOMERS_URL = 'projects';


@Injectable({
    providedIn: 'root'
})
export class ProjectService {
    results: ProjectResultsModel;

    constructor(private httpService: HttpService) { }


    getAll(params: {}): Observable<ProjectResultsModel> {
        return this.httpService.get(API_CUSTOMERS_URL + "/list", params);
    }

    // get(key): Observable<ProjectResultModel> {
    //   return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
    // }

    get(key): Observable<ProjectModel> {
        return this.httpService.get(`${API_CUSTOMERS_URL}/detail/${key}`);
    }

    getByCategories(params: {}): Observable<CategoryResultsModel> {
        return this.httpService.get(API_CUSTOMERS_URL + "/categories", params);
    }
    create(model: ProjectModel): Observable<ProjectResultModel> {
        return this.httpService.post(API_CUSTOMERS_URL + "/create", model);
    }

    update(model: ProjectModel): Observable<ProjectResultModel> {
        const key = model.id;
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
        return this.httpService.put(`${API_CUSTOMERS_URL}/update/${key}`, model);
    }


    updateThumbnail(model: ProjectModel): Observable<ProjectResultModel> {
        const key = model.id;
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
        // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);
        return this.httpService.put(`${API_CUSTOMERS_URL}/thumbnail/${key}`, model);
    }



    delete(key): Observable<ProjectResultModel> {
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
        return this.httpService.download(`projects/render`, params);
    }

    getProjectData(url) {
        return this.httpService.getOut(url);
    }

    useProject(ProjectId): Observable<ProjectResultModel> {
        return this.httpService.post(`${API_CUSTOMERS_URL}/${ProjectId}/use`, {}, false);
    }
}
