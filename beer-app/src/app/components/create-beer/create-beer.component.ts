import { Component, OnInit } from '@angular/core';
import { Beer } from 'src/app/classes/beer';
import { Router } from '@angular/router';
import { BeerService } from 'src/app/services/beer/beer.service';
import { BreweryService } from 'src/app/services/brewery/brewery.service';
import { TypeService } from 'src/app/services/type/type.service';
import { Brewery } from 'src/app/classes/brewery';
import { Type } from 'src/app/classes/type';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-create-beer',
  templateUrl: './create-beer.component.html',
  styleUrls: ['./create-beer.component.css']
})
export class CreateBeerComponent implements OnInit {
  newBeer: Beer;
  breweries: Brewery[];
  types: Type[];

  constructor(private router: Router,
              private beerService: BeerService,
              private breweryService: BreweryService,
              private typeService: TypeService,
              private http: HttpClient) {
      this.newBeer = new Beer();
  }

  ngOnInit() {
    this.getBreweries();
    this.getTypes();
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
      'name': this.newBeer.name,
      'description': this.newBeer.description,
      'volume': this.newBeer.volume,
      'brewery': this.newBeer.brewery,
      'type': this.newBeer.type
    };

    if (this.newBeer.name !== undefined && this.newBeer.description !== undefined && this.newBeer.volume !== undefined && this.newBeer.brewery.id !== undefined && this.newBeer.type.id !== undefined) {
      if (this.newBeer.name.length !== 0 && this.newBeer.description.length !== 0 && this.newBeer.brewery.name.length !== 0 && this.newBeer.type.name.length !== 0) {
        this.beerService.postBeer(newBeer).subscribe(
          (data) => {
            if (data.valid === true) {
              this.router.navigate(['/beers']);
            }
            else {
              document.getElementById('send-error').style.display = 'block';
            }
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
