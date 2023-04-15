import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabControlsComponent } from './tab-controls.component';

describe('TabControlsComponent', () => {
  let component: TabControlsComponent;
  let fixture: ComponentFixture<TabControlsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabControlsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabControlsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
