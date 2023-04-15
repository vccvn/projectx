import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpRadioComponent } from './inp-radio.component';

describe('InpRadioComponent', () => {
  let component: InpRadioComponent;
  let fixture: ComponentFixture<InpRadioComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpRadioComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpRadioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
