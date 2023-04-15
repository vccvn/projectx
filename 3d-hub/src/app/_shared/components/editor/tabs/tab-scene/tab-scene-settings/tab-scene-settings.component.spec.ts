import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabSceneSettingsComponent } from './tab-scene-settings.component';

describe('TabSceneSettingsComponent', () => {
  let component: TabSceneSettingsComponent;
  let fixture: ComponentFixture<TabSceneSettingsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabSceneSettingsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabSceneSettingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
