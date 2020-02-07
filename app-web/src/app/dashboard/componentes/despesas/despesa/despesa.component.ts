import { Component, OnInit } from '@angular/core';
import { DespesaService } from 'src/app/services/despesa.service';
import { AuthService } from 'src/app/services/auth.service';
import { FormBuilder, FormGroup } from '@angular/forms';
import { TokenService } from 'src/app/services/token.service';
import { RendimentoService } from 'src/app/services/rendimento.service';

@Component({
  selector: 'app-despesa',
  templateUrl: './despesa.component.html',
})

export class DespesaComponent implements OnInit {
  despesa: any;
  item: any;
  form: any = null;
  sucesso: string;
  errors: string;
  empresa: any;
  errors_resposta: string;
  sucesso_resposta: string;
  user: string;
  usuarios: any;
  usuarioId: string;
  rendimento: any;

  constructor(
    private fb: FormBuilder,
    private rendimentoService: RendimentoService,
    private despesaService: DespesaService,
    private auth: AuthService,
    private token: TokenService
  ) { }

  ngOnInit() {
    this.usuarioId = this.token.getUsuarioId();
    this.user = localStorage.getItem('usuario') 
    this.listarTodos();
    this.listarDespesas(this.usuarioId);
    this.listarRendime(this.usuarioId);
   this.nova();
  }
nova(){
  this.form = this.fb.group({
    valor: [''],
    prazo_pagamento: [''],
    item_id: [''],
    user_id: this.usuarioId,
    rendimento_id: [''],
    created_at: [''],
    updated_at: ['']
  });
}
  //registar despesas
  registar(){ 
    console.log(this.form.value)
      this.despesaService.registar(this.form.value)
        .subscribe((res) => { 
          console.log(res)
            this.sucesso = "Registrado com sucesso";
            this.form = this.fb.group({
              valor: [''],
              prazo_pagamento: [''],
              item_id: [''],
              user_id: this.usuarioId,
              created_at: [''],
              updated_at: ['']
            });   
            this.listarDespesas(this.usuarioId);
        },
          (error) => {
            console.log(error)
            this.errors = "Erro ao Registar Deespesa"
          }
        );
    }

  //Metodo que lista os tipos de despesas
  listarTodos() { 
    this.despesaService.listar()
      .subscribe((res) => {    

          this.item = res["data"]["item"];
      },
        (error) => {
          this.despesa = null;
        }
      );
  }

  //listar as despesas com seus respectivos valores e prazos
  listarDespesas(user_id){ 
    this.despesaService.listarDesp(user_id)
    .subscribe((res) => {  
      console.log(res)       
        this.despesa = res["Despesa"];
    },
      (error) => {
        this.despesa = null;
      }
    );
  }
  
  listarRendime(user_id){
    this.rendimentoService.listarRendi(user_id)
    .subscribe((res) => {         
        this.rendimento = res["rendimento"];
    },
      (error) => {
        this.despesa = null;
      }
    );
  }
}
