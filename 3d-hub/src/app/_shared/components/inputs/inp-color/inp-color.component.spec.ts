import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpColorComponent } from './inp-color.component';

describe('InpColorComponent', () => {
  let component: InpColorComponent;
  let fixture: ComponentFixture<InpColorComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpColorComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpColorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
