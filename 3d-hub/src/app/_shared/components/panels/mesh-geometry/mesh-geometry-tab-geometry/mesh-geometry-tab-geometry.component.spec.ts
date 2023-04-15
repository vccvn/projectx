import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeshGeometryTabGeometryComponent } from './mesh-geometry-tab-geometry.component';

describe('MeshGeometryTabGeometryComponent', () => {
  let component: MeshGeometryTabGeometryComponent;
  let fixture: ComponentFixture<MeshGeometryTabGeometryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MeshGeometryTabGeometryComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MeshGeometryTabGeometryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
