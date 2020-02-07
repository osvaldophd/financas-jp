import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Van } from './../dashboard/models/van.model';
@Injectable({
  providedIn: 'root'
})
export class VanService {

  constructor(private http: HttpClient) { }

  url = environment.URLAPI + '/vans';

  getVan(): Observable<Van> {
    return this.http.get<Van>(this.url);
  }
}
