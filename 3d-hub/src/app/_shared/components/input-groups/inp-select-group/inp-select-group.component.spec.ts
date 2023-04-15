import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpSelectGroupComponent } from './inp-select-group.component';

describe('InpSelectGroupComponent', () => {
  let component: InpSelectGroupComponent;
  let fixture: ComponentFixture<InpSelectGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpSelectGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpSelectGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
