import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelLightTabParamsComponent } from './panel-light-tab-params.component';

describe('PanelLightTabParamsComponent', () => {
  let component: PanelLightTabParamsComponent;
  let fixture: ComponentFixture<PanelLightTabParamsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelLightTabParamsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelLightTabParamsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
