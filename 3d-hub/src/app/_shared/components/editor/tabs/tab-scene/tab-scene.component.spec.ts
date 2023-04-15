import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabSceneComponent } from './tab-scene.component';

describe('TabSceneComponent', () => {
  let component: TabSceneComponent;
  let fixture: ComponentFixture<TabSceneComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabSceneComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabSceneComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
