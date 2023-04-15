import { TestBed } from '@angular/core/testing';

import { LostDbTableService } from './lost-db-table.service';

describe('LostDbTableService', () => {
  let service: LostDbTableService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(LostDbTableService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
