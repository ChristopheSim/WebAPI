import { Component, OnInit } from '@angular/core';
import { Brewery } from '../brewery';
import { Beer } from '../beer';
import { BeersComponent } from 'src/app/beers/beers.component';

@Component({
  selector: 'app-breweries',
  templateUrl: './breweries.component.html',
  styleUrls: ['./breweries.component.css']
})
export class BreweriesComponent implements OnInit {
  bbp: Brewery = {
    id: 1,
    name: 'Brussel beer project',
    description: "Brasserie issue d'un projet consistant à brasser de la bière à Bruxelles",
    website: 'www.jesuisunexemple.be',
    beers: []
  };
  constructor() { }

  ngOnInit() {
  }
}
