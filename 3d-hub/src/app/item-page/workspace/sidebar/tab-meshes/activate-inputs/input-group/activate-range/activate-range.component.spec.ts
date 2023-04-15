import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActivateRangeComponent } from './activate-range.component';

describe('ActivateRangeComponent', () => {
  let component: ActivateRangeComponent;
  let fixture: ComponentFixture<ActivateRangeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActivateRangeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActivateRangeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
