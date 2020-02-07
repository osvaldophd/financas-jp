
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { EmpresaService } from 'src/app/services/empresa.service';

@Component({
  selector: 'app-empresa',
  templateUrl: './empresa.component.html',
})
export class EmpresaComponent implements OnInit {
  form: any = null;
  teste: string = "djdjdjjdjd"
  sucesso: string;
  errors: string;
  empresa: any;
  errors_resposta: string;
  sucesso_resposta: string;

  empresaById: any = {
    nome_empresa: '',
    descricao: '',
    id: ''
  };
  submit: boolean = false;

  constructor(
    private fb: FormBuilder,
    private empresaService: EmpresaService,
  ) {

  }
  ngOnInit() {

    this.listarTodos();
    this.form = this.fb.group({
      nome_empresa: [''],
      descricao: [''],
      id: [''],
      created_at: [''],
      updated_at: ['']
    });
  }

  nova() {
    this.form = this.fb.group({
      nome_empresa: [''],
      descricao: [''],
      id: [''],
      created_at: [''],
      updated_at: ['']
    });
    this.submit = false;
  }

  //Metodo de registar e actualizar
  registar() {
    if (this.submit) {
      //Editar empresa
      this.empresaService.editar(this.form.value)
        .subscribe((res) => {
          if (res["message"][0] === "The nome empresa has already been taken.") {
            this.errors = "Esta empresa ja existe no sistema"
          } else {
            this.sucesso = "Editado com sucesso"
          }
          this.listarTodos();
        },
          (error) => {
            this.errors = "Erro ao editar Empresa"
          }
        );

    } else {
      this.empresaService.registar(this.form.value)
        .subscribe((res) => {
          if (res["message"][0] === "The nome empresa has already been taken.") {
            this.errors = "Esta empresa ja existe no sistema"
          } else {
            this.nova();
            this.sucesso = "Registrado com sucesso"
          }
          this.listarTodos();
        },
          (error) => {
            this.errors = "Erro ao Registar Empresa"
          }
        );
    }
  }

  //metodo de listagem de todas empresas
  listarTodos() {
    this.empresaService.listar()
      .subscribe((res) => {
        this.empresa = res["data"]["Empresa"];
      },
        (error) => {
          this.empresa = null;
        }
      );
  }

  eliminar(id) {
    this.empresaService.deletar(id)
      .subscribe((res) => {
        if (res["message"] === "Empresa_excluido") {
          this.nova();
          this.sucesso_resposta = "Eliminado com sucesso";
        }
        if (res["message"] === "Empresa_nao_encontrado") {
          this.errors_resposta = "Empresa nao encontrado";
        }
        this.listarTodos();
      },
        (error) => {
          this.errors_resposta = "erro ao eliminar";
        }
      );
  }

  EditarEmpresa(empresa) {
    if (empresa) {
      this.form.setValue(empresa);
      this.submit = true;
    }
  }
}
