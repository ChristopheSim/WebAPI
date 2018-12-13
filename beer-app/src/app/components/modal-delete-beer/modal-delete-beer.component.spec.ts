import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalDeleteBeerComponent } from './modal-delete-beer.component';

describe('ModalDeleteBeerComponent', () => {
  let component: ModalDeleteBeerComponent;
  let fixture: ComponentFixture<ModalDeleteBeerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalDeleteBeerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalDeleteBeerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
