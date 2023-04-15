import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DroppableAreaComponent } from './droppable-area.component';

describe('DroppableAreaComponent', () => {
  let component: DroppableAreaComponent;
  let fixture: ComponentFixture<DroppableAreaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DroppableAreaComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DroppableAreaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
