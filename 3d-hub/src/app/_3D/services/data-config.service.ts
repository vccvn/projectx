import { Injectable } from '@angular/core';
import { HttpService } from '@app/_core/services/http.service';

@Injectable({
    providedIn: 'root'
})
export class DataConfigService {

    constructor(private http: HttpService) {

    }
}
