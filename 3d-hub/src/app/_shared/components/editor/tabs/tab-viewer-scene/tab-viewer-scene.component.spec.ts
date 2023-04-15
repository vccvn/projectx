import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabViewerSceneComponent } from './tab-viewer-scene.component';

describe('TabViewerSceneComponent', () => {
  let component: TabViewerSceneComponent;
  let fixture: ComponentFixture<TabViewerSceneComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabViewerSceneComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabViewerSceneComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
