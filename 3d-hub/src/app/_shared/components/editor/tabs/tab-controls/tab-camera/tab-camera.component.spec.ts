import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabCameraComponent } from './tab-camera.component';

describe('TabCameraComponent', () => {
  let component: TabCameraComponent;
  let fixture: ComponentFixture<TabCameraComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabCameraComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabCameraComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
