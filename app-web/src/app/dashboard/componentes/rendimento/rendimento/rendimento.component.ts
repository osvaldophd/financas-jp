import { Component, OnInit } from '@angular/core';
import { RendimentoService } from 'src/app/services/rendimento.service';
import { FormBuilder } from '@angular/forms';
import { TokenService } from 'src/app/services/token.service';

@Component({
  selector: 'app-rendimento',
  templateUrl: './rendimento.component.html',
})
export class RendimentoComponent implements OnInit {

  form: any = null;
  sucesso: string;
  errors: string;
  empresas: any;
  errors_resposta: string;
  sucesso_resposta: string;
  rendimento: any;

  constructor(
    private fb: FormBuilder,
    private rendimentoService: RendimentoService,
    private token: TokenService
  ) { }

  ngOnInit() {
    this.listarTodos();
    this.listarRendimentos(this.token.getUsuarioId());
    this.nova();
  }
  
  nova() {
    this.form = this.fb.group({
      valor: [''],
      empresa_id: [''],
      mes: [''],
      user_id: this.token.getUsuarioId(),
      id: ['']
    });
  }

  //registar os rendimentos
  registar() {
    this.rendimentoService.registar(this.form.value)
      .subscribe((res) => {
        if (res["message"] === "rendimento_adicionado_com_succeso") {
          this.nova();
          this.sucesso = "Registrado com sucesso"
        } else {
          this.errors = "Esta empresa ja existe no sistema"
        }
        this.listarRendimentos(this.token.getUsuarioId());
      },
        (error) => {
          this.errors = "Erro ao Registar Tipo de Despesa"
        }
      );
  }

  //eliminar rendimento
  eliminar(id) {
    this.rendimentoService.deletar(id)
      .subscribe((res) => {
        if (res["message"] === "Tipo_de_despesa_excluido") {
          this.sucesso_resposta = "Categoria de Despesa Eliminado Com Sucesso";
          this.nova()
        }
        if (res["message"] === "Item_nao_encontrado") {
          this.errors_resposta = "Categoria de Despesa Nao Encontrado";
        }
        this.listarTodos();
      },
        (error) => {
          this.errors_resposta = "Erro ao Eliminar";
        }
      );
  }

  //Listar todas empresas do sistema
  listarTodos() {
    this.rendimentoService.listar()
      .subscribe((res) => {
        this.empresas = res["data"]["Empresa"];
      },
        (error) => {
          this.empresas = null;
        }
      );
  }

  //Listar os rendimentos
  listarRendimentos(id) {
    this.rendimentoService.listarRendi(id)
      .subscribe((res) => {
        this.rendimento = res["rendimento"];
      },
        (error) => {
          this.rendimento = null;
        }
      );
  }
}
