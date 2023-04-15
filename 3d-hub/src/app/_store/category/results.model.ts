import { CategoryModel } from './model';
export class CategoryResultsModel {
  data?: CategoryModel[];
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

export class CategoryResultModel {
  data?: CategoryModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
