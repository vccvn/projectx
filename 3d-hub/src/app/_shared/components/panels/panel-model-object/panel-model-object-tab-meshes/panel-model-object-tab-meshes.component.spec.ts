import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelModelObjectTabMeshesComponent } from './panel-model-object-tab-meshes.component';

describe('PanelModelObjectTabMeshesComponent', () => {
  let component: PanelModelObjectTabMeshesComponent;
  let fixture: ComponentFixture<PanelModelObjectTabMeshesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelModelObjectTabMeshesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelModelObjectTabMeshesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
