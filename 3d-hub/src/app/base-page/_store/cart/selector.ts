import { createSelector } from '@ngrx/store';
import * as fromBussiness from '../reducers';

export const getCarts = createSelector(fromBussiness.selectContainerState, (state: fromBussiness.PageState) => state.carts.list);

export const getCartProcessing = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.listProcessing
);
export const getAgencyCartProcessing = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.listAgencyProcessing
);
export const getAgencyOrders = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.agencyOrders
);
export const getAgencyOrder = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.agencyOrder
);

export const getCart = createSelector(fromBussiness.selectContainerState, (state: fromBussiness.PageState) => state.carts.item);

export const getPaymentItemDetail = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.paymentItemDetail
);
export const getPaymentItemDetailAffiliate = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.paymentItemDetailAffiliate
);

export const getCartsPagination = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.pagination
);

export const getCartsLoading = createSelector(fromBussiness.selectContainerState, (state: fromBussiness.PageState) => state.carts.loading);

export const getAgencyOrdersPagination = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.paginationOrders
);

export const getAgencyPayments = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.paymentsAgency
);
export const getAgencyPaymentsPagination = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.paginationAgencyPayments
);

export const getAffiliatePayments = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.paymentsAffiliate
);
export const getAffiliatePaymentsPagination = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.paginationAffiliatePayments
);

export const getAgencyOrdersNotPaid = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.ordersNotPaidAgency
);

export const getAffiliateOrdersNotPaid = createSelector(
  fromBussiness.selectContainerState,
  (state: fromBussiness.PageState) => state.carts.ordersNotPaidAffiliate
);
