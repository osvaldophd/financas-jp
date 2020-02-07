import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { TokenService } from './token.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PerfilService {

api = environment.API;

constructor(private http: HttpClient, private token: TokenService) { }

//Registar tipo de despesas
registar(Item): Observable<any> {
  return this.http.post(`${this.api}/salvar/item`, Item);
}

//Listar cat de despesas
listar(): Observable<any> {
  return this.http.get(`${this.api}/usuarios`);
}

//editar o item
editar(Perifl): Observable<any> {
  return this.http.put(`${this.api}/usuarios/{id}`, Perifl);
}

}
