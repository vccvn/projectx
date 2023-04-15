import { ImageModel } from './model';
export class ImageResultsModel {
  data?: ImageModel[];
  pageCount?: number;
  total?: number;
  page: number;
  count?: number;
  message?: string;
  status?: number;
}

export class ImageResultModel {
  data?: ImageModel;
  validationErrors?: Array<{ field?: string; message?: string }>;
}
