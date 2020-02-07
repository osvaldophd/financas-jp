import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { TokenService } from 'src/app/services/token.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  usuarioName: string;

  constructor(private ath: AuthService, private token: TokenService, private route: Router) { }

  logout() {
    this.ath.logout();
    if (!this.token.verifyToken()) {
      this.route.navigate(['/login']);
    }
  }
  ngOnInit() {
   if (!this.token.verifyToken()) {
      this.route.navigate(['/login']);
    } 
    this.usuarioName = this.token.getUsuarioName()
    
  }
  
}
