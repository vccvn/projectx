import { TestBed } from '@angular/core/testing';

import { EditorToolbarService } from './editor-toolbar.service';

describe('EditorToolbarService', () => {
  let service: EditorToolbarService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(EditorToolbarService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
