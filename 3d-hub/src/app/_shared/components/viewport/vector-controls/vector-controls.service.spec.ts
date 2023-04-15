import { TestBed } from '@angular/core/testing';

import { VectorControlsService } from './vector-controls.service';

describe('VectorControlsService', () => {
  let service: VectorControlsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(VectorControlsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
