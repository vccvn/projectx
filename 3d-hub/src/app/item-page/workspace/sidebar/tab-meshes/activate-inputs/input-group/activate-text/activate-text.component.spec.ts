import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActivateTextComponent } from './activate-text.component';

describe('ActivateTextComponent', () => {
  let component: ActivateTextComponent;
  let fixture: ComponentFixture<ActivateTextComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActivateTextComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActivateTextComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
