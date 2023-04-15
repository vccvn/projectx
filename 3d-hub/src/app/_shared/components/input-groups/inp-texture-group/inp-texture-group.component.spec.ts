import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpTextureGroupComponent } from './inp-texture-group.component';

describe('InpTextureGroupComponent', () => {
  let component: InpTextureGroupComponent;
  let fixture: ComponentFixture<InpTextureGroupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpTextureGroupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpTextureGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
