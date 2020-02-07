import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { tap, delay } from 'rxjs/operators';
import { TokenService } from './token.service';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  api = environment.API;

  constructor(private http: HttpClient, private token: TokenService) { }
  isLoggedIn = false;

  // store the URL so we can redirect after logging in
  redirectUrl: string;

  //metodo de utenticacao de usuario
  login(usuario): Observable<any> {

  return this.http.post(`${this.api}/login`, usuario);

    return of(true).pipe(
      delay(1000),
      tap((val: any) => {
        this.isLoggedIn = true;
      })
    );
  }

  //metodo de termino de sessao
  logout(): void {
    this.token.removerToken();
    this.isLoggedIn = false;
  }
  
  listar(): Observable<any> {
    return this.http.get(`${this.api}/usuarios`);
  }
}
