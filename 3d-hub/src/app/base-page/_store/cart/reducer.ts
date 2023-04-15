import { CartsActions, CartActionsTypes } from './actions';
import { CartModel } from './model';

export interface CartState {
  list: Array<CartModel>;
  item: CartModel;
  paymentItemDetail: CartModel;
  paymentItemDetailAffiliate: CartModel;
  pagination: {
    currentPage: number;
    pageSize: number;
    totalRecords: number;
  };

  loading: boolean;
  listProcessing: Array<CartModel>;
  paginationProcessing: {
    currentPage: number;
    pageSize: number;
    totalRecords: number;
  };
  listAgencyProcessing: Array<CartModel>;

  agencyOrders: Array<CartModel>;
  agencyOrder: Array<CartModel>;

  paginationOrders: {
    currentPage: number;
    pageSize: number;
    totalRecords: number;
  };

  paymentsAgency: Array<CartModel>;

  paginationAgencyPayments: {
    currentPage: number;
    pageSize: number;
    totalRecords: number;
  };

  paymentsAffiliate: Array<CartModel>;

  paginationAffiliatePayments: {
    currentPage: number;
    pageSize: number;
    totalRecords: number;
  };

  ordersNotPaidAgency: Array<CartModel>;
  ordersNotPaidAffiliate: Array<CartModel>;
}

export const initialState: CartState = {
  list: [],
  item: null,
  paymentItemDetail: null,
  paymentItemDetailAffiliate: null,
  pagination: {
    currentPage: 0,
    pageSize: 30,
    totalRecords: 0,
  },
  loading: false,
  listProcessing: [],
  paginationProcessing: {
    currentPage: 0,
    pageSize: 30,
    totalRecords: 0,
  },

  listAgencyProcessing: [],

  agencyOrders: [],
  agencyOrder: [],
  paginationOrders: {
    currentPage: 0,
    pageSize: 30,
    totalRecords: 0,
  },

  paymentsAgency: [],
  paginationAgencyPayments: {
    currentPage: 0,
    pageSize: 30,
    totalRecords: 0,
  },

  paymentsAffiliate: [],
  paginationAffiliatePayments: {
    currentPage: 0,
    pageSize: 30,
    totalRecords: 0,
  },

  ordersNotPaidAgency: [],
  ordersNotPaidAffiliate: [],
};

export function reducer(state = initialState, action: CartsActions): CartState {
  switch (action.type) {
    case CartActionsTypes.GET_CARTS: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_CARTS_SUCCESS: {
      return {
        ...state,
        list: [...action.payload.data],
        pagination: { ...action.payload.pagination },
        loading: false,
      };
    }

    case CartActionsTypes.GET_CARTS_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_SUCCESS: {
      return {
        ...state,
        agencyOrders: [...action.payload.data],
        paginationOrders: { ...action.payload.pagination },
        loading: false,
      };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_ITEM: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_ITEM_SUCCESS: {
      return {
        ...state,
        agencyOrder: [action.payload.data],
        loading: false,
      };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_ITEM_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_CARTS_PROCESSING: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_CARTS_PROCESSING_SUCCESS: {
      return {
        ...state,
        listProcessing: [...action.payload.data],
        paginationProcessing: { ...action.payload.pagination },
        loading: false,
      };
    }

    case CartActionsTypes.GET_CARTS_PROCESSING_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AGENCY_CARTS_PROCESSING: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AGENCY_CARTS_PROCESSING_SUCCESS: {
      return {
        ...state,
        listAgencyProcessing: [...action.payload.data],
        loading: false,
      };
    }

    case CartActionsTypes.GET_AGENCY_CARTS_PROCESSING_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AGENCY_PAYMENTS: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AGENCY_PAYMENTS_SUCCESS: {
      return {
        ...state,
        paymentsAgency: [...action.payload.data],
        paginationAgencyPayments: { ...action.payload.pagination },
        loading: false,
      };
    }

    case CartActionsTypes.GET_AGENCY_PAYMENT_ITEM: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AGENCY_PAYMENT_ITEM_SUCCESS: {
      return {
        ...state,
        paymentItemDetail: { ...action.payload.data },
        loading: false,
      };
    }

    case CartActionsTypes.GET_AGENCY_PAYMENT_ITEM_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AFFILIATE_PAYMENT_ITEM: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AFFILIATE_PAYMENT_ITEM_SUCCESS: {
      return {
        ...state,
        paymentItemDetailAffiliate: { ...action.payload.data },
        loading: false,
      };
    }

    case CartActionsTypes.GET_AFFILIATE_PAYMENT_ITEM_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AGENCY_PAYMENTS_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AFFILIATE_PAYMENTS: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AFFILIATE_PAYMENTS_SUCCESS: {
      return {
        ...state,
        paymentsAffiliate: [...action.payload.data],
        paginationAffiliatePayments: { ...action.payload.pagination },
        loading: false,
      };
    }

    case CartActionsTypes.GET_AFFILIATE_PAYMENTS_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_CART: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_CART_SUCCESS: {
      return {
        ...state,
        item: { ...action.payload.data },
        loading: false,
      };
    }

    case CartActionsTypes.GET_CART_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.CREATE_CART_FAST: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.CREATE_CART_FAST_SUCCESS: {
      const newList = [{ id: action.payload.data.cartId }, ...state.listProcessing];
      return {
        ...state,
        listProcessing: [...newList],
        loading: false,
      };
    }

    case CartActionsTypes.CREATE_CART_FAST_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_NOT_PAID: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_NOT_PAID_SUCCESS: {
      return {
        ...state,
        ordersNotPaidAgency: [...action.payload.data],
        loading: false,
      };
    }

    case CartActionsTypes.GET_AGENCY_ORDERS_NOT_PAID_FAILURE: {
      return { ...state, loading: false };
    }

    case CartActionsTypes.GET_AFFILIATE_ORDERS_NOT_PAID: {
      return { ...state, loading: true };
    }

    case CartActionsTypes.GET_AFFILIATE_ORDERS_NOT_PAID_SUCCESS: {
      return {
        ...state,
        ordersNotPaidAffiliate: [...action.payload.data],
        loading: false,
      };
    }

    case CartActionsTypes.GET_AFFILIATE_ORDERS_NOT_PAID_FAILURE: {
      return { ...state, loading: false };
    }

    default:
      return state;
  }
}
