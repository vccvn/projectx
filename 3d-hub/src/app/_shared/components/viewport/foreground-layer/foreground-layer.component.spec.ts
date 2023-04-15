import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ForegroundLayerComponent } from './foreground-layer.component';

describe('ForegroundLayerComponent', () => {
  let component: ForegroundLayerComponent;
  let fixture: ComponentFixture<ForegroundLayerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ForegroundLayerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ForegroundLayerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
