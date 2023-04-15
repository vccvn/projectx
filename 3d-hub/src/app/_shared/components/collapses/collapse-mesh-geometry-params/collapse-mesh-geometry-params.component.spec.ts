import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CollapseMeshGeometryParamsComponent } from './collapse-mesh-geometry-params.component';

describe('CollapseMeshGeometryParamsComponent', () => {
  let component: CollapseMeshGeometryParamsComponent;
  let fixture: ComponentFixture<CollapseMeshGeometryParamsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CollapseMeshGeometryParamsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CollapseMeshGeometryParamsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
