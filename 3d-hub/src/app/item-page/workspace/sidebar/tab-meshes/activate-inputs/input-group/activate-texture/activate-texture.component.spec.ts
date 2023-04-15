import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActivateTextureComponent } from './activate-texture.component';

describe('ActivateTextureComponent', () => {
  let component: ActivateTextureComponent;
  let fixture: ComponentFixture<ActivateTextureComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActivateTextureComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActivateTextureComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
