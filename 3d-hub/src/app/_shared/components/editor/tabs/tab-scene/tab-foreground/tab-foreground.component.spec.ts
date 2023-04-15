import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabForegroundComponent } from './tab-foreground.component';

describe('TabForegroundComponent', () => {
  let component: TabForegroundComponent;
  let fixture: ComponentFixture<TabForegroundComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabForegroundComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabForegroundComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
