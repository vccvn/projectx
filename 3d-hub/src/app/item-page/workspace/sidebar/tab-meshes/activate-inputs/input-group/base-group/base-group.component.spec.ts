import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BaseGroupComponent } from './base-group.component';

describe('BaseGroupComponent', () => {
  let component: BaseGroupComponent;
  let fixture: ComponentFixture<BaseGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BaseGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BaseGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
