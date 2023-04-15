import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabProjectInfoComponent } from './tab-project-info.component';

describe('TabProjectInfoComponent', () => {
  let component: TabProjectInfoComponent;
  let fixture: ComponentFixture<TabProjectInfoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabProjectInfoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabProjectInfoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
