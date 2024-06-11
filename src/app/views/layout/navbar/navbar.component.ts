import { Component, OnInit, ViewChild, ElementRef, Inject, Renderer2 } from '@angular/core';
import { DOCUMENT } from '@angular/common';
import { Router } from '@angular/router';
import { SESSION_LS_NAME, SESSION_TYPE_ROL } from 'src/app/models/consts';
import { SharedService } from 'services/shared.service';
import { LoginData } from '../../pages/auth/model/auth';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  dataUser: LoginData;

  constructor(
    @Inject(DOCUMENT) private document: Document, 
    private renderer: Renderer2,
    private router: Router,
    private sharedService: SharedService
  ) { }

  ngOnInit(): void {
    this.sharedService.getDataUser().subscribe( (data) => {
        if(data)
          this.dataUser = data;
    });
  }

  /**
   * Sidebar toggle on hamburger button click
   */
  toggleSidebar(e: Event) {
    e.preventDefault();
    this.document.body.classList.toggle('sidebar-open');
  }

  /**
   * Logout
   */
  onLogout(e: Event) {
    e.preventDefault();
    // Remueve la información de localStorage y sessionStorage
    localStorage.removeItem(SESSION_LS_NAME);
    sessionStorage.removeItem(SESSION_LS_NAME);
    sessionStorage.removeItem(SESSION_TYPE_ROL);

    // Redirige a la página de inicio de sesión
    this.router.navigate(['/auth/login']);
  }

}
