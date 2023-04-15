
import { Injectable } from '@angular/core';
import { StorageService } from '@app/_core/services/storage.service';
import { AppStorageService } from './app-storage.service';

@Injectable({
    providedIn: 'root'
})
export class AppEditorStorageService extends AppStorageService {
    constructor(){
        super();
    }
}