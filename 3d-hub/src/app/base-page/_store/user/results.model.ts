import { UserModel } from './model';
export class UserResultsModel {
  data?: UserModel[];
  pagination?: {
    totalPages: number;
    page: number;
    limit: number;
    totalRecords: number;
  };
  message?: string;
  status?: number;
}

export class UserResultModel {
  data?: UserModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
