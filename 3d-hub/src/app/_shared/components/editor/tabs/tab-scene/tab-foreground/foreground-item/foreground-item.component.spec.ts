import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ForegroundItemComponent } from './foreground-item.component';

describe('ForegroundItemComponent', () => {
  let component: ForegroundItemComponent;
  let fixture: ComponentFixture<ForegroundItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ForegroundItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ForegroundItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
