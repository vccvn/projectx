import { DraftTemplateModel } from './model';
export class DraftTemplateResultsModel {
  data?: DraftTemplateModel[];
  pageCount?: number;
  total?: number;
  page: number;
  count?: number;
  message?: string;
  status?: number;
}

export class DraftTemplateResultModel {
  data?: DraftTemplateModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
