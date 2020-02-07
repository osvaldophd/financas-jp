import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class DespesaService {

  api = environment.API
  
  constructor(private http: HttpClient, private token: TokenService) { }

  //registar despesas
  registar(Item): Observable<any> {
    return this.http.post(`${this.api}/salvar/despesas`, Item);
  }

  //Listar despesas
  listar(): Observable<any> {
    return this.http.get(`${this.api}/view/item`);
  }

  //lista todas as despesas
  listarDesp(id): Observable<any> {

    return this.http.get(`${this.api}/view/despesas/${id}`);
  } 
  //lista todas as despesas
  totalDespesa(id): Observable<any> {
    return this.http.get(`${this.api}/despesas/${id}`);
  } 
}
