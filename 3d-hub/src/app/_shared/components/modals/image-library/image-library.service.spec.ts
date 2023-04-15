import { TestBed } from '@angular/core/testing';

import { ImageLibraryService } from './image-library.service';

describe('ImageLibraryService', () => {
  let service: ImageLibraryService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ImageLibraryService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
