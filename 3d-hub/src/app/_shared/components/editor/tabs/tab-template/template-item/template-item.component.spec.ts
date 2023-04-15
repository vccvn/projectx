import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TemplateItemComponent } from './template-item.component';

describe('TemplateItemComponent', () => {
  let component: TemplateItemComponent;
  let fixture: ComponentFixture<TemplateItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TemplateItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TemplateItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
