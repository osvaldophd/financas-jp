import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { ItemService } from 'src/app/services/item.service';

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
})
export class ItemComponent implements OnInit {
  form: any = null;
  sucesso: string;
  errors: string;
  empresa: any;
  errors_resposta: string;
  sucesso_resposta: string;
  item: any;
  teste: string = "JP"

  submit: boolean = false;

  constructor(
    private fb: FormBuilder,
    private itemService: ItemService,
    ) { }

  ngOnInit() {
    this.listarTodos();
    this.form = this.fb.group({
      nome: [''],
      descricao: [''],      
      id: [''],
      created_at: [''],
      updated_at: ['']
    });
  }

  //Metodo que apresenta um botao lateral que permite fazer um novo registo
  nova() {
    this.form = this.fb.group({
      nome: [''],
      descricao: [''],
      id: [''],
      created_at: [''],
      updated_at: ['']
    });
    this.submit = false;

  }

  //Metodo de registo e edicao de tipos de despesas 
  registar() {
    if (this.submit) {
      //Editar empresa
      this.itemService.editar(this.form.value)
        .subscribe((res) => {
          if (res["message"][0] === "The nome has already been taken.") {
            this.errors = "Esta tipo de despesa ja existe no sistema"
          } else {
            this.sucesso = "Editado com sucesso"
          }
          this.listarTodos();
        },
          (error) => {
            this.errors = "Erro ao editar Empresa"
          }
        );
    }else{
      this.itemService.registar(this.form.value)
      .subscribe((res) => {
        if (res["message"][0] === "The nome has already been taken.") {
          this.errors = "Esta tipo de despesa ja existe no sistema";
        
        } else {  
          this.nova();
          this.sucesso = "Registado com sucesso";
          
        }
        this.listarTodos();
      },
        (error) => {
          this.errors = "Erro ao Registar Tipo de Despesa"
        }
      );
    }
    
  }

  //metodos de eliminacao de despesas 
  eliminar(id) {
    this.itemService.deletar(id)
      .subscribe((res) => {
  
        if (res["message"] === "Item_associado_despesa") {
          this.errors_resposta = "Esta categoria esta ser usada em uma despesa";
        }
        if (res["message"] === "Tipo_de_despesa_excluido") {
          this.sucesso_resposta = "Categoria de Despesa Eliminado Com Sucesso";
          this.nova();
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

  //metodo de listagem de todos os tipos de despesas
  listarTodos() {
    this.itemService.listar()
      .subscribe((res) => {
        this.item = res["data"]["item"];
      },
        (error) => {
          this.item = null;
        }
      );
  }

  //Metodo que retorna todos os dados de tipos de despesas e apresentar no formulario
  EditarItem(item) {
    if (item) {
      this.form.setValue(item);
      this.submit = true;
    }
  }

}
