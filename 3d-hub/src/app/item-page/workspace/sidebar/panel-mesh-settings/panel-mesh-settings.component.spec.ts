import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelMeshSettingsComponent } from './panel-mesh-settings.component';

describe('PanelMeshSettingsComponent', () => {
  let component: PanelMeshSettingsComponent;
  let fixture: ComponentFixture<PanelMeshSettingsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelMeshSettingsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelMeshSettingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
