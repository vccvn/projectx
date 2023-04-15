import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SidebarLockComponent } from './sidebar-lock.component';

describe('SidebarLockComponent', () => {
  let component: SidebarLockComponent;
  let fixture: ComponentFixture<SidebarLockComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SidebarLockComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SidebarLockComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
