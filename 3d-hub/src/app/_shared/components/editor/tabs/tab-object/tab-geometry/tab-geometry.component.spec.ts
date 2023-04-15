import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabGeometryComponent } from './tab-geometry.component';

describe('TabGeometryComponent', () => {
  let component: TabGeometryComponent;
  let fixture: ComponentFixture<TabGeometryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabGeometryComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabGeometryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
