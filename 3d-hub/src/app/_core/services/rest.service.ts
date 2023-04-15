import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpErrorResponse, HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { ToastrService } from 'ngx-toastr';
import { environment } from '@env/environment';
import { TranslateService } from '@ngx-translate/core';

@Injectable()
export class RestService {
  baseUrl = '';
  baseUrlForm = '';

  constructor(private http: HttpClient, private toart: ToastrService, private translateService: TranslateService) {
    this.baseUrl = environment.apiUrl + 'api/';
    this.baseUrlForm = environment.apiUrl;
  }

  handleError(error: HttpErrorResponse, isShow = true) {
    if (isShow) {
      let errMsg = '';
      if (error.error) {
        errMsg = error.error.message || error.error.statusText;
      } else {
        errMsg = error.message || error.statusText;
      }
      const strError = this.translateService.instant('Error') + ' ';
      this.toart.error(errMsg, strError + error.status);
    }
    return throwError(error);
  }

  displaySuccessMessage(res: any, isShow = true) {
    if (isShow) {
      const strSuccessful = this.translateService.instant('Successful') + ' ';
      const strNiceJob = this.translateService.instant('Nice Job');
      const message = res ? res.message : strNiceJob;
      this.toart.success(message, strSuccessful);
    }
    return res;
  }

  get(path: string, paramsIn = {}, showSuccess = false): Observable<any> {
    let params = new HttpParams();
    Object.keys(paramsIn).forEach((key) => {
      if (paramsIn[key] !== undefined) {
        if (Array.isArray(paramsIn[key])) {
          paramsIn[key].forEach((e) => {
            params = params.append(key, e);
          });
        } else if (typeof paramsIn[key] === 'object') {
          params = params.append(key, JSON.stringify(paramsIn[key]));
        } else {
          params = params.append(key, paramsIn[key]);
        }
      }
    });
    const headers = this.getHeader();
    return this.http.get(this.baseUrl + path, { params, headers }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  getOut(url: string, paramsIn = {}, showSuccess = false): Observable<any> {
    let params = new HttpParams();
    Object.keys(paramsIn).forEach((key) => {
      if (paramsIn[key] !== undefined) {
        if (Array.isArray(paramsIn[key])) {
          paramsIn[key].forEach((e) => {
            params = params.append(key, e);
          });
        } else if (typeof paramsIn[key] === 'object') {
          params = params.append(key, JSON.stringify(paramsIn[key]));
        } else {
          params = params.append(key, paramsIn[key]);
        }
      }
    });
    const headers = this.getHeader();
    return this.http.get(url, { params, headers }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }
  getOut2(url: string, paramsIn = {}, showSuccess = false): Observable<any> {
    let params = new HttpParams();
    Object.keys(paramsIn).forEach((key) => {
      if (paramsIn[key] !== undefined) {
        if (Array.isArray(paramsIn[key])) {
          paramsIn[key].forEach((e) => {
            params = params.append(key, e);
          });
        } else if (typeof paramsIn[key] === 'object') {
          params = params.append(key, JSON.stringify(paramsIn[key]));
        } else {
          params = params.append(key, paramsIn[key]);
        }
      }
    });
    const headers = this.getHeader();
    return this.http.get(url, { params, headers }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  put(path: string, body: any = {}, headersIn = {}, showSuccess = true): Observable<any> {
    let headers = new HttpHeaders();
    Object.keys(headersIn).forEach((key) => {
      if (headersIn[key] !== undefined) {
        headers = headers.append(key, headersIn[key].toString());
      }
    });
    return this.http.put(this.baseUrl + path, body, { headers }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  patch(path: string, body: any = {}, headersIn = {}, showSuccess = true): Observable<any> {
    let headers = new HttpHeaders();
    Object.keys(headersIn).forEach((key) => {
      if (headersIn[key] !== undefined) {
        headers = headers.append(key, headersIn[key].toString());
      }
    });
    return this.http.patch(this.baseUrl + path, body, { headers }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  post(path: string, body = {}, showSuccess = true): Observable<any> {
    return this.http.post(this.baseUrl + path, body).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  download(path: string, body = {}, showSuccess = true): Observable<any> {
    const headers = this.getHeaderDownload();
    return this.http.post(this.baseUrl + path, body, { headers, responseType: 'arraybuffer' }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  form(path: string, body = {}, showSuccess = true): Observable<any> {
    const headers = this.getHeaderForm();
    return this.http.post(this.baseUrlForm + path, body, { headers, observe: 'response' }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  formPut(path: string, body = {}, showSuccess = true): Observable<any> {
    const headers = this.getHeaderForm();
    return this.http.put(this.baseUrlForm + path, body, { headers, observe: 'response' }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  formUpload(path: string, body = {}, showSuccess = true): Observable<any> {
    const headers = this.getHeaderUpload();
    return this.http.post(this.baseUrl + path, body, { headers, observe: 'response' }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  formUploadPut(path: string, body = {}, showSuccess = true): Observable<any> {
    const headers = this.getHeaderUpload();
    return this.http.put(this.baseUrl + path, body, { headers, observe: 'response' }).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  upload(path: string, body = {}, showSuccess = true): Observable<any> {
    const headers = new HttpHeaders();
    headers.append('Content-Type', 'application/x-www-form-urlencoded');
    return this.http
      .post(this.baseUrl + path, body, {
        headers,
      })
      .pipe(
        map((res) => this.displaySuccessMessage(res, showSuccess)),
        catchError((err) => this.handleError(err))
      );
  }

  delete(path, showSuccess = true): Observable<any> {
    return this.http.delete(this.baseUrl + path).pipe(
      map((res) => this.displaySuccessMessage(res, showSuccess)),
      catchError((err) => this.handleError(err))
    );
  }

  private getHeader(): HttpHeaders {
    return new HttpHeaders({
      'Content-Type': 'application/json',
      accept: 'application/json',
      'Accept-Language': 'vi',
    });
  }

  private getHeaderS3(): HttpHeaders {
    return new HttpHeaders({
      accept: 'application/xml',
    });
  }

  private getHeaderUpload(): HttpHeaders {
    const headers = new HttpHeaders({
      // 'Content-Type':
      //   'multipart/form-data;boundary=--------------------------247697088228317249765921'
    });
    return headers;
  }

  private getHeaderDownload(): HttpHeaders {
    const headers = new HttpHeaders({
      Accept: 'application/pdf',
    });
    return headers;
  }

  private getHeaderForm(): HttpHeaders {
    const headers = new HttpHeaders({
      'Content-Type': 'application/x-www-form-urlencoded',
    });
    return headers;
  }
}
