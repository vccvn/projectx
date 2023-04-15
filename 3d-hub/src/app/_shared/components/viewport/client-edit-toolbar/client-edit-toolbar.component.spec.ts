import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ClientEditToolbarComponent } from './client-edit-toolbar.component';

describe('ClientEditToolbarComponent', () => {
  let component: ClientEditToolbarComponent;
  let fixture: ComponentFixture<ClientEditToolbarComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ClientEditToolbarComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ClientEditToolbarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
