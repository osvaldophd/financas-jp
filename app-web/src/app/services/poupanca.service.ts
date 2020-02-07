import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class PoupancaService {

  api = environment.API;
  
  constructor(private http: HttpClient, private token: TokenService) { }

  //Registar poupancas
  registar(Poupanca): Observable<any> {
    return this.http.post(`${this.api}/salvar/poupanca`, Poupanca);
  }

  //Deletar os dados
  deletar(id): Observable<any> {
    return this.http.delete(`${this.api}/delete/poupanca/${id}`);
  }

  //Listar poupancas
   listarPoupa(id): Observable<any> {
    return this.http.get(`${this.api}/view/poupanca/${id}`);
  }

  listarRendi(id): Observable<any> {
    return this.http.get(`${this.api}/view/rendimento/${id}`);
  }
}
