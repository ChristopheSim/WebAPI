import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, ObservableInput } from 'rxjs';
import { Beer } from 'src/app/classes/beer';

@Injectable({
  providedIn: 'root'
})
export class BeerService {
  private url = "http://localhost:8000/api/beers";

  constructor(private http: HttpClient) { }

  getBeers(): Observable<Beer[]> {
    return this.http.get<Beer[]>(this.url, { responseType: 'json' });
  }

  getBeer(id: string): Observable<Beer> {
    return this.http.get<Beer>(this.url + '/get_beer/' + id, { responseType: 'json' });
  }

  putBeer(id: number, beer): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.put(this.url + '/update_beer/' + id, beer, httpOptions)
  }

  postBeer(beer): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.post<Beer>(this.url + '/add_beer', beer, httpOptions);
  }

  deleteBeer(id): Observable<any> {
    return this.http.delete(this.url +  '/delete_beer/' + id)
  }
}
