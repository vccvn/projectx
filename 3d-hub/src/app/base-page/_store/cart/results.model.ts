import { CartModel } from './model';
export class CartResultsModel {
  data?: CartModel[];
  pagination?: {
    currentPage: number;
    pageSize: number;
    totalRecords: number;
  };
  message?: string;
  status?: number;
}

export class CartResultModel {
  data?: CartModel;
  pagination: { currentPage: number; pageSize: number; totalRecords: number; };
}

export class CartFastResultModel {
  data?: { cartId?: number };
}
