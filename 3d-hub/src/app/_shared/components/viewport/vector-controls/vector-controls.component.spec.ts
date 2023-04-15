import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VectorControlsComponent } from './vector-controls.component';

describe('VectorControlsComponent', () => {
  let component: VectorControlsComponent;
  let fixture: ComponentFixture<VectorControlsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ VectorControlsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(VectorControlsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
