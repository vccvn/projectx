import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MaskLayerComponent } from './mask-layer.component';

describe('MaskLayerComponent', () => {
  let component: MaskLayerComponent;
  let fixture: ComponentFixture<MaskLayerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MaskLayerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MaskLayerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
