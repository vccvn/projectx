import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InpTextureComponent } from './inp-texture.component';

describe('InpTextureComponent', () => {
  let component: InpTextureComponent;
  let fixture: ComponentFixture<InpTextureComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InpTextureComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InpTextureComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
