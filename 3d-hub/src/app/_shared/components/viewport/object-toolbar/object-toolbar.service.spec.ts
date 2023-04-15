import { TestBed } from '@angular/core/testing';

import { ObjectToolbarService } from './object-toolbar.service';

describe('ObjectToolbarService', () => {
  let service: ObjectToolbarService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ObjectToolbarService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
