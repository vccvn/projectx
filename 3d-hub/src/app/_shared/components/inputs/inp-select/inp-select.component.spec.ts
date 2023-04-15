import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpSelectComponent } from './inp-select.component';

describe('InpSelectComponent', () => {
  let component: InpSelectComponent;
  let fixture: ComponentFixture<InpSelectComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpSelectComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpSelectComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
