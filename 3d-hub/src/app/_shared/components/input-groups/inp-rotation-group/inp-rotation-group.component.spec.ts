import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpRotationGroupComponent } from './inp-rotation-group.component';

describe('InpRotationGroupComponent', () => {
  let component: InpRotationGroupComponent;
  let fixture: ComponentFixture<InpRotationGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpRotationGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpRotationGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
