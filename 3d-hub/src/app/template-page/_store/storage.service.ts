/**
 * Stateservice sử dụng cho angular hoặc bất kỳ một core nào khác
 * @author DoanLN
 */
import { Injectable } from '@angular/core';
import { StorageService } from '@app/_core/services/storage.service';

@Injectable({
    providedIn: 'root'
})
export class TemplateStorageService extends StorageService {
    constructor(){
        super();
    }
}
