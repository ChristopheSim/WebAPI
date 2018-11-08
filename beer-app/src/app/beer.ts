import { Brewery } from 'src/app/brewery';
import { Type } from 'src/app/type';

export class Beer {
  id: number;
  name: string;
  description: string;
  volume;
  type: Type;
  brewery: Brewery;
}
