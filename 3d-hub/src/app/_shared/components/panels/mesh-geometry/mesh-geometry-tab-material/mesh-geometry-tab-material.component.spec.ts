import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeshGeometryTabMaterialComponent } from './mesh-geometry-tab-material.component';

describe('MeshGeometryTabMaterialComponent', () => {
  let component: MeshGeometryTabMaterialComponent;
  let fixture: ComponentFixture<MeshGeometryTabMaterialComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MeshGeometryTabMaterialComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MeshGeometryTabMaterialComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
