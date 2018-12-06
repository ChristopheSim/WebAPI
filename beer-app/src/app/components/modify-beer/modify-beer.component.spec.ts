import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifyBeerComponent } from './modify-beer.component';

describe('ModifyBeerComponent', () => {
  let component: ModifyBeerComponent;
  let fixture: ComponentFixture<ModifyBeerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModifyBeerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModifyBeerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
