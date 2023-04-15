import { TestBed } from '@angular/core/testing';

import { ModalExportImageService } from './modal-export-image.service';

describe('ModalExportImageService', () => {
  let service: ModalExportImageService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ModalExportImageService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
