import { Injectable } from '@angular/core';

@Injectable()
export class TypesUtilsService {
  padNumber(value: number) {
    if (this.isNumber(value)) {
      return `0${value}`.slice(-2);
    } else {
      return '';
    }
  }

  isNumber(value: any): boolean {
    return !isNaN(this.toInteger(value));
  }

  toInteger(value: any): number {
    return parseInt(`${value}`, 10);
  }

  dateFormat(date: Date): string {
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const year = date.getFullYear();
    if (date) {
      return `${month}/${day}/${year}`;
    }

    return '';
  }

  dateCustomFormat(date: any): string {
    let stringDate = '';
    if (date) {
      stringDate += this.isNumber(date.month) ? this.padNumber(date.month) + '/' : '';
      stringDate += this.isNumber(date.day) ? this.padNumber(date.day) + '/' : '';

      stringDate += date.year;
    }
    return stringDate;
  }

  getDateFormatterFromString(dateInStr: string): any {
    if (dateInStr && dateInStr.length > 0) {
      const dateParts = dateInStr.trim().split('/');
      return [
        {
          year: this.toInteger(dateParts[2]),
          month: this.toInteger(dateParts[0]),
          day: this.toInteger(dateParts[1]),
        },
      ];
    }

    const date = new Date();
    return [
      {
        year: date.getFullYear(),
        month: date.getMonth() + 1,
        day: date.getDay(),
      },
    ];
  }

  getDateFromString(dateInStr = ''): Date {
    if (dateInStr && dateInStr.length > 0) {
      const dateParts = dateInStr.trim().split('/');
      const year = this.toInteger(dateParts[2]);
      const month = this.toInteger(dateParts[0]);
      const day = this.toInteger(dateParts[1]);
      // tslint:disable-next-line:prefer-const
      let result = new Date();
      result.setDate(day);
      result.setMonth(month - 1);
      result.setFullYear(year);
      return result;
    }

    return new Date();
  }

  getDateStringFromDate(date: Date = new Date()): string {
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    const newDate = date.getDate();
    return `${month}/${newDate}/${year}`;
  }
}
