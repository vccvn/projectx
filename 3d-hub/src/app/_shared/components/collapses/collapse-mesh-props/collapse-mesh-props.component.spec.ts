import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CollapseMeshPropsComponent } from './collapse-mesh-props.component';

describe('CollapseMeshPropsComponent', () => {
  let component: CollapseMeshPropsComponent;
  let fixture: ComponentFixture<CollapseMeshPropsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CollapseMeshPropsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CollapseMeshPropsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
