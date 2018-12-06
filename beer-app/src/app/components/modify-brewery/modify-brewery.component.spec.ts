import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyBreweryComponent } from './modify-brewery.component';

describe('ModifyBreweryComponent', () => {
  let component: ModifyBreweryComponent;
  let fixture: ComponentFixture<ModifyBreweryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModifyBreweryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModifyBreweryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
