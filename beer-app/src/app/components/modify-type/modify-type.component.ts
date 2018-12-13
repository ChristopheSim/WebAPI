import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { TypeService } from 'src/app/services/type/type.service'
import { Type } from 'src/app/classes/type';

@Component({
  selector: 'app-modify-type',
  templateUrl: './modify-type.component.html',
  styleUrls: ['./modify-type.component.css']
})
export class ModifyTypeComponent implements OnInit {
  type: Type;

  constructor(private route: ActivatedRoute,
              private router: Router,
              private typeService: TypeService) { }

  ngOnInit() {
    this.getType();
  }

  getType() {
    let id = this.route.snapshot.paramMap.get('id');
    this.typeService.getType(id).subscribe(
      (data) => {
        this.type = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  onSubmit() {
    this.typeService.putType(this.type.id, this.type).subscribe(
      (data) => {
        this.router.navigate(['/types']);
      }
    );
  }

}
