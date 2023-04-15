import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActivateSelectComponent } from './activate-select.component';

describe('ActivateSelectComponent', () => {
  let component: ActivateSelectComponent;
  let fixture: ComponentFixture<ActivateSelectComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActivateSelectComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActivateSelectComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
