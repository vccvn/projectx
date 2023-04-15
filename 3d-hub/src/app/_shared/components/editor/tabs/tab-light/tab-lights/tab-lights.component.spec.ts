import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabLightsComponent } from './tab-lights.component';

describe('TabLightsComponent', () => {
  let component: TabLightsComponent;
  let fixture: ComponentFixture<TabLightsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabLightsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabLightsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
