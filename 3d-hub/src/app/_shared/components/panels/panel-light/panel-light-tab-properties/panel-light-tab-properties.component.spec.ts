import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelLightTabPropertiesComponent } from './panel-light-tab-properties.component';

describe('PanelLightTabPropertiesComponent', () => {
  let component: PanelLightTabPropertiesComponent;
  let fixture: ComponentFixture<PanelLightTabPropertiesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelLightTabPropertiesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelLightTabPropertiesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
