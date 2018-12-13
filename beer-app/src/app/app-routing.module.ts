import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DisplayBeersComponent } from 'src/app/components/display-beers/display-beers.component';
import { DisplayBreweriesComponent } from 'src/app/components/display-breweries/display-breweries.component';
import { DisplayTypesComponent } from 'src/app/components/display-types/display-types.component';
import { ModifyBeerComponent } from 'src/app/components/modify-beer/modify-beer.component';
import { ModifyBreweryComponent } from 'src/app/components/modify-brewery/modify-brewery.component';
import { ModifyTypeComponent } from 'src/app/components/modify-type/modify-type.component';
import { CreateBeerComponent } from 'src/app/components/create-beer/create-beer.component';
import { CreateBreweryComponent } from 'src/app/components/create-brewery/create-brewery.component';
import { CreateTypeComponent } from 'src/app/components/create-type/create-type.component';

const routes: Routes = [
  { path: '', redirectTo: '/', pathMatch: 'full' },
  { path: 'beers', component: DisplayBeersComponent },
  { path: 'breweries', component: DisplayBreweriesComponent },
  { path: 'types', component: DisplayTypesComponent },
  { path: 'newBeer', component: CreateBeerComponent },
  { path: 'newBrewery', component: CreateBreweryComponent },
  { path: 'newType', component: CreateTypeComponent },
  { path: 'beer/:id', component: ModifyBeerComponent },
  { path: 'brewery/:id', component: ModifyBreweryComponent },
  { path: 'type/:id', component: ModifyTypeComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
