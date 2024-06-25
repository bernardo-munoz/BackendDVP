import { Component, OnInit, ViewChild, ElementRef, Inject, Renderer2 } from '@angular/core';
import { DOCUMENT } from '@angular/common';
import { Router } from '@angular/router';
import { SESSION_DATA_USER, SESSION_ID_USER, SESSION_LS_NAME, SESSION_TOKEN, SESSION_TYPE_ROL } from 'src/app/models/consts';
import { SharedService } from 'services/shared.service';
import { RequestResult, Users } from '../../pages/auth/model/auth';
import { LoginService } from '../../pages/auth/services/login.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  dataUser: Users = {
    name: '',
    userID: '',
    document: '',
    lastname: '',
    phone: '',
    email: '',
    state: '',
    rolID: '',
    addAt: '',
    address: '',
    password: '',
    urlPicProfile: '',
    urlImageSignature: '',
    isAdmin: false
  };

  constructor(
    @Inject(DOCUMENT) private document: Document,
    private router: Router,
    private loginService: LoginService
  ) { }

  ngOnInit(): void {

    const userData = JSON.parse(sessionStorage.getItem(SESSION_DATA_USER) ?? "");
    const { name, lastname, email } = userData;
    this.dataUser.name = name;
    this.dataUser.lastname = lastname;
    this.dataUser.email = email;
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
    sessionStorage.removeItem(SESSION_ID_USER);
    sessionStorage.removeItem(SESSION_TOKEN);
    sessionStorage.removeItem(SESSION_DATA_USER);

    // Redirige a la página de inicio de sesión
    this.router.navigate(['/auth/login']);
  }
}
