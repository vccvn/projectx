import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpTextComponent } from './inp-text.component';

describe('InpTextComponent', () => {
  let component: InpTextComponent;
  let fixture: ComponentFixture<InpTextComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpTextComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpTextComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
