import { TestBed } from '@angular/core/testing';

import { LostQueryService } from './lost-query.service';

describe('LostQueryService', () => {
  let service: LostQueryService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(LostQueryService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
