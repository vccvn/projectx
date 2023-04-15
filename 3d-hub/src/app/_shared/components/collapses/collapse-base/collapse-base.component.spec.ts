import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CollapseBaseComponent } from './collapse-base.component';

describe('CollapseBaseComponent', () => {
  let component: CollapseBaseComponent;
  let fixture: ComponentFixture<CollapseBaseComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CollapseBaseComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CollapseBaseComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
