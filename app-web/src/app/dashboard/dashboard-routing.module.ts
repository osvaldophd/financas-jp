import { AuthGuard } from './../auth/auth.guard';
import { FuncionariosComponent } from './funcionarios/funcionarios.component';
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { TemplateComponent } from './componentes/template/template.component';
import { HomeComponent } from './componentes/home/home.component';
import { VansComponent } from './vans/vans.component';
import { EmpresaComponent } from './componentes/empresa/empresa.component';
import { EstatisticaComponent } from './componentes/estatistica/estatistica/estatistica.component';
import { PoupancaComponent } from './componentes/poupanca/poupanca/poupanca.component';
import { RendimentoComponent } from './componentes/rendimento/rendimento/rendimento.component';
import { DespesaComponent } from './componentes/despesas/despesa/despesa.component';
import { ItemComponent } from './componentes/item/item/item.component';
import { PerfilComponent } from './componentes/perfil/perfil.component';

const routes: Routes = [

  {
    path: 'home',  canActivate: [AuthGuard], component: TemplateComponent, children:
      [
        { path: '', component: HomeComponent },
        { path: 'home', component: HomeComponent },
        { path: 'empresa', component: EmpresaComponent,},
        { path: 'despesas', component: DespesaComponent },
        { path: 'van', component: VansComponent },
        { path: 'estatistica', component: EstatisticaComponent},
        { path: 'poupanca', component: PoupancaComponent},
        { path: 'rendimento', component: RendimentoComponent},
        { path: 'item', component: ItemComponent},        
        { path: 'usuario', component: FuncionariosComponent,},        
        { path: 'view/usuario', component: PerfilComponent,}

      ]
  },

  {
    path: 'usuario', 
    loadChildren: () => import('./funcionarios/funcionarios.component')
    // // .then(mod => mod.DashboardModule),
    // canActivate: [AuthGuard] 
  }


];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DashboardRoutingModule { }
