import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DraggingItemComponent } from './dragging-item.component';

describe('DraggingItemComponent', () => {
  let component: DraggingItemComponent;
  let fixture: ComponentFixture<DraggingItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DraggingItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DraggingItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
