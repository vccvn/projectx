import { Action } from '@ngrx/store';
import {
  CartResultsModel,
  CartResultModel,
  CartFastResultModel
} from './results.model';
import { CartModel } from './model';

export enum CartActionsTypes {
  GET_CARTS = '[CART] Get Carts',
  GET_CARTS_SUCCESS = '[CART] Get Carts Success',
  GET_CARTS_FAILURE = '[CART] Get Carts Failure',

  GET_AGENCY_ORDERS = '[CART] Get Orders Agency',
  GET_AGENCY_ORDERS_SUCCESS = '[CART] Get Orders Agency Success',
  GET_AGENCY_ORDERS_FAILURE = '[CART] Get Orders Agency Failure',

  GET_AGENCY_ORDERS_ITEM = '[CART] Get Orders Agency Item',
  GET_AGENCY_ORDERS_ITEM_SUCCESS = '[CART] Get Orders Agency Item Success',
  GET_AGENCY_ORDERS_ITEM_FAILURE = '[CART] Get Orders Agency Item Failure',

  GET_CARTS_PROCESSING = '[CART] Get Carts Processing',
  GET_CARTS_PROCESSING_SUCCESS = '[CART] Get Carts Processing Success',
  GET_CARTS_PROCESSING_FAILURE = '[CART] Get Carts Processing Failure',

  GET_AGENCY_CARTS_PROCESSING = '[CART] Get Agency Carts Processing',
  GET_AGENCY_CARTS_PROCESSING_SUCCESS = '[CART] Get Agency Carts Processing Success',
  GET_AGENCY_CARTS_PROCESSING_FAILURE = '[CART] Get Agency Carts Processing Failure',

  GET_CART = '[CART] Get Cart',
  GET_CART_SUCCESS = '[CART] Get Cart Success',
  GET_CART_FAILURE = '[CART] Get Cart Failure',

  DELETE_CART = '[CART] Delete Carts',
  DELETE_CART_SUCCESS = '[CART] Delete Cart Success',
  DELETE_CART_FAILURE = '[CART] Delete Cart Failure',

  UPDATE_CART = '[CART] Update Cart',
  UPDATE_CART_SUCCESS = '[CART] Update Cart Success',
  UPDATE_CART_FAILURE = '[CART] Update Cart Failure',

  CREATE_CART = '[CART] Create Cart',
  CREATE_CART_SUCCESS = '[CART] Create Cart Success',
  CREATE_CART_FAILURE = '[CART] Create Cart Failure',

  CREATE_CART_FAST = '[CART] Create Cart Fast',
  CREATE_CART_FAST_SUCCESS = '[CART] Create Cart Fast Success',
  CREATE_CART_FAST_FAILURE = '[CART] Create Cart Fast Failure',

  INIT_CART = '[CART] Init Cart',
  INIT_CART_DONE = '[CART] Init Cart Done',

  GET_AGENCY_PAYMENTS = '[CART] Get Payments Agency',
  GET_AGENCY_PAYMENTS_SUCCESS = '[CART] Get Payments Agency Success',
  GET_AGENCY_PAYMENTS_FAILURE = '[CART] Get Payments Agency Failure',

  GET_AGENCY_PAYMENT_ITEM = '[CART] Get Payment Item Detail Agency',
  GET_AGENCY_PAYMENT_ITEM_SUCCESS = '[CART] Get Payment Item Detail Agency Success',
  GET_AGENCY_PAYMENT_ITEM_FAILURE = '[CART] Get Payment Item Detail Agency Failure',

  GET_AFFILIATE_PAYMENT_ITEM = '[CART] Get Payment Item Detail Affiliate',
  GET_AFFILIATE_PAYMENT_ITEM_SUCCESS = '[CART] Get Payment Item Affiliate Agency Success',
  GET_AFFILIATE_PAYMENT_ITEM_FAILURE = '[CART] Get Payment Item Detail Affiliate Failure',

  GET_AFFILIATE_PAYMENTS = '[CART] Get Payments Affiliate',
  GET_AFFILIATE_PAYMENTS_SUCCESS = '[CART] Get Payments Affiliate Success',
  GET_AFFILIATE_PAYMENTS_FAILURE = '[CART] Get Payments Affiliate Failure',

