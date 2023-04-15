import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DraggingGeometryComponent } from './dragging-geometry.component';

describe('DraggingGeometryComponent', () => {
  let component: DraggingGeometryComponent;
  let fixture: ComponentFixture<DraggingGeometryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DraggingGeometryComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DraggingGeometryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
