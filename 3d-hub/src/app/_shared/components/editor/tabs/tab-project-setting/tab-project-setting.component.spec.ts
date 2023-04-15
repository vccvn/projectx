import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabProjectSettingComponent } from './tab-project-setting.component';

describe('TabProjectSettingComponent', () => {
  let component: TabProjectSettingComponent;
  let fixture: ComponentFixture<TabProjectSettingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabProjectSettingComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabProjectSettingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
