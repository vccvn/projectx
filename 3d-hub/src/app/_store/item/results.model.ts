import { ItemModel } from './model';
export class ItemResultsModel {
  data?: ItemModel[];
  pageCount?: number;
  total?: number;
  page: number;
  count?: number;
  message?: string;
  status?: number;
  current_page?:number
  page_total?:number
  per_page?:number
}

export class ItemResultModel {
  data?: ItemModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
