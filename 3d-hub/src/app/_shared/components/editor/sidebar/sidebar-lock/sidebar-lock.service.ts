import { Injectable } from '@angular/core';
import { EventManagerService } from '@app/_core/services/event-manager.service';

@Injectable({
  providedIn: 'root'
})
export class SidebarLockService extends EventManagerService {

  constructor() {
    super();
    
  }
}
