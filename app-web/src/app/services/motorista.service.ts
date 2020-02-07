import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MotoristaService {

  constructor(private http: HttpClient) { }

  url = environment.URLAPI + '/usuarios/store';

  getUsuario(): Observable<any> {
    return this.http.get<any>(this.url);
  }

}
