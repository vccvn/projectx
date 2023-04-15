import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelModelObjectTabPropertiesComponent } from './panel-model-object-tab-properties.component';

describe('PanelModelObjectTabPropertiesComponent', () => {
  let component: PanelModelObjectTabPropertiesComponent;
  let fixture: ComponentFixture<PanelModelObjectTabPropertiesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelModelObjectTabPropertiesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelModelObjectTabPropertiesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
