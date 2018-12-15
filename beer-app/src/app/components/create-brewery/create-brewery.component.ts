import { Component, OnInit } from '@angular/core';
import { BreweryService } from 'src/app/services/brewery/brewery.service';
import { Router } from '@angular/router';
import { Brewery } from 'src/app/classes/brewery';

@Component({
  selector: 'app-create-brewery',
  templateUrl: './create-brewery.component.html',
  styleUrls: ['./create-brewery.component.css']
})
export class CreateBreweryComponent implements OnInit {
  newBrewery: Brewery;

  constructor(private router: Router,
              private breweryService: BreweryService) {
      this.newBrewery = new Brewery();
  }

  ngOnInit() {
  }

  onSubmit() {
    if (this.newBrewery.name !== undefined && this.newBrewery.description !== undefined && this.newBrewery.website !== undefined) {
      if (this.newBrewery.name.length !== 0 && this.newBrewery.description.length !== 0 && this.newBrewery.website.length !== 0) {
        this.breweryService.postBrewery(this.newBrewery).subscribe(
          (data) => {
            if (data.valid == true) {
              this.router.navigate(['/breweries']);
            }
            else {
              document.getElementById('send-error').style.display ='block';
            }
          }
        );
      } else {
        document.getElementById('form-error').style.display ='block';
      }
    } else {
      document.getElementById('form-error').style.display ='block';
    }
  }

}
