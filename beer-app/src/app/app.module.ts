import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { HttpClientModule } from '@angular/common/http';
import { AppComponent } from './app.component';
import { FormsModule } from '@angular/forms';

import { DisplayBeersComponent } from 'src/app/components/display-beers/display-beers.component';
import { DisplayBreweriesComponent } from 'src/app/components/display-breweries/display-breweries.component';
import { DisplayTypesComponent } from 'src/app/components/display-types/display-types.component';

import { CreateBeerComponent } from 'src/app/components/create-beer/create-beer.component';
import { CreateBreweryComponent } from 'src/app/components/create-brewery/create-brewery.component';
import { CreateTypeComponent } from 'src/app/components/create-type/create-type.component';

import { ModifyBeerComponent } from 'src/app/components/modify-beer/modify-beer.component';
import { ModifyBreweryComponent } from 'src/app/components/modify-brewery/modify-brewery.component';
import { ModifyTypeComponent } from 'src/app/components/modify-type/modify-type.component';

import { ModalDeleteBreweryComponent } from 'src/app/components/modal-delete-brewery/modal-delete-brewery.component';
import { ModalDeleteTypeComponent } from 'src/app/components/modal-delete-type/modal-delete-type.component';
import { ModalDeleteBeerComponent } from 'src/app/components/modal-delete-beer/modal-delete-beer.component';

import { SortBeerPipe } from './pipes/sort-beer.pipe';

@NgModule({
  declarations: [
    AppComponent,
    DisplayBeersComponent,
    DisplayBreweriesComponent,
    DisplayTypesComponent,
    CreateBeerComponent,
    CreateBreweryComponent,
    CreateTypeComponent,
    ModifyBeerComponent,
    ModifyBreweryComponent,
    ModifyTypeComponent,
    ModalDeleteBreweryComponent,
    ModalDeleteTypeComponent,
    ModalDeleteBeerComponent,
    SortBeerPipe
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
