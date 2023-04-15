import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CanvasLayerComponent } from './canvas-layer.component';

describe('CanvasLayerComponent', () => {
  let component: CanvasLayerComponent;
  let fixture: ComponentFixture<CanvasLayerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CanvasLayerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CanvasLayerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
