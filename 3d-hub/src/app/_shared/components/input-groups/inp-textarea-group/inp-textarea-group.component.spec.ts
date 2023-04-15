import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpTextareaGroupComponent } from './inp-textarea-group.component';

describe('InpTextareaGroupComponent', () => {
  let component: InpTextareaGroupComponent;
  let fixture: ComponentFixture<InpTextareaGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpTextareaGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpTextareaGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
