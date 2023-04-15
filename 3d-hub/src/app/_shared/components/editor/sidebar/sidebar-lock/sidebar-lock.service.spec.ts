import { TestBed } from '@angular/core/testing';

import { SidebarLockService } from './sidebar-lock.service';

describe('SidebarLockService', () => {
  let service: SidebarLockService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(SidebarLockService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
