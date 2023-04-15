import { Injectable } from '@angular/core';
import { Actions, Effect, ofType } from '@ngrx/effects';
import { of } from 'rxjs';
import { map, switchMap, catchError } from 'rxjs/operators';

import { CartService } from './service';
import {
  CartActionsTypes,
  GetCart,
  GetCartSuccess,
  GetCartFailure,
  GetCartsSuccess,
  GetCartsFailure,
  CreateCart,
  CreateCartSuccess,
  UpdateCart,
  CreateCartFast,
  CreateCartFastSuccess,
  CreateCartFastFailure,
  CreateCartFailure,
  GetCartsProgessing,
  GetCartsProgessingSuccess,
  GetCartsProgessingFailure,
  GetAgencyOrders,
  GetAgencyOrdersSuccess,
  GetAgencyOrdersFailure,
  GetAffiliatePayments,
  GetAffiliatePaymentsSuccess,
  GetAgencyPayments,
  GetAgencyPaymentsSuccess,
  GetAgencyPaymentsFailure,
  GetAffiliatePaymentsFailure,
  GetAgencyOrdersNotPaid,
  GetAgencyOrdersNotPaidSuccess,
  GetAgencyOrdersNotPaidFailure,
  GetAgencyPaymentsItem,
  GetAgencyPaymentsItemSuccess,
  GetAgencyPaymentsItemFailure,
  GetAffiliatePaymentsItem,
  GetAffiliatePaymentsItemSuccess,
  GetAffiliatePaymentsItemFailure,
  GetAffiliateOrdersNotPaid,
  GetAffiliateOrdersNotPaidSuccess,
  GetAffiliateOrdersNotPaidFailure,
  GetAgencyCartsProgessing,
  GetAgencyCartsProgessingSuccess,
  GetAgencyCartsProgessingFailure,
  GetAgencyOrder,
  GetAgencyOrderSuccess,
  GetAgencyOrderFailure
} from './actions';

@Injectable()
export class CartEffects {
  constructor(private actions: Actions, private modelService: CartService) {}

  @Effect()
  getList$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_CARTS),
    switchMap((res: GetCartsSuccess) => {
      return this.modelService.getAll(res.payload).pipe(
        map(res2 => new GetCartsSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetCartsFailure());
        })
      );
    })
  );

  @Effect()
  getListProcessing$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_CARTS_PROCESSING),
    switchMap((res: GetCartsProgessing) => {
      return this.modelService.getAllProcessing(res.payload).pipe(
        map(res2 => new GetCartsProgessingSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetCartsProgessingFailure());
        })
      );
    })
  );

  @Effect()
  getListAgencyProcessing$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AGENCY_CARTS_PROCESSING),
    switchMap((res: GetAgencyCartsProgessing) => {
      return this.modelService.getAllAgencyOrders(res.payload).pipe(
        map(res2 => new GetAgencyCartsProgessingSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAgencyCartsProgessingFailure());
        })
      );
    })
  );

  @Effect()
  getAgencyOrders$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AGENCY_ORDERS),
    switchMap((res: GetAgencyOrders) => {
      return this.modelService.getAllAgencyOrders(res.payload).pipe(
        map(res2 => new GetAgencyOrdersSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAgencyOrdersFailure());
        })
      );
    })
  );

  @Effect()
  getAgencyOrder$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AGENCY_ORDERS_ITEM),
    switchMap((res: GetAgencyOrder) => {
      return this.modelService.getAgencyOrder(res.payload).pipe(
        map(res2 => new GetAgencyOrderSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAgencyOrderFailure());
        })
      );
    })
  );

  @Effect()
  getAgencyPayments$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AGENCY_PAYMENTS),
    switchMap((res: GetAgencyPayments) => {
      return this.modelService.getAllAgencyPayments(res.payload).pipe(
        map(res2 => new GetAgencyPaymentsSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAgencyPaymentsFailure());
        })
      );
    })
  );

  @Effect()
  getPaymentItemDetailAgency$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AGENCY_PAYMENT_ITEM),
    switchMap((res: GetAgencyPaymentsItem) => {
      return this.modelService.getPaymentItemDetailAgency(res.payload).pipe(
        map(res2 => new GetAgencyPaymentsItemSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAgencyPaymentsItemFailure());
        })
      );
    })
  );

  @Effect()
  getPaymentItemDetailAffiliate$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AFFILIATE_PAYMENT_ITEM),
    switchMap((res: GetAffiliatePaymentsItem) => {
      return this.modelService.getPaymentItemDetailAffiliate(res.payload).pipe(
        map(res2 => new GetAffiliatePaymentsItemSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAffiliatePaymentsItemFailure());
        })
      );
    })
  );

  @Effect()
  getAffiliatePayments$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AFFILIATE_PAYMENTS),
    switchMap((res: GetAffiliatePayments) => {
      return this.modelService.getAllAffiliatePayments(res.payload).pipe(
        map(res2 => new GetAffiliatePaymentsSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAffiliatePaymentsFailure());
        })
      );
    })
  );

  @Effect()
  getAgencyOrdersNotPaid$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AGENCY_ORDERS_NOT_PAID),
    switchMap((res: GetAgencyOrdersNotPaid) => {
      return this.modelService.getAgencyOrdersNotPaid(res.payload).pipe(
        map(res2 => new GetAgencyOrdersNotPaidSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAgencyOrdersNotPaidFailure());
        })
      );
    })
  );

  @Effect()
  getAffiliateOrdersNotPaid$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_AFFILIATE_ORDERS_NOT_PAID),
    switchMap((res: GetAffiliateOrdersNotPaid) => {
      return this.modelService.getAffiliateOrdersNotPaid(res.payload).pipe(
        map(res2 => new GetAffiliateOrdersNotPaidSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetAffiliateOrdersNotPaidFailure());
        })
      );
    })
  );

  @Effect()
  getOne$ = this.actions.pipe(
    ofType(CartActionsTypes.GET_CART),
    switchMap((res: GetCart) => {
      const key = res.payload;
      return this.modelService.get(key).pipe(
        map(res2 => new GetCartSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetCartFailure());
        })
      );
    })
  );

  @Effect()
  create$ = this.actions.pipe(
    ofType(CartActionsTypes.CREATE_CART),
    switchMap((data: CreateCart) => {
      return this.modelService.create(data.payload).pipe(
        map(res => new CreateCartSuccess(res)),
        catchError(err => {
          console.error(err);
          return of(new CreateCartFailure());
        })
      );
    })
  );

  @Effect()
  createFast$ = this.actions.pipe(
    ofType(CartActionsTypes.CREATE_CART_FAST),
    switchMap((data: CreateCartFast) => {
      return this.modelService.createFast(data.payload).pipe(
        map(res => new CreateCartFastSuccess(res)),
        catchError(err => {
          console.error(err);
          return of(new CreateCartFastFailure());
        })
      );
    })
  );

  @Effect()
  update$ = this.actions.pipe(
    ofType(CartActionsTypes.UPDATE_CART),
    switchMap((data: UpdateCart) => {
      return this.modelService.update(data.payload).pipe(
        map(res => new CreateCartSuccess(res)),
        catchError(err => {
          console.error(err);
          return of(new GetCartsFailure());
        })
      );
    })
  );
}
