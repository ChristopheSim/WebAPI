import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Beer } from 'src/app/classes/beer';
import { Brewery } from 'src/app/classes/brewery';
import { Type } from 'src/app/classes/type';
import { BeerService } from 'src/app/services/beer/beer.service'

@Component({
  selector: 'app-beers',
  templateUrl: './display-beers.component.html',
  styleUrls: ['./display-beers.component.css']
})
export class DisplayBeersComponent implements OnInit {
  show: boolean = false;
  beers: Beer[];
  selectedBeer: Beer;

  constructor(private beerService: BeerService,
              private router: Router) { }

  ngOnInit() {
    this.getBeers();
  }

  onSelect(beer: Beer): void {
    this.selectedBeer = beer;
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
