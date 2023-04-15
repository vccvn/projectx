import { TestBed } from '@angular/core/testing';

import { MeshGeometryService } from './mesh-geometry.service';

describe('MeshGeometryService', () => {
  let service: MeshGeometryService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MeshGeometryService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
