import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TransparentImgComponent } from './transparent-img.component';

describe('TransparentImgComponent', () => {
  let component: TransparentImgComponent;
  let fixture: ComponentFixture<TransparentImgComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TransparentImgComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TransparentImgComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
