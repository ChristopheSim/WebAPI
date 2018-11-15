import { Component, OnInit } from '@angular/core';
import { Beer } from '../beer';
import { Brewery } from '../brewery';
import { Type } from '../type';
import { TypesComponent } from 'src/app/types/types.component';
import { BreweriesComponent } from 'src/app/breweries/breweries.component';
import { BEERS } from '../mock-beers';

@Component({
  selector: 'app-beers',
  templateUrl: './beers.component.html',
  styleUrls: ['./beers.component.css']
})
export class BeersComponent implements OnInit {
  beers = BEERS;
  selectedBeer: Beer;
  constructor() { }

  ngOnInit() {
  }

  onSelect(beer: Beer): void {
    this.selectedBeer = beer;
  }
}
