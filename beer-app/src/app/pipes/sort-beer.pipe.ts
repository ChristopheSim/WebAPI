import { Pipe, PipeTransform } from '@angular/core';
import { Beer } from 'src/app/classes/beer';

@Pipe({
  name: 'sortBeer'
})
export class SortBeerPipe implements PipeTransform {

  transform(value: Beer[], brewery:string, type:string) {
    let beers = new Array();
    if (brewery !== 'All' && type !== 'All') {
      value.forEach(beer => {
        if (beer.brewery.name === brewery && beer.type.name === type) {
          beers.push(beer);
        }
      });
      return beers;

    } else if (brewery === 'All' && type !== 'All') {
      value.forEach(beer => {
        if (beer.type.name === type) {
          beers.push(beer);
        }
      });
      return beers;

    } else if (brewery !== 'All' && type === 'All') {
      value.forEach(beer => {
        if (beer.brewery.name === brewery) {
          beers.push(beer);
        }
      });
      return beers;

    } else { return value; }
  }

}
