import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { TokenService } from './token.service';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
@Injectable({
  providedIn: 'root'
})
export class EmpresaService {
  api = environment.API;

  constructor(private http: HttpClient, private token: TokenService) { }
  isLoggedIn = false;

  // store the URL so we can redirect after logging in
  redirectUrl: string;

  registar(Empresa): Observable<any> {
    return this.http.post(`${this.api}/salvar/empresa`, Empresa);
  }
  
  editar(Empresa): Observable<any> {
    return this.http.put(`${this.api}/update/empresa`, Empresa);
  }

  deletar(id): Observable<any> {
      return this.http.delete(`${this.api}/delete/empresa/${id}`);
  }

  listar(): Observable<any> {
    return this.http.get(`${this.api}/view/empresa`);
  }

  listarById(id): Observable<any> {
    return this.http.get(`${this.api}/empresa/show/${id}`);
  }
}
