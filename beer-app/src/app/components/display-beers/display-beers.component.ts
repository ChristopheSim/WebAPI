import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Beer } from 'src/app/classes/beer';
import { Brewery } from 'src/app/classes/brewery';
import { Type } from 'src/app/classes/type';
import { BeerService } from 'src/app/services/beer/beer.service';
import { BreweryService } from 'src/app/services/brewery/brewery.service';
import { TypeService } from 'src/app/services/type/type.service';

@Component({
  selector: 'app-display-beers',
  templateUrl: './display-beers.component.html',
  styleUrls: ['./display-beers.component.css']
})
export class DisplayBeersComponent implements OnInit {
  beers: Beer[];
  breweries: Brewery[];
  types: Type[];
  search1: string = "All";
  search2: string = "All";

  constructor(private beerService: BeerService,
              private breweryService: BreweryService,
              private typeService: TypeService,
              private router: Router) { }

  ngOnInit() {
    this.getBeers();
    this.getBreweries();
    this.getTypes();
  }

  getBeers() {
    this.beerService.getBeers().subscribe(
      (data) => {
        this.beers = data;
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

  showAlert(id) {
    let display = document.getElementById(id).style.display;

    if (display == "block") { document.getElementById(id).style.display = "none"; }
    else { document.getElementById(id).style.display = "block"; }
  }

  deleteBeer(id) {
    this.beerService.deleteBeer(id).subscribe(
      (data) => {
        if (data.valid == true) {
          let i=0;
          for (i; i<this.beers.length; i++) {
            if (this.beers[i].id == id) {
              this.beers.splice(i, 1);
            }
          }

          console.log(this.beers);

          this.router.navigate(['/beers']);
        }
        else{
          console.log("error");
        }
      }
    );
  }
}
