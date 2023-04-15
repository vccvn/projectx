
import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { CategoryService } from '@app/_store/category';
import { ItemService, ItemTableService } from '@app/_store/item';
import { ItemEventService } from './event.service';
import { ItemStorageService } from './storage.service';

export const services = [
  ItemService,
  CategoryService,
  ItemEditorService,
  ItemStorageService,
  ItemTableService,
  ItemEventService
];