  GET_AGENCY_ORDERS_NOT_PAID = '[CART] Get Orders Not Paid Agency',
  GET_AGENCY_ORDERS_NOT_PAID_SUCCESS = '[CART] Get Orders Not Paid Agency Success',
  GET_AGENCY_ORDERS_NOT_PAID_FAILURE = '[CART] Get Orders Not Paid Agency Failure',
  GET_AFFILIATE_ORDERS_NOT_PAID = '[CART] Get Orders Not Paid Affiliate',
  GET_AFFILIATE_ORDERS_NOT_PAID_SUCCESS = '[CART] Get Orders Not Paid Affiliate Success',
  GET_AFFILIATE_ORDERS_NOT_PAID_FAILURE = '[CART] Get Orders Not Paid Affiliate Failure'
}

export class GetCartsProgessing implements Action {
  readonly type = CartActionsTypes.GET_CARTS_PROCESSING;
  constructor(public payload: any) {}
}

export class GetCartsProgessingSuccess implements Action {
  readonly type = CartActionsTypes.GET_CARTS_PROCESSING_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}
export class GetCartsProgessingFailure implements Action {
  readonly type = CartActionsTypes.GET_CARTS_PROCESSING_FAILURE;
}

export class GetAgencyCartsProgessing implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_CARTS_PROCESSING;
  constructor(public payload: any) {}
}

export class GetAgencyCartsProgessingSuccess implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_CARTS_PROCESSING_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}
export class GetAgencyCartsProgessingFailure implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_CARTS_PROCESSING_FAILURE;
}

export class GetAgencyOrders implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS;
  constructor(public payload: any) {}
}

export class GetAgencyOrdersSuccess implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}

export class GetAgencyOrdersFailure implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_FAILURE;
}

export class GetAgencyOrder implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_ITEM;
  constructor(public payload: any) {}
}

export class GetAgencyOrderSuccess implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_ITEM_SUCCESS;
  constructor(public payload: any) {}
}

export class GetAgencyOrderFailure implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_ITEM_FAILURE;
}

export class GetCarts implements Action {
  readonly type = CartActionsTypes.GET_CARTS;
  constructor(public payload: any) {}
}

export class GetCartsSuccess implements Action {
  readonly type = CartActionsTypes.GET_CARTS_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}

export class GetCartsFailure implements Action {
  readonly type = CartActionsTypes.GET_CARTS_FAILURE;
}

export class GetCart implements Action {
  readonly type = CartActionsTypes.GET_CART;
  constructor(public payload: string) {}
}

export class GetCartSuccess implements Action {
  readonly type = CartActionsTypes.GET_CART_SUCCESS;
  constructor(public payload: CartResultModel) {}
}
export class GetCartFailure implements Action {
  readonly type = CartActionsTypes.GET_CART_FAILURE;
}

export class UpdateCart implements Action {
  readonly type = CartActionsTypes.UPDATE_CART;
  constructor(public payload: CartModel) {}
}
export class UpdateCartSuccess implements Action {
  readonly type = CartActionsTypes.UPDATE_CART_SUCCESS;
  constructor(public payload: CartResultModel) {}
}
export class UpdateCartFailure implements Action {
  readonly type = CartActionsTypes.UPDATE_CART_FAILURE;
}

export class CreateCart implements Action {
  readonly type = CartActionsTypes.CREATE_CART;
  constructor(public payload: CartModel) {}
}
export class CreateCartSuccess implements Action {
  readonly type = CartActionsTypes.CREATE_CART_SUCCESS;
  constructor(public payload: CartResultModel) {}
}
export class CreateCartFailure implements Action {
  readonly type = CartActionsTypes.CREATE_CART_FAILURE;
}

export class CreateCartFast implements Action {
  readonly type = CartActionsTypes.CREATE_CART_FAST;
  constructor(public payload: CartModel) {}
}
export class CreateCartFastSuccess implements Action {
  readonly type = CartActionsTypes.CREATE_CART_FAST_SUCCESS;
  constructor(public payload: CartFastResultModel) {}
}
export class CreateCartFastFailure implements Action {
  readonly type = CartActionsTypes.CREATE_CART_FAST_FAILURE;
}

export class DeleteCart implements Action {
  readonly type = CartActionsTypes.DELETE_CART;
  constructor(public payload: number) {}
}
export class DeleteCartSuccess implements Action {
  readonly type = CartActionsTypes.DELETE_CART_SUCCESS;
  constructor(public payload: CartResultModel) {}
}
export class DeleteCartFailure implements Action {
  readonly type = CartActionsTypes.DELETE_CART_FAILURE;
}

