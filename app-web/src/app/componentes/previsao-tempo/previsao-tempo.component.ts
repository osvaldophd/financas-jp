import { ClimaObject } from 'src/app/models/clima-object';
import { Component, OnInit } from '@angular/core';
import { ClimaService } from 'src/app/services/clima.service';

@Component({
  selector: 'app-previsao-tempo',
  templateUrl: './previsao-tempo.component.html',
  styleUrls: ['./previsao-tempo.component.css']
})
export class PrevisaoTempoComponent implements OnInit {

  loading = false;
  climaObject: ClimaObject;

  constructor(
    private clima: ClimaService) { }

  ngOnInit() {
     // pega o clima
     this.clima.getCurrentWeather().subscribe(clima => {

      this.climaObject = clima;
    });
  }
  urlImagemClima(iconName: string): string {
    return "http://openweathermap.org/img/wn/" + iconName + "@2x.png";
  }

}
