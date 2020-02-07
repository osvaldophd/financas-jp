import { BuscarComponent } from './../componentes/buscar/buscar.component';
import { PrevisaoTempoComponent } from './../componentes/previsao-tempo/previsao-tempo.component';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FuncionariosComponent } from './funcionarios/funcionarios.component';
import { DashboardRoutingModule } from './dashboard-routing.module';
import { HeaderComponent } from './componentes/header/header.component';
import { SidebarComponent } from './componentes/sidebar/sidebar.component';
import { FooterComponent } from './componentes/footer/footer.component';
import { TemplateComponent } from './componentes/template/template.component';
import { HomeComponent } from './componentes/home/home.component';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { VansComponent } from './vans/vans.component';
import { EmpresaComponent } from './componentes/empresa/empresa.component';
import { PoupancaComponent } from './componentes/poupanca/poupanca/poupanca.component';
import { EstatisticaComponent } from './componentes/estatistica/estatistica/estatistica.component';
import { RendimentoComponent } from './componentes/rendimento/rendimento/rendimento.component';
import { DespesaComponent } from './componentes/despesas/despesa/despesa.component';
import { ItemComponent } from './componentes/item/item/item.component';
import { PerfilComponent } from './componentes/perfil/perfil.component';

@NgModule({
  declarations: [
    HomeComponent,
    HeaderComponent,
    SidebarComponent,
    FooterComponent,
    EmpresaComponent,
    TemplateComponent,
    VansComponent,
    FuncionariosComponent,
    PrevisaoTempoComponent,
    BuscarComponent,
    PoupancaComponent,
    EstatisticaComponent,
    RendimentoComponent,
    DespesaComponent,
    ItemComponent,
    PerfilComponent
  ],
  imports: [
    CommonModule,
    DashboardRoutingModule,
    FormsModule,
    ReactiveFormsModule,
  ]
})
export class DashboardModule { }
