import { Component } from '@angular/core';
import * as $ from 'jquery';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app4';
  public ngOnInit() {
    $(document).ready(function () {
      $(".btn-menu").click(function () {
        $('.menu').show();
      });

      $(".btn-close").click(function () {
        $('.menu').hide();
      });

      function myFunction(x) { if (x.matches) { $('.menu').hide() } }

      $(".btn-click").click(function () {

        var x = window.matchMedia("(max-width: 720px)")
        myFunction(x) // Call listener function at run time
        x.addListener(myFunction)
      });
    });
  }
}
