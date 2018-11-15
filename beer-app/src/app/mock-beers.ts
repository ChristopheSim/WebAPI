import { Beer } from './beer';
import { Brewery } from './brewery';
import { Type } from './type';
import { TypesComponent } from 'src/app/types/types.component';
import { BreweriesComponent } from 'src/app/breweries/breweries.component';

export const BEERS: Beer[] = [
  { id: 1, name: 'test1', description: "Test", volume: 0.2, type: new Type(), brewery: new Brewery() },
  { id: 2, name: 'test2', description: "Test", volume: 0.3, type: new Type(), brewery: new Brewery() },
  { id: 3, name: 'test3', description: "Test", volume: 0.4, type: new Type(), brewery: new Brewery() },
  { id: 4, name: 'test4', description: "Test", volume: 0.5, type: new Type(), brewery: new Brewery() },
  { id: 5, name: 'test5', description: "Test", volume: 0.6, type: new Type(), brewery: new Brewery() },
  { id: 6, name: 'test6', description: "Test", volume: 0.7, type: new Type(), brewery: new Brewery() },
  { id: 7, name: 'test7', description: "Test", volume: 0.8, type: new Type(), brewery: new Brewery() },
  { id: 8, name: 'test8', description: "Test", volume: 0.9, type: new Type(), brewery: new Brewery() },
  { id: 9, name: 'test9', description: "Test", volume: 1.0, type: new Type(), brewery: new Brewery() },
  { id: 10, name: 'test10', description: "Test", volume: 1.1, type: new Type(), brewery: new Brewery() }
];
