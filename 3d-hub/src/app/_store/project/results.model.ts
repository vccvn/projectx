import { ProjectModel } from './model';
export class ProjectResultsModel {
  data?: ProjectModel[];
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

export class ProjectResultModel {
  data?: ProjectModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
