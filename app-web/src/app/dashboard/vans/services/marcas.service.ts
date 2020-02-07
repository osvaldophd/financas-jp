import { Injectable } from '@angular/core';
import { HttpClient, HttpEvent } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Marca } from 'src/app/models/marca.model';
import { environment } from 'src/environments/environment';
import { TokenService } from 'src/app/services/token.service';

@Injectable({
  providedIn: 'root'
})
export class MarcasService {

  
  api = environment.API;
  
  constructor(private http: HttpClient, private token: TokenService) { }

  /*

  getAll(): Observable<HttpEvent<Marca>> {
    return this.http.get<Marca>(`${this.api}marca`, this.token.TokenAutorization());
  }
  getById(id: number): Observable<HttpEvent<Marca>> {
    return this.http.get<Marca>(`${this.api}marca/${id}`, this.token.TokenAutorization());
  }

  create(data: Marca): Observable<HttpEvent<Marca>> {
    return this.http.post<Marca>(`${this.api}marca`, data, this.token.TokenAutorization());
  }

  update(id: number, data: Marca): Observable<HttpEvent<Marca>> {
    return this.http.put<Marca>(`${this.api}marca/${id}`, data, this.token.TokenAutorization());
  }

*/


}
