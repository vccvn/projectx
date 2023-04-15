import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActivateCheckboxComponent } from './activate-checkbox.component';

describe('ActivateCheckboxComponent', () => {
  let component: ActivateCheckboxComponent;
  let fixture: ComponentFixture<ActivateCheckboxComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActivateCheckboxComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActivateCheckboxComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
