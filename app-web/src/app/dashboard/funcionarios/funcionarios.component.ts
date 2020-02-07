import { environment } from './../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, FormBuilder } from '@angular/forms';
import { UsuarioService } from 'src/app/services/usuario.service';

@Component({
  selector: 'app-funcionarios',
  templateUrl: './funcionarios.component.html',
  styleUrls: ['./funcionarios.component.css']
})

export class FuncionariosComponent implements OnInit {
  form: any = null;
  teste: string = "JPK"
  sucesso: string;
  errors: string;
  usuario: any;
  errors_resposta: string;
  sucesso_resposta: string;

  usuarioById: any = {
    name: '',
    email: '',
    password: '',
    id: ''
  };

  submit: boolean = false;

  constructor(
    private fb: FormBuilder,
    private usuarioService: UsuarioService,
  ) { }

  ngOnInit() {
    this.listarTodos();
    this.form = this.fb.group({
      name: [''],
      email: [''],
      password: '',
      id: [''],
      created_at: [''],
      updated_at: ['']
    });
  }

  //Metodo de registo de usuario
  registar(){
    if (this.submit) {
      //Editar empresa
      this.usuarioService.editar(this.form.value)
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
      this.usuarioService.registar(this.form.value)
        .subscribe((res) => {
          if (res["message"][0] === "The email has already been taken.") {
            this.errors = "Este Email de Usuario Ja Existe no Sistema"
          } else {
            this.sucesso = "Registrado com sucesso"
          }
          this.listarTodos();
        },
          (error) => {
            this.errors = "Erro ao Registar Usuario"
          }
        );
    }
    }

  listarTodos(){
    this.usuarioService.listar()
      .subscribe((res) => {
        this.usuario = res["data"]["usuarios"];
      },
        (error) => {
          this.usuario = null;
        }
      );
  }

}
