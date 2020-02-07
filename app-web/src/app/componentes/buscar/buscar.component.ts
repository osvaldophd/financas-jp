import { EscalaService } from 'src/app/services/escala.service';
import { environment } from './../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl } from '@angular/forms';

@Component({
  selector: 'app-buscar',
  templateUrl: './buscar.component.html',
  styleUrls: ['./buscar.component.css']
})
export class BuscarComponent implements OnInit {
  buscaForm = new FormGroup({
    dataBusca: new FormControl(''),
  });
  public escalaSemana: any;
  public enderecoIMG: string = environment.IMGS;
  motorista: any;
  funcionarioEscala: any
  $dataS = "escala de:";
  constructor(private escalaService: EscalaService) { }
  ngOnInit() {
  }
  buscarEscala(){
   this.escalaService.getEscaladata(this.buscaForm.value['dataBusca']).subscribe(
    (res) => {
       this.escalaSemana = res['data']['funcionario_escala'];
       if(this.escalaSemana[0]['funcionario']){
       this.motorista = this.escalaSemana[0]['funcionario'];
       }else{
         this.motorista = null;
       }
    });
}
data(dia, mes, ano): Date {

  return new Date(ano, mes - 1, dia);
}
}
