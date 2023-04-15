import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelLightComponent } from './panel-light.component';

describe('PanelLightComponent', () => {
  let component: PanelLightComponent;
  let fixture: ComponentFixture<PanelLightComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelLightComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelLightComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
