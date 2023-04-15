import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DroppableLayerComponent } from './droppable-layer.component';

describe('DroppableLayerComponent', () => {
  let component: DroppableLayerComponent;
  let fixture: ComponentFixture<DroppableLayerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DroppableLayerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DroppableLayerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
