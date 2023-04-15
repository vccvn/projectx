import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ViewerSidebarComponent } from './viewer-sidebar.component';

describe('ViewerSidebarComponent', () => {
  let component: ViewerSidebarComponent;
  let fixture: ComponentFixture<ViewerSidebarComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ViewerSidebarComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ViewerSidebarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
