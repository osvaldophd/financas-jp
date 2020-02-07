import { Component, OnInit } from '@angular/core';
import { PerfilService } from 'src/app/services/perfil.service';
import { FormBuilder } from '@angular/forms';

@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.component.html',
})
export class PerfilComponent implements OnInit {

  form: any = null;
  teste: string = "djdjdjjdjd"
  sucesso: string;
  errors: string;
  perfil: any;
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
    private perfilService: PerfilService,
  ) {

  }
  ngOnInit() {

    this.listarTodos();
    this.form = this.fb.group({
      name: [''],
      email: [''],
      password: [''],
      id: [''],
      created_at: [''],
      updated_at: ['']
    });
  }

  nova() {
    this.form = this.fb.group({
      name: [''],
      email: [''],
      password: [''],
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
      this.perfilService.editar(this.form.value)
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
    } 
  }

  //metodo de listagem de todas empresas
  listarTodos() {
    this.perfilService.listar()
      .subscribe((res) => {
        this.perfil = res["data"]["perfil"];
      },
        (error) => {
          this.perfil = null;
        }
      );
  }

  //metodo que captura os dados do formulario
  EditarPerfil(perfil) {
    if (perfil) {
      this.form.setValue(perfil);
      this.submit = true;
    }
  }

}
