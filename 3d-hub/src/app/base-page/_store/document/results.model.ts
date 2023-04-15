import { DocumentModel } from './model';
export class DocumentResultsModel {
  data?: DocumentModel[];
  pageCount?: number;
  total?: number;
  page: number;
  count?: number;
  message?: string;
  status?: number;
}

export class DocumentResultModel {
  data?: DocumentModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
