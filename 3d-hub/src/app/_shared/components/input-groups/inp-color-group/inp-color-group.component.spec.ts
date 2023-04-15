import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpColorGroupComponent } from './inp-color-group.component';

describe('InpColorGroupComponent', () => {
  let component: InpColorGroupComponent;
  let fixture: ComponentFixture<InpColorGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpColorGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpColorGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
