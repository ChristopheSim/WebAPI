import { Component, OnInit } from '@angular/core';
import { TypeService } from 'src/app/services/type/type.service';
import { Router } from '@angular/router';
import { Type } from 'src/app/classes/type';

@Component({
  selector: 'app-create-type',
  templateUrl: './create-type.component.html',
  styleUrls: ['./create-type.component.css']
})
export class CreateTypeComponent implements OnInit {
  newType: Type;

  constructor(private router: Router,
              private typeService: TypeService) {
      this.newType = new Type();
  }

  ngOnInit() {
  }

  onSubmit() {
    if (this.newType.name !== undefined && this.newType.description !== undefined) {
      if (this.newType.name.length !== 0 && this.newType.description.length !== 0) {
        this.typeService.postType(this.newType).subscribe(
          (data) => {
            this.router.navigate(['/types']);
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
