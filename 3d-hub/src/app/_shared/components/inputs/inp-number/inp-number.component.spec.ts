import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpNumberComponent } from './inp-number.component';

describe('InpNumberComponent', () => {
  let component: InpNumberComponent;
  let fixture: ComponentFixture<InpNumberComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpNumberComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpNumberComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
