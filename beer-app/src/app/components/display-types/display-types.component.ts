import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Beer } from 'src/app/classes/beer';
import { Brewery } from 'src/app/classes/brewery';
import { Type } from 'src/app/classes/type';
import { TypeService } from 'src/app/services/type/type.service'


@Component({
  selector: 'app-display-types',
  templateUrl: './display-types.component.html',
  styleUrls: ['./display-types.component.css']
})
export class DisplayTypesComponent implements OnInit {
  show: boolean = false;
  types: Type[];

  constructor(private typeService: TypeService,
              private router: Router) { }

  ngOnInit() {
    this.getTypes();
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

  deleteType(id) {
    this.show = false;
    this.typeService.deleteType(id).subscribe(
      (data) => {
        let i=0;
        for (i; i<this.types.length; i++) {
          if (this.types[i].id == id) {
            this.types.splice(i, 1);
          }
        }

        this.router.navigate(['/types']);
      }
    );
  }
}
