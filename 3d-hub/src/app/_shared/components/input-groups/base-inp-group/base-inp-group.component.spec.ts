import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BaseInpGroupComponent } from './base-inp-group.component';

describe('BaseInpGroupComponent', () => {
  let component: BaseInpGroupComponent;
  let fixture: ComponentFixture<BaseInpGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BaseInpGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BaseInpGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
