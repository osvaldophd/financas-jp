import { BrowserModule } from '@angular/platform-browser';
import { NgModule, LOCALE_ID } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms'
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { DashboardModule } from './dashboard/dashboard.module';
import { LoginComponent } from './componentes/login/login.component';
import { HttpClientModule } from '@angular/common/http';
import { httpInterceptorProviders } from './interceptors/index.interceptor';
import { registerLocaleData } from '@angular/common';
import localePtBr from '@angular/common/locales/pt';
registerLocaleData(localePtBr);

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    DashboardModule,
    HttpClientModule,
    ReactiveFormsModule
  ],
  providers: [
   httpInterceptorProviders,
   {provide: LOCALE_ID, useValue: 'pt-br'}
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
