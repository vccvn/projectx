import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PropInputsComponent } from './prop-inputs.component';

describe('PropInputsComponent', () => {
  let component: PropInputsComponent;
  let fixture: ComponentFixture<PropInputsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PropInputsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PropInputsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
