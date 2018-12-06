import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DisplayBeersComponent } from './display-beers.component';

describe('DisplayBeersComponent', () => {
  let component: DisplayBeersComponent;
  let fixture: ComponentFixture<DisplayBeersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DisplayBeersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DisplayBeersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
