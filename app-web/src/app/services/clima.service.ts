import { ClimaObject } from './../models/clima-object';
import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

const apiKey: string = environment.apiKey;


@Injectable({
  providedIn: 'root'
})
export class ClimaService {
  URI: string;
  constructor(private http: HttpClient) {
     }
  getCurrentWeather(): Observable<ClimaObject> {
    return this.http.get<ClimaObject>(
      'http://api.openweathermap.org/data/2.5/forecast?q=Luanda,ao&units=metric&APPID=50dd93c6b8d5aed5e9495c45b70c3fe8'
  );

  }

}
