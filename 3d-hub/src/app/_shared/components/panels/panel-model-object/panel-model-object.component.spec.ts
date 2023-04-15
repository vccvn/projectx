import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanelModelObjectComponent } from './panel-model-object.component';

describe('PanelModelObjectComponent', () => {
  let component: PanelModelObjectComponent;
  let fixture: ComponentFixture<PanelModelObjectComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanelModelObjectComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanelModelObjectComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
