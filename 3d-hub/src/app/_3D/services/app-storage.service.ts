
import { Injectable } from '@angular/core';
import { StorageService } from '@app/_core/services/storage.service';

@Injectable({
    providedIn: 'root'
})
export class AppStorageService extends StorageService {
    constructor(){
        super();
    }
}