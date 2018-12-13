import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal-delete-type',
  templateUrl: './modal-delete-type.component.html',
  styleUrls: ['./modal-delete-type.component.css']
})
export class ModalDeleteTypeComponent implements OnInit {
  @Output() delete: EventEmitter<any> = new EventEmitter();
  @Output() cancel: EventEmitter<any> = new EventEmitter();

  constructor() { }

  ngOnInit() {
  }

  deleteType() {
    this.delete.emit(null);
  }

  cancelDeleteType() {
    this.cancel.emit(null);
  }

}
