import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal-delete-beer',
  templateUrl: './modal-delete-beer.component.html',
  styleUrls: ['./modal-delete-beer.component.css']
})
export class ModalDeleteBeerComponent implements OnInit {
  @Output() delete: EventEmitter<any> = new EventEmitter();
  @Output() cancel: EventEmitter<any> = new EventEmitter();

  constructor() { }

  ngOnInit() {
  }

  deleteBeer() {
    this.delete.emit(null);
  }

  cancelDeleteBeer() {
    this.cancel.emit(null);
  }

}
