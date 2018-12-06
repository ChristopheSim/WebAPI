import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DisplayBreweriesComponent } from './display-breweries.component';

describe('DisplayBreweriesComponent', () => {
  let component: DisplayBreweriesComponent;
  let fixture: ComponentFixture<DisplayBreweriesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DisplayBreweriesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DisplayBreweriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
