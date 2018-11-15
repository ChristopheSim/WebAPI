import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { BeersComponent } from './beers/beers.component';

const routes: Routes = [
{ path: 'beers', component: BeersComponent }];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
