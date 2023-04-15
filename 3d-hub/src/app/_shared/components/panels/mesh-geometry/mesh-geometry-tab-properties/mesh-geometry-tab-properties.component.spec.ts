import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeshGeometryTabPropertiesComponent } from './mesh-geometry-tab-properties.component';

describe('MeshGeometryTabPropertiesComponent', () => {
  let component: MeshGeometryTabPropertiesComponent;
  let fixture: ComponentFixture<MeshGeometryTabPropertiesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MeshGeometryTabPropertiesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MeshGeometryTabPropertiesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
