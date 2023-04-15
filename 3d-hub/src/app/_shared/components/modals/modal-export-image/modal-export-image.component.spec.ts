import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalExportImageComponent } from './modal-export-image.component';

describe('ModalExportImageComponent', () => {
  let component: ModalExportImageComponent;
  let fixture: ComponentFixture<ModalExportImageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ModalExportImageComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalExportImageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
