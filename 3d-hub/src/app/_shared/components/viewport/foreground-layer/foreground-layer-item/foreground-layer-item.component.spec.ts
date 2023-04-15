import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ForegroundLayerItemComponent } from './foreground-layer-item.component';

describe('ForegroundLayerItemComponent', () => {
  let component: ForegroundLayerItemComponent;
  let fixture: ComponentFixture<ForegroundLayerItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ForegroundLayerItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ForegroundLayerItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
