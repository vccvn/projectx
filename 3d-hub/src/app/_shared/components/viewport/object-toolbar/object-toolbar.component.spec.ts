import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ObjectToolbarComponent } from './object-toolbar.component';

describe('ObjectToolbarComponent', () => {
  let component: ObjectToolbarComponent;
  let fixture: ComponentFixture<ObjectToolbarComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ObjectToolbarComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ObjectToolbarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
