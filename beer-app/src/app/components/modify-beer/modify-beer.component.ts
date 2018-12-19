import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { BeerService } from 'src/app/services/beer/beer.service';
import { BreweryService } from 'src/app/services/brewery/brewery.service';
import { TypeService } from 'src/app/services/type/type.service';

import { Beer } from 'src/app/classes/beer';
import { Brewery } from 'src/app/classes/brewery';
import { Type } from 'src/app/classes/type';


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
    this.getTypes();
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

  getTypes() {
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
      'id': this.beer.id,
      'name': this.beer.name,
      'description': this.beer.description,
      'volume': this.beer.volume,
      'brewery': this.beer.brewery.id,
      'type': this.beer.type.id
    };
    console.log(this.beer.id, newBeer)

    if (newBeer.name !== undefined && newBeer.description !== undefined && newBeer.volume !== undefined) {
      if (newBeer.name.length !== 0 && newBeer.description.length !== 0) {
        this.beerService.putBeer(this.beer.id, newBeer).subscribe(
          (data) => {
            this.router.navigate(['/beers']);
          }
        );
      }else {
        document.getElementById('form-error').style.display = 'block';
      }
    }else {
      document.getElementById('form-error').style.display = 'block';
    }
  }

}
