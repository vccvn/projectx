import { TestBed } from '@angular/core/testing';

import { LostDbService } from './lost-db.service';

describe('LostDbService', () => {
  let service: LostDbService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(LostDbService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
