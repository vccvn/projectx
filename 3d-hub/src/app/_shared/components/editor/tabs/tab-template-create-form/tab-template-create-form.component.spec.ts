import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabTemplateCreateFormComponent } from './tab-template-create-form.component';

describe('TabTemplateCreateFormComponent', () => {
  let component: TabTemplateCreateFormComponent;
  let fixture: ComponentFixture<TabTemplateCreateFormComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabTemplateCreateFormComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabTemplateCreateFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
