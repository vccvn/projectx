import { TestBed } from '@angular/core/testing';

import { PanelModelObjectService } from './panel-model-object.service';

describe('PanelModelObjectService', () => {
  let service: PanelModelObjectService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PanelModelObjectService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
