import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CollapseMaterialComponent } from './collapse-material.component';

describe('CollapseMaterialComponent', () => {
  let component: CollapseMaterialComponent;
  let fixture: ComponentFixture<CollapseMaterialComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CollapseMaterialComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CollapseMaterialComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
