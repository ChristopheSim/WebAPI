import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DisplayBeersComponent } from 'src/app/components/display-beers/display-beers.component';
import { DisplayBreweriesComponent } from 'src/app/components/display-breweries/display-breweries.component';
import { DisplayTypesComponent } from 'src/app/components/display-types/display-types.component';

const routes: Routes = [
{ path: 'beers', component: DisplayBeersComponent },
{ path: 'breweries', component: DisplayBreweriesComponent },
{ path: 'types', component: DisplayTypesComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
