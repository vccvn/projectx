import { NotificationModel } from './model';
export class NotificationResultsModel {
  data?: NotificationModel[];
  pagination?: {
    totalPages: number;
    page: number;
    limit: number;
    totalRecords: number;
  };
  message?: string;
  status?: number;
}

export class NotificationResultModel {
  data?: NotificationModel | { notSeenCount: number };
  validationErrors?: Array<{ field?: string; message?: string }>;
}
