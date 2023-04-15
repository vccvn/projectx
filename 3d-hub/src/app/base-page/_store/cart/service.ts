import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RestService } from '../../../_core/services/rest.service';

import { CartModel } from './model';
import { CartResultsModel, CartResultModel, CartFastResultModel } from './results.model';

const API_CUSTOMERS_URL = '/affiliate/carts';

@Injectable()
export class CartService {
  constructor(private restService: RestService) {}

  getAll(params: {}): Observable<CartResultsModel> {
    return this.restService.get(API_CUSTOMERS_URL, params);
  }
  getAllProcessing(params: {}): Observable<CartResultsModel> {
    return this.restService.get('/affiliate/processing-carts', params);
  }

  getAllAgencyOrders(params: {}): Observable<CartResultsModel> {
    return this.restService.get('/agency/orders', params);
  }

  getAgencyOrder(id: number): Observable<CartResultsModel> {
    return this.restService.get('/reservation/' + id);
  }

  getAllAgencyPayments(params: {}): Observable<CartResultsModel> {
    return this.restService.get('/agency/payment', params);
  }

  getPaymentItemDetailAgency(paymentId: number): Observable<CartResultModel> {
    return this.restService.get(`/agency/payment/${paymentId}`);
  }

  getPaymentItemDetailAffiliate(paymentId: number): Observable<CartResultModel> {
    return this.restService.get(`/agency/receivable-order/${paymentId}`);
  }

  getAllAffiliatePayments(params: {}): Observable<CartResultsModel> {
    return this.restService.get('/agency/receivable-order', params);
  }

  getAgencyOrdersNotPaid(values: any): Observable<CartResultsModel> {
    return this.restService.get('/agency/sim-not-paid', values);
  }

  getAffiliateOrdersNotPaid(values: any): Observable<CartResultsModel> {
    return this.restService.get('/agency/receivable-not-received', values);
  }

  get(key): Observable<CartResultModel> {
    return this.restService.get('/affiliate/cart' + '/' + key);
  }

  create(model: CartModel): Observable<CartResultModel> {
    return this.restService.post(API_CUSTOMERS_URL, model);
  }

  createFast(model: CartModel): Observable<CartFastResultModel> {
    return this.restService.post('/affiliate/new-cart', model);
  }

  update(model: CartModel): Observable<CartResultModel> {
    const key = model.id;
    return this.restService.put(`${API_CUSTOMERS_URL}/${key}`, model);
  }

  delete(key): Observable<CartResultModel> {
    return this.restService.delete(`${API_CUSTOMERS_URL}/${key}`);
  }

  payCart(values: { cartId: number }): Observable<CartResultModel> {
    return this.restService.post('/affiliate/pay-cart', values);
  }

  orderCart(values: { cartId: number }): Observable<CartResultModel> {
    return this.restService.post('/affiliate/place-order', values);
  }

  cancelCart(values: { cartId: number }): Observable<CartResultModel> {
    return this.restService.post('/affiliate/cancel-cart', values);
  }

  approveOrder(values: { orderId: number }): Observable<CartResultModel> {
    return this.restService.post('/agency/approve-order', values);
  }

  cancelOrder(values: { orderId: number }): Observable<CartResultModel> {
    return this.restService.post('/agency/cancel-order', values);
  }

  paymentAgency(values: any): Observable<CartResultModel> {
    return this.restService.post('/agency/payment', values);
  }

  receiveAffiliate(values: any): Observable<CartResultModel> {
    return this.restService.post('/agency/create-receivable-order', values);
  }
}
