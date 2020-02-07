import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './componentes/login/login.component';
import { AuthGuard } from './auth/auth.guard';
import { EmpresaComponent } from './dashboard/componentes/empresa/empresa.component';
import { PoupancaComponent } from './dashboard/componentes/poupanca/poupanca/poupanca.component';
import { EstatisticaComponent } from './dashboard/componentes/estatistica/estatistica/estatistica.component';
import { RendimentoComponent } from './dashboard/componentes/rendimento/rendimento/rendimento.component';
import { DespesaComponent } from './dashboard/componentes/despesas/despesa/despesa.component';
import { ItemComponent } from './dashboard/componentes/item/item/item.component';
import { FuncionariosComponent } from './dashboard/funcionarios/funcionarios.component';
import { PerfilComponent } from './dashboard/componentes/perfil/perfil.component';


const routes: Routes = [
  { path: 'login', component: LoginComponent},

  { path: '', canActivate: [AuthGuard], pathMatch: 'full', redirectTo: '/home' },
 
  { path: 'empresa', component: EmpresaComponent,},

  { path: 'poupanca', component: PoupancaComponent},

  { path: 'estatistica', component: EstatisticaComponent},

  { path: 'rendimento', component: RendimentoComponent},

  { path: 'despesas', component: DespesaComponent},

  { path: 'item', component: ItemComponent},

  { path: 'usuario', component: FuncionariosComponent},

  { path: 'view/usuario', component: PerfilComponent},
  
  { path:'painel',
    loadChildren: () => import('./dashboard/dashboard.module').then(mod => mod.DashboardModule),
    canActivate: [AuthGuard] 
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
