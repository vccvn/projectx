import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActivateColorComponent } from './activate-color.component';

describe('ActivateColorComponent', () => {
  let component: ActivateColorComponent;
  let fixture: ComponentFixture<ActivateColorComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActivateColorComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActivateColorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
