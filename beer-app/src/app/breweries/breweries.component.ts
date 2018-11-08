import { Component, OnInit } from '@angular/core';
import { Brewery } from '../brewery';

@Component({
  selector: 'app-breweries',
  templateUrl: './breweries.component.html',
  styleUrls: ['./breweries.component.css']
})
export class BreweriesComponent implements OnInit {
  bbp: Brewery = {
    id: 1,
    name: 'Brussel beer project',
    description: 'This is a small project to make beer at Brussels',
    website: 'www.jesuisunexemple.be',
    beers: [delta]
  };
  constructor() { }

  ngOnInit() {
  }
}
