import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeshGeometryComponent } from './mesh-geometry.component';

describe('MeshGeometryComponent', () => {
  let component: MeshGeometryComponent;
  let fixture: ComponentFixture<MeshGeometryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MeshGeometryComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MeshGeometryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
