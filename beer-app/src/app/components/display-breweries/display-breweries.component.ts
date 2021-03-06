import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Beer } from 'src/app/classes/beer';
import { Brewery } from 'src/app/classes/brewery';
import { Type } from 'src/app/classes/type';
import { BreweryService } from 'src/app/services/brewery/brewery.service'

@Component({
  selector: 'app-display-breweries',
  templateUrl: './display-breweries.component.html',
  styleUrls: ['./display-breweries.component.css']
})
export class DisplayBreweriesComponent implements OnInit {
  show: boolean = false;
  breweries: Brewery[];

  constructor(private breweryService: BreweryService,
              private router: Router) { }

  ngOnInit() {
    this.getBreweries();
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

  showAlert(id) {
    let display = document.getElementById(id).style.display;

    if (display == "block") { document.getElementById(id).style.display = "none"; }
    else { document.getElementById(id).style.display = "block"; }
  }

  deleteBrewery(id) {
    this.show = false;
    this.breweryService.deleteBrewery(id).subscribe(
      (data) => {
        let i=0;
        for (i; i<this.breweries.length; i++) {
          if (this.breweries[i].id == id) {
            this.breweries.splice(i, 1);
          }
        }

        this.router.navigate(['/breweries']);
      }
    );
  }
}
