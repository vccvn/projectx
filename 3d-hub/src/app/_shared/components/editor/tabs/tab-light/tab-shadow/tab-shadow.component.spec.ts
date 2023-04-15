import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabShadowComponent } from './tab-shadow.component';

describe('TabShadowComponent', () => {
  let component: TabShadowComponent;
  let fixture: ComponentFixture<TabShadowComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabShadowComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabShadowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
