import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { BeerService } from 'src/app/services/beer/beer.service';
import { Beer } from 'src/app/classes/beer';
import { BreweryService } from 'src/app/services/brewery/brewery.service';
import { Brewery } from 'src/app/classes/brewery';
import { Type } from 'src/app/classes/type';
import { TypeService } from 'src/app/services/type/type.service';

@Component({
  selector: 'app-modify-beer',
  templateUrl: './modify-beer.component.html',
  styleUrls: ['./modify-beer.component.css']
})
export class ModifyBeerComponent implements OnInit {
  beer: Beer;
  breweries: Brewery[];
  types: Type[];

  constructor(private route: ActivatedRoute,
              private router: Router,
              private beerService: BeerService,
              private breweryService: BreweryService,
              private typeService: TypeService) { }

  ngOnInit() {
    this.getBeer();
    this.getBreweries();
    this.getType();
  }

  getBeer() {
    let id = this.route.snapshot.paramMap.get('id');
    this.beerService.getBeer(id).subscribe(
      (data) => {
        this.beer = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  getBreweries() {
    this.breweryService.getBreweries().subscribe(
      (data) => {
        this.breweries = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  getType() {
    this.typeService.getTypes().subscribe(
      (data) => {
        this.types = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  onSubmit() {
    let newBeer = {
      'name': this.beer.name,
      'description': this.beer.description,
      'volume': this.beer.volume,
      'brewery': this.beer.brewery,
      'type': this.beer.type
    };

    this.beerService.putBeer(this.beer.id, newBeer).subscribe(
      (data) => {
        this.router.navigate(['/beers']);
      }
    );
  }

}
