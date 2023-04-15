export class NotificationParamsModel {
  // fields
  filter: any;
  sortOrder: string; // asc || desc
  sortField: string;
  pageNumber: number;
  limit: number;

  // constructor overrides
  constructor(filter: any, sortOrder = 'asc', sortField = '', pageNumber = 0, limit = 10) {
    this.filter = filter;
    this.sortOrder = sortOrder;
    this.sortField = sortField;
    this.pageNumber = pageNumber;
    this.limit = limit;
  }
}
