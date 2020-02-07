import { Component, OnInit } from '@angular/core';
import { TokenService } from 'src/app/services/token.service';
import { RendimentoService } from 'src/app/services/rendimento.service';
import { DespesaService } from 'src/app/services/despesa.service';

@Component({
  selector: 'app-estatistica',
  templateUrl: './estatistica.component.html',
})
export class EstatisticaComponent implements OnInit {
  usuarioId: any;
  estatistica: any;
  saldo: any;
  redimento: any;
  estatisticaGeral: any;
  
  constructor(
    private despesaService: DespesaService,
    private rendimentoService: RendimentoService,
    private token: TokenService) { }

  ngOnInit(){
    this.usuarioId = this.token.getUsuarioId();
    // busca a esca do funcionario escalado hoje
    this.listarEstatistica(this.usuarioId)
    this.todaEstatistica(this.usuarioId)
    }

    listarEstatistica(id){
      this.rendimentoService.listarEstatistica(id)
      .subscribe((res) => {    
          this.saldo = this.estatistica = res;
          
      },
        (error) => {
          this.saldo = null;
        }
      );
    }
    todaEstatistica(id){
      this.rendimentoService.todaEstatistica(id)
      .subscribe((res) => {    
          this.estatisticaGeral  = res["rendimento"];
          console.log(this.estatisticaGeral)
      },
        (error) => {
          this.saldo = null;
        }
      );
    }
}
