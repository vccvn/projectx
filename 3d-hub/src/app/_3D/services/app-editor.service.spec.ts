import { TestBed } from '@angular/core/testing';

import { AppEditorService } from './app-editor.service';

describe('AppEditorService', () => {
  let service: AppEditorService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AppEditorService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
