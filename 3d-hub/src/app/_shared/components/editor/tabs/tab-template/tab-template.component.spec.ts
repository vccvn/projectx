import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabTemplateComponent } from './tab-template.component';

describe('TabTemplateComponent', () => {
  let component: TabTemplateComponent;
  let fixture: ComponentFixture<TabTemplateComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabTemplateComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabTemplateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
