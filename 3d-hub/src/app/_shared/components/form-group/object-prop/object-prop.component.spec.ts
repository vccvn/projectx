import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ObjectPropComponent } from './object-prop.component';

describe('ObjectPropComponent', () => {
  let component: ObjectPropComponent;
  let fixture: ComponentFixture<ObjectPropComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ObjectPropComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ObjectPropComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
