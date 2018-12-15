import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { BreweryService } from 'src/app/services/brewery/brewery.service'
import { Brewery } from 'src/app/classes/brewery';

@Component({
  selector: 'app-modify-brewery',
  templateUrl: './modify-brewery.component.html',
  styleUrls: ['./modify-brewery.component.css']
})
export class ModifyBreweryComponent implements OnInit {
  brewery: Brewery;

  constructor(private route: ActivatedRoute,
              private router: Router,
              private breweryService: BreweryService) { }

  ngOnInit() {
    this.getBrewery();
  }

  getBrewery() {
    let id = this.route.snapshot.paramMap.get('id');
    this.breweryService.getBrewery(id).subscribe(
      (data) => {
        this.brewery = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  onSubmit() {
    if (this.brewery.name.length !== 0 && this.brewery.description.length !== 0 && this.brewery.website.length !== 0) {
      this.breweryService.putBrewery(this.brewery.id, this.brewery).subscribe(
        (data) => {
          if (data.valid === true){
            this.router.navigate(['/breweries']);
          } else {
            document.getElementById('send-error').style.display = "block";
          }
        }
      );
    } else {
      document.getElementById('form-error').style.display = "block";
    }
  }

}
