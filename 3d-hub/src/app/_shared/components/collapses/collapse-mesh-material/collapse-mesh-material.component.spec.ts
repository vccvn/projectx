import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CollapseMeshMaterialComponent } from './collapse-mesh-material.component';

describe('CollapseMeshMaterialComponent', () => {
  let component: CollapseMeshMaterialComponent;
  let fixture: ComponentFixture<CollapseMeshMaterialComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CollapseMeshMaterialComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CollapseMeshMaterialComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
