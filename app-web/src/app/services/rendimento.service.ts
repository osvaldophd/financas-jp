import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from './../../environments/environment';
import { Observable } from 'rxjs';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class RendimentoService {

  api = environment.API;

  constructor(private http: HttpClient, private token: TokenService) { }


 
  rendimentoMensal(id): Observable<any> {
    return this.http.get<any>(`${this.api}/${id}`);
  }
 //Listar despesas
 listarEstatistica(id): Observable<any> {
  return this.http.get<any>(`${this.api}/estatistica/${id}`);
}
todaEstatistica(id): Observable<any> {
  return this.http.get<any>(`${this.api}/mensal/rendimento/${id}`);
}
  //Listar poupancas
  registar(Rendimento): Observable<any> {
 
    return this.http.post(`${this.api}/salvar/rendimento`, Rendimento);
  }

  //Listar empresas
  listar(): Observable<any> {
    return this.http.get(`${this.api}/view/empresa`);
  }

  
  //Listar poupancas
  deletar(id): Observable<any> {
    return this.http.get(`${this.api}/delete/rendimento`,id);
  }

  //Listar rendimentos
  listarRendi(id): Observable<any> {
    return this.http.get(`${this.api}/view/rendimento/${id}`);
  }
  
}
