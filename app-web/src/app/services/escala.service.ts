import { Funcionarios } from './../models/funcionarios.model';
import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EscalaService {

  constructor(private http: HttpClient) { }

  url = environment.URLAPI + '/funcionarios-escalas/escala/dia';
  urlSemanl = environment.URLAPI + '/funcionarios-escalas/escala/semana';
  urlData = environment.URLAPI + '/funcionarios-escalas/escala/data/';//07-01-2020

  public getEscalahoje(): Observable<Funcionarios> {
    return this.http.get<any>(this.url);
  }
  public getEscalaSemanal(): Observable<Funcionarios> {
    return this.http.get<any>(this.urlSemanl);
  }
  public getEscaladata(data:string): Observable<Funcionarios> {
    return this.http.get<any>(this.urlData+data);
  }
}
