import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpRangeComponent } from './inp-range.component';

describe('InpRangeComponent', () => {
  let component: InpRangeComponent;
  let fixture: ComponentFixture<InpRangeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpRangeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpRangeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
