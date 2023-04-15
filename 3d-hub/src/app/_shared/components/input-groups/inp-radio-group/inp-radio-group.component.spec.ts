import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpRadioGroupComponent } from './inp-radio-group.component';

describe('InpRadioGroupComponent', () => {
  let component: InpRadioGroupComponent;
  let fixture: ComponentFixture<InpRadioGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpRadioGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpRadioGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
