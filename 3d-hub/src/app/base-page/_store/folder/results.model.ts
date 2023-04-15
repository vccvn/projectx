import { FolderModel } from './model';
export class FolderResultsModel {
  data?: FolderModel[];
  currentFolder?: FolderModel;
  pagination?: {
    totalPages: number;
    page: number;
    limit: number;
    totalRecords: number;
  };
  message?: string;
  status?: number;
}

export class FolderResultModel {
  data?: FolderModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
