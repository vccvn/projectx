import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LightItemComponent } from './light-item.component';

describe('LightItemComponent', () => {
  let component: LightItemComponent;
  let fixture: ComponentFixture<LightItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LightItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(LightItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
