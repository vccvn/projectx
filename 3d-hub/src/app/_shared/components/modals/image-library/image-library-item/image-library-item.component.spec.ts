import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ImageLibraryItemComponent } from './image-library-item.component';

describe('ImageLibraryItemComponent', () => {
  let component: ImageLibraryItemComponent;
  let fixture: ComponentFixture<ImageLibraryItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ImageLibraryItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ImageLibraryItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
