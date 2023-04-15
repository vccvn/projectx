import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Vector3Component } from './vector3.component';

describe('Vector3Component', () => {
  let component: Vector3Component;
  let fixture: ComponentFixture<Vector3Component>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ Vector3Component ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(Vector3Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
