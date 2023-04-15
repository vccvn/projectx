import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabBackgroundComponent } from './tab-background.component';

describe('TabBackgroundComponent', () => {
  let component: TabBackgroundComponent;
  let fixture: ComponentFixture<TabBackgroundComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabBackgroundComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabBackgroundComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
