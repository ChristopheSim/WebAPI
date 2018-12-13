import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, ObservableInput } from 'rxjs';
import { Brewery } from 'src/app/classes/brewery';

@Injectable({
  providedIn: 'root'
})
export class BreweryService {
  private url = "http://localhost:8000/api/breweries";

  constructor(private http: HttpClient) { }

  getBreweries(): Observable<Brewery[]> {
    return this.http.get<Brewery[]>(this.url, { responseType: 'json' });
  }

  getBrewery(id: string): Observable<Brewery> {
    return this.http.get<Brewery>(this.url + '/get_brewery/' + id, { responseType: 'json' });
  }

  putBrewery(id: number, brewery: Brewery): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.put(this.url + '/update_brewery/' + id, brewery, httpOptions)
  }

  postBrewery(brewery: Brewery): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.post<Brewery>(this.url + '/add_brewery', brewery, httpOptions);
  }

  deleteBrewery(id): Observable<any> {
    return this.http.delete(this.url +  '/delete_Brewery/' + id)
  }
}
