import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TabMeshesComponent } from './tab-meshes.component';

describe('TabMeshesComponent', () => {
  let component: TabMeshesComponent;
  let fixture: ComponentFixture<TabMeshesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TabMeshesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TabMeshesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
