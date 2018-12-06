import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateBreweryComponent } from './create-brewery.component';

describe('CreateBreweryComponent', () => {
  let component: CreateBreweryComponent;
  let fixture: ComponentFixture<CreateBreweryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreateBreweryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateBreweryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
