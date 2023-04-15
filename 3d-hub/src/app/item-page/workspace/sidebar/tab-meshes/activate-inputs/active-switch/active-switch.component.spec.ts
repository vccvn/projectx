import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActiveSwitchComponent } from './active-switch.component';

describe('ActiveSwitchComponent', () => {
  let component: ActiveSwitchComponent;
  let fixture: ComponentFixture<ActiveSwitchComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActiveSwitchComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActiveSwitchComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
