import { Component, OnInit } from '@angular/core';
import { Beer } from '../beer';

@Component({
  selector: 'app-beers',
  templateUrl: './beers.component.html',
  styleUrls: ['./beers.component.css']
})
export class BeersComponent implements OnInit {
  delta: Beer = {
    id: 1,
    name: 'Delta',
    description: 'Bière IPA avec goûts exotiques',
    volume: 8.4,
    type: ipa,
    brewery: bbp
  };
  constructor() { }

  ngOnInit() {
  }
}
