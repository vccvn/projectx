import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpVector3GroupComponent } from './inp-vector3-group.component';

describe('InpVector3GroupComponent', () => {
  let component: InpVector3GroupComponent;
  let fixture: ComponentFixture<InpVector3GroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpVector3GroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpVector3GroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
