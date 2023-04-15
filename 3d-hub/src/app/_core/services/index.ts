import { RestService } from './rest.service';
import { StartupService } from './startup.service';
import { MenuService } from './menu/menu.service';
import { SettingService } from './setting/setting.service';
import { PermissionsService } from './permissions.service';
import { HttpService } from './http.service';
import { StorageService } from './storage.service';
import { LostDbService } from './lost-db.service';
import { LostDbTableService } from './lost-db-table.service';
import { EventManagerService } from './event-manager.service';

export * from './startup.service';
export * from './menu/menu.service';
export * from './setting/setting.service';
export * from './permissions.service';

export const services = [
  RestService,
  StartupService,
  MenuService,
  SettingService,
  PermissionsService,
  StorageService,
  HttpService,
  LostDbService,
  LostDbTableService,
  EventManagerService
];
