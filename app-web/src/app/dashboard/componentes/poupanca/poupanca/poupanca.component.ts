import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { PoupancaService } from 'src/app/services/poupanca.service';
import { TokenService } from 'src/app/services/token.service';
import { RendimentoService } from 'src/app/services/rendimento.service';

@Component({
  selector: 'app-poupanca',
  templateUrl: './poupanca.component.html',
})

export class PoupancaComponent implements OnInit {
  form: any = null;
  sucesso: string;
  errors: string;
  errors_resposta: string;
  sucesso_resposta: string;
  poupa: any;
  usuarioId: string;
  user: string;
  rendimen: any;

  constructor(    
    private fb: FormBuilder,
    private poupancaService: PoupancaService,
    private token: TokenService,
    private rendimentoService: RendimentoService,
  ) { }

  ngOnInit() {
    this.usuarioId = this.token.getUsuarioId();
    this.nova()
    this.listarPoupanca(this.usuarioId);
    this.listarRendime(this.usuarioId)
    this.nova();
  }

  //Inicializador do formulario
  nova() {
    this.form = this.fb.group({
      valor: [''],
      user_id: this.usuarioId,
      rendimento_id: [''],
      datap: [''],
      created_at: [''],
      updated_at: ['']
    });
  }

  //Registar as poupancas
  registar() {
    this.poupancaService.registar(this.form.value)
      .subscribe((res) => {
        this.listarPoupanca(this.usuarioId);
        this.nova();
        this.sucesso = "Registado Com Sucesso"
      },
        (error) => {
          this.errors = "Erro ao Registar Poupanca"
        }
      );
  }

  //Listagem de poupancas
  listarPoupanca(id) {
    this.poupancaService.listarPoupa(id)
      .subscribe((res) => {
        this.poupa = res["poupanca"];
      },
        (error) => {
          this.poupa = null;
        }
      );
  }

  listarRendime(user_id){
    this.rendimentoService.listarRendi(user_id)
    .subscribe((res) => {         
        this.rendimen = res["rendimento"];
    },
      (error) => {
        this.rendimen = null;
      }
    );
  }

}
