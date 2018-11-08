import { Component, OnInit } from '@angular/core';
import { Type } from '../type';

@Component({
  selector: 'app-types',
  templateUrl: './types.component.html',
  styleUrls: ['./types.component.css']
})
export class TypesComponent implements OnInit {
  ipa: Type = {
    id: 1,
    name: 'IPA',
    description: 'Bière amère et légèrement fruitée',
    beers: [delta]
  }
  constructor() { }

  ngOnInit() {
  }
}
