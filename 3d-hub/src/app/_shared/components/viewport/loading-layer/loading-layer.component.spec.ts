import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LoadingLayerComponent } from './loading-layer.component';

describe('LoadingLayerComponent', () => {
  let component: LoadingLayerComponent;
  let fixture: ComponentFixture<LoadingLayerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LoadingLayerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(LoadingLayerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
