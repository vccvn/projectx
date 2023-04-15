import { TestBed } from '@angular/core/testing';

import { PanelLightService } from './panel-light.service';

describe('PanelLightService', () => {
  let service: PanelLightService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PanelLightService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
