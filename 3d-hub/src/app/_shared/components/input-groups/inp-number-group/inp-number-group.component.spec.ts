import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpNumberGroupComponent } from './inp-number-group.component';

describe('InpNumberGroupComponent', () => {
  let component: InpNumberGroupComponent;
  let fixture: ComponentFixture<InpNumberGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpNumberGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpNumberGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
