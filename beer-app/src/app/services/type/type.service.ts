import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, ObservableInput } from 'rxjs';
import { Type } from 'src/app/classes/type';

@Injectable({
  providedIn: 'root'
})
export class TypeService {
  private url = "http://localhost:8000/api/types";

  constructor(private http: HttpClient) { }

  getTypes(): Observable<Type[]> {
    return this.http.get<Type[]>(this.url, { responseType: 'json' });
  }

  getType(id: string): Observable<Type> {
    return this.http.get<Type>(this.url + '/get_type/' + id, { responseType: 'json' });
  }

  putType(id: number, type: Type): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.put(this.url + '/update_type/' + id, type, httpOptions)
  }

  postType(type: Type): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.post<Type>(this.url + '/add_type', type, httpOptions);
  }

  deleteType(id): Observable<any> {
    return this.http.delete(this.url +  '/delete_type/' + id)
  }
}
