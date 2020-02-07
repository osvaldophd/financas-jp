import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { TokenService } from '../../services/token.service';
import { Router } from '@angular/router'; 
import { FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  errors: any = null;
  formLogin: any = null;

  constructor(private auth: AuthService, private token: TokenService, private route: Router, 
    private fb: FormBuilder) {
  }

  ngOnInit() {

    this.formLogin = this.fb.group({
      email: [''],
      password: ['']
    });
  }

  login() {
    this.auth.login(this.formLogin.value)
      .subscribe((res) => {
         this.token.setToken(res.token);
        this.token.setUsuarioId(res.usuario.id);
        this.token.setUsuarioName(res.usuario.name);
        this.route.navigate(['/home']);
      },
        (error) => {
          if (error.error['error'] === "credencias_invalidas") {
            this.errors="Conta de Usuário Inválido..."
          }else{
            console.log(error)
            this.errors="Erro ao fazer login..."

          }
        }
      );

  }
  
}
