import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {
  api = environment.API;
  
  constructor(
    private http: HttpClient, private token: TokenService
  ) { }

  //metodo de gisto de usuario
  registar(Usuario): Observable<any> {
    return this.http.post(`${this.api}/add/usuarios`, Usuario);
  }
  
  editar(Empresa): Observable<any> {
    return this.http.put(`${this.api}/update/empresa`, Empresa);
  }

  //metodo de eliminacao de usuario
  deletar(id): Observable<any> {
      return this.http.delete(`${this.api}/delete/empresa/${id}`);
  }

  //Listar todos os usuarios do sistema
  listar(): Observable<any> {
    return this.http.get(`${this.api}/view/usuario`);
  }

  listarById(id): Observable<any> {
    return this.http.get(`${this.api}/empresa/show/${id}`);
  }
  
}
