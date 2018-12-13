import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalDeleteTypeComponent } from './modal-delete-type.component';

describe('ModalDeleteTypeComponent', () => {
  let component: ModalDeleteTypeComponent;
  let fixture: ComponentFixture<ModalDeleteTypeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalDeleteTypeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalDeleteTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
