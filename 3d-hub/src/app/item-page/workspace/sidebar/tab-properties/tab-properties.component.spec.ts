import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabPropertiesComponent } from './tab-properties.component';

describe('TabPropertiesComponent', () => {
  let component: TabPropertiesComponent;
  let fixture: ComponentFixture<TabPropertiesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabPropertiesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabPropertiesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
