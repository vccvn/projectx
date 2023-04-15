import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MaterialInputsComponent } from './material-inputs.component';

describe('MaterialInputsComponent', () => {
  let component: MaterialInputsComponent;
  let fixture: ComponentFixture<MaterialInputsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MaterialInputsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MaterialInputsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
