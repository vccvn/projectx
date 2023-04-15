import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelMeshCustomizeComponent } from './panel-mesh-customize.component';

describe('PanelMeshCustomizeComponent', () => {
  let component: PanelMeshCustomizeComponent;
  let fixture: ComponentFixture<PanelMeshCustomizeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelMeshCustomizeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelMeshCustomizeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
