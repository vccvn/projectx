import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpTextareaComponent } from './inp-textarea.component';

describe('InpTextareaComponent', () => {
  let component: InpTextareaComponent;
  let fixture: ComponentFixture<InpTextareaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpTextareaComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpTextareaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
