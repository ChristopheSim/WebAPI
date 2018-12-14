import { Brewery } from './brewery';
import { Type } from './type';

export class Beer {
  public id: number;
  public name: string;
  public description: string;
  public volume: number;
  public type: Type;
  public brewery: Brewery;

  constructor() {
    this.brewery = new Brewery();
    this.type = new Type();
  }
}
