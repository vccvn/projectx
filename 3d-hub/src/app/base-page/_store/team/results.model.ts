import { TeamModel } from './model';
export class TeamResultsModel {
  data?: TeamModel[];
  pagination?: {
    totalPages: number;
    page: number;
    limit: number;
    totalRecords: number;
  };
  message?: string;
  status?: number;
}

export class TeamResultModel {
  data?: TeamModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
