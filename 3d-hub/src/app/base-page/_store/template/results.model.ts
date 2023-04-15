import { TemplateModel } from './model';
export class TemplateResultsModel {
  data?: TemplateModel[];
  pageCount?: number;
  total?: number;
  page: number;
  count?: number;
  message?: string;
  status?: number;
}

export class TemplateResultModel {
  data?: TemplateModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
