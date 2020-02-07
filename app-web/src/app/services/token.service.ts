import { Injectable } from '@angular/core';
import { HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TokenService {

  token: string;

  constructor() { }

  setToken(token){
    localStorage.setItem('usuario', token)
  }
  setUsuarioName(usuario){
    localStorage.setItem('usuarioName', usuario)
  }
  setUsuarioId(usuario){
    localStorage.setItem('usuarioId', usuario)
  }

  removerToken(){
    localStorage.setItem('usuario',null);
    localStorage.setItem('usuarioName',null);
    localStorage.setItem('usuarioId',null);

    localStorage.removeItem('usuario');
    localStorage.removeItem('usuarioName');
    localStorage.removeItem('usuarioId');
  }

  verifyToken(): boolean {
    if(localStorage.getItem('usuario') && localStorage.getItem('usuarioName')){
        return true;
     }
    return false;
  }

  getToken(){
    return localStorage.getItem('usuario');
  }

  getUsuarioName(){
    return localStorage.getItem('usuarioName');
  }

  getUsuarioId(){
    return localStorage.getItem('usuarioId');
  }

  TokenAutorization(): any {
    const token = localStorage.getItem('usuario');
    return {
      headers: new HttpHeaders().set('Authorization', ` Bearer ${token} `)
    };
  }
}
