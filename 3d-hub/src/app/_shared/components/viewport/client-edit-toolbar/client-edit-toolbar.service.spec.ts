import { TestBed } from '@angular/core/testing';

import { ClientEditToolbarService } from './client-edit-toolbar.service';

describe('ClientEditToolbarService', () => {
  let service: ClientEditToolbarService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ClientEditToolbarService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
