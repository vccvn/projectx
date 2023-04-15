export class TemplateParamsModel {
  filter: any;
  sortOrder: string;
  sortField: string;
  pageNumber: number;
  count?: number;

  constructor(filter: any, sortOrder = 'ASC', sortField = '', pageNumber = 0, limit = 10) {
    this.filter = filter;
    this.sortOrder = sortOrder;
    this.sortField = sortField;
    this.pageNumber = pageNumber;
  }
}
