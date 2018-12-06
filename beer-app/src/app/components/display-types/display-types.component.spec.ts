import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TypesComponent } from './display-types.component';

describe('DisplayTypesComponent', () => {
  let component: DisplayTypesComponent;
  let fixture: ComponentFixture<DisplayTypesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DisplayTypesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DisplayTypesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
