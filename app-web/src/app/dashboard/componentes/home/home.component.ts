import { Component, OnInit } from '@angular/core';
import { RendimentoService } from 'src/app/services/rendimento.service';
import { TokenService } from 'src/app/services/token.service';
import { DespesaService } from 'src/app/services/despesa.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {


  estatistica: any;
  saldo: any;
  usuarioId: string;
  totalD: any;

  constructor(
    private despesaService: DespesaService,
    private rendimentoService: RendimentoService,
    private token: TokenService,private route: Router) { }

  ngOnInit(){
    if (!this.token.verifyToken()) {
      this.route.navigate(['/login']);
    }
    this.usuarioId = this.token.getUsuarioId();
    // busca a esca do funcionario escalado hoje
    this.listarEstatistica(this.usuarioId)
    }

    listarEstatistica(id){
      this.rendimentoService.listarEstatistica(id)
      .subscribe((res) => {
          this.saldo = this.estatistica = res;
          console.log(this.saldo)
      },
        (error) => {
          this.saldo = null;
        }
      );
    }
}
