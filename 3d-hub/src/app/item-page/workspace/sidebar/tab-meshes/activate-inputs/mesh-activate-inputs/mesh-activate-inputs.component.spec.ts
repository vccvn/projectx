import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeshActivateInputsComponent } from './mesh-activate-inputs.component';

describe('MeshActivateInputsComponent', () => {
  let component: MeshActivateInputsComponent;
  let fixture: ComponentFixture<MeshActivateInputsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MeshActivateInputsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MeshActivateInputsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
