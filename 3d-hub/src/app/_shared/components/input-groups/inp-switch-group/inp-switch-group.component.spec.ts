import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpSwitchGroupComponent } from './inp-switch-group.component';

describe('InpSwitchGroupComponent', () => {
  let component: InpSwitchGroupComponent;
  let fixture: ComponentFixture<InpSwitchGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpSwitchGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpSwitchGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
