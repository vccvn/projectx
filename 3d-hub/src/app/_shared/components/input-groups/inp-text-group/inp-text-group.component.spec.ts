import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpTextGroupComponent } from './inp-text-group.component';

describe('InpTextGroupComponent', () => {
  let component: InpTextGroupComponent;
  let fixture: ComponentFixture<InpTextGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpTextGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpTextGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
