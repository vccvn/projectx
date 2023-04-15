import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MaterialActivateInputsComponent } from './material-activate-inputs.component';

describe('MaterialActivateInputsComponent', () => {
  let component: MaterialActivateInputsComponent;
  let fixture: ComponentFixture<MaterialActivateInputsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MaterialActivateInputsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MaterialActivateInputsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
