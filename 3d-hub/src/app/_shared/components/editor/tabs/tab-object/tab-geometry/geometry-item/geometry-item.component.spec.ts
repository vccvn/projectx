import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GeometryItemComponent } from './geometry-item.component';

describe('GeometryItemComponent', () => {
  let component: GeometryItemComponent;
  let fixture: ComponentFixture<GeometryItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ GeometryItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(GeometryItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
