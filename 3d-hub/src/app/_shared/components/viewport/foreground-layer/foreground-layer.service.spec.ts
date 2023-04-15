import { TestBed } from '@angular/core/testing';

import { ForegroundLayerService } from './foreground-layer.service';

describe('ForegroundLayerService', () => {
  let service: ForegroundLayerService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ForegroundLayerService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
