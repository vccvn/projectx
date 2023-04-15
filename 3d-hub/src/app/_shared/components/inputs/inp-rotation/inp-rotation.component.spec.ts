import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpRotationComponent } from './inp-rotation.component';

describe('InpRotationComponent', () => {
  let component: InpRotationComponent;
  let fixture: ComponentFixture<InpRotationComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpRotationComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpRotationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