export class InitCart implements Action {
  readonly type = CartActionsTypes.INIT_CART;
}

export class InitCartDone implements Action {
  readonly type = CartActionsTypes.INIT_CART_DONE;
}

export class GetAgencyPayments implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_PAYMENTS;
  constructor(public payload: any) {}
}

export class GetAgencyPaymentsSuccess implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_PAYMENTS_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}
export class GetAgencyPaymentsFailure implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_PAYMENTS_FAILURE;
}

export class GetAgencyPaymentsItem implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_PAYMENT_ITEM;
  constructor(public payload: any) {}
}

export class GetAgencyPaymentsItemSuccess implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_PAYMENT_ITEM_SUCCESS;
  constructor(public payload: CartResultModel) {}
}
export class GetAgencyPaymentsItemFailure implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_PAYMENT_ITEM_FAILURE;
}

export class GetAffiliatePaymentsItem implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_PAYMENT_ITEM;
  constructor(public payload: any) {}
}

export class GetAffiliatePaymentsItemSuccess implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_PAYMENT_ITEM_SUCCESS;
  constructor(public payload: CartResultModel) {}
}
export class GetAffiliatePaymentsItemFailure implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_PAYMENT_ITEM_FAILURE;
}

export class GetAgencyOrdersNotPaid implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_NOT_PAID;
  constructor(public payload: any) {}
}

export class GetAgencyOrdersNotPaidSuccess implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_NOT_PAID_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}
export class GetAgencyOrdersNotPaidFailure implements Action {
  readonly type = CartActionsTypes.GET_AGENCY_ORDERS_NOT_PAID_FAILURE;
}

export class GetAffiliateOrdersNotPaid implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_ORDERS_NOT_PAID;
  constructor(public payload: any) {}
}

export class GetAffiliateOrdersNotPaidSuccess implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_ORDERS_NOT_PAID_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}
export class GetAffiliateOrdersNotPaidFailure implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_ORDERS_NOT_PAID_FAILURE;
}

export class GetAffiliatePayments implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_PAYMENTS;
  constructor(public payload: any) {}
}

export class GetAffiliatePaymentsSuccess implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_PAYMENTS_SUCCESS;
  constructor(public payload: CartResultsModel) {}
}
export class GetAffiliatePaymentsFailure implements Action {
  readonly type = CartActionsTypes.GET_AFFILIATE_PAYMENTS_FAILURE;
}

export type CartsActions =
  | GetAffiliateOrdersNotPaid
  | GetAffiliateOrdersNotPaidSuccess
  | GetAffiliateOrdersNotPaidFailure
  | GetAffiliatePaymentsItem
  | GetAffiliatePaymentsItemSuccess
  | GetAffiliatePaymentsItemFailure
  | GetAgencyPaymentsItem
  | GetAgencyPaymentsItemSuccess
  | GetAgencyPaymentsItemFailure
  | GetAgencyOrdersNotPaid
  | GetAgencyOrdersNotPaidSuccess
  | GetAgencyOrdersNotPaidFailure
  | GetCarts
  | GetCartsSuccess
  | GetCartsFailure
  | GetAgencyOrders
  | GetAgencyOrdersSuccess
  | GetAgencyOrdersFailure
  | GetAgencyOrder
  | GetAgencyOrderSuccess
  | GetAgencyOrderFailure
  | GetAgencyPayments
  | GetAgencyPaymentsSuccess
  | GetAgencyPaymentsFailure
  | GetAffiliatePayments
  | GetAffiliatePaymentsSuccess
  | GetAffiliatePaymentsFailure
  | GetCartsProgessing
  | GetCartsProgessingSuccess
  | GetCartsProgessingFailure
  | GetAgencyCartsProgessing
  | GetAgencyCartsProgessingSuccess
  | GetAgencyCartsProgessingFailure
  | GetCart
  | GetCartSuccess
  | GetCartFailure
  | UpdateCart
  | UpdateCartSuccess
  | UpdateCartFailure
  | CreateCart
  | CreateCartSuccess
  | CreateCartFailure
  | CreateCartFast
  | CreateCartFastSuccess
  | CreateCartFastFailure
  | DeleteCart
  | DeleteCartSuccess
  | DeleteCartFailure
  | InitCart
  | InitCartDone;
