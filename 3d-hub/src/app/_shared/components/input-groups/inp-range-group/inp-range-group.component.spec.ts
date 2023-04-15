import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpRangeGroupComponent } from './inp-range-group.component';

describe('InpRangeGroupComponent', () => {
  let component: InpRangeGroupComponent;
  let fixture: ComponentFixture<InpRangeGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpRangeGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpRangeGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
