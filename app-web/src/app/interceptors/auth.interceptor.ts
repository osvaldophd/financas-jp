import { Injectable } from '@angular/core';
import {
  HttpEvent, HttpInterceptor, HttpHandler, HttpRequest
} from '@angular/common/http';

import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

/** Classe responsavel por passar token em uma url do site que é acessada */
@Injectable()
export class AuthInterceptor implements HttpInterceptor {

  intercept(req: HttpRequest<any>, next: HttpHandler):
    Observable<HttpEvent<any>> {

    const curentUrl: Array<any> = req.url.split('/');
    const apiUrl: Array<any> = environment.API.split('/');
    const token = localStorage.getItem('usuario'); 

    if(curentUrl[2] == apiUrl[2]){
        const newReq = req.clone({ setHeaders : { 'Authorization': `Bearer ${token}`}});
        return next.handle(newReq);
    }
    return next.handle(req);


  }
}