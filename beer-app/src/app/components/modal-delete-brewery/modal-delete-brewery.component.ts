import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal-delete-brewery',
  templateUrl: './modal-delete-brewery.component.html',
  styleUrls: ['./modal-delete-brewery.component.css']
})
export class ModalDeleteBreweryComponent implements OnInit {
  @Output() delete: EventEmitter<any> = new EventEmitter();
  @Output() cancel: EventEmitter<any> = new EventEmitter();

  constructor() { }

  ngOnInit() {
  }

  deleteBrewery() {
    this.delete.emit(null);
  }

  cancelDeleteBrewery() {
    this.cancel.emit(null);
  }

}
