import { Beer } from 'src/app/beer';

export class Brewery {
  id: number;
  name: string;
  description: string;
  website: string;
  beers: Beer[];
}
