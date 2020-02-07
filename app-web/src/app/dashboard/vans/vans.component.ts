import { environment } from 'src/environments/environment';
import { Component, OnInit } from '@angular/core';
import { VanService } from './services/vans.service';
import { Van } from '../models/van.model';

@Component({
  selector: 'app-vans',
  templateUrl: './vans.component.html',
  styleUrls: ['./vans.component.css']
})
export class VansComponent implements OnInit {

  vans: Van;
  vanSelecionado: Van;
  enderecoIMG: string = environment.IMGS;
  constructor(private vanserv: VanService) { }

  ngOnInit() {
    this.vanserv.getVan().subscribe(
      (res) => {
        this.vans = res['data']['vans'];
      }
    );
  }
}
