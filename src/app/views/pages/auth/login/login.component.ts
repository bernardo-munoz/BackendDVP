import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { LoginService } from '../services/login.service';
import { ToastrService } from 'ngx-toastr';
import { Persons, RequestResult, Users } from '../model/auth';
import { SESSION_DATA_USER, SESSION_ID_ROL, SESSION_ID_USER, SESSION_LS_NAME, SESSION_TOKEN, SESSION_TYPE_ROL } from 'src/app/models/consts';



@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  returnUrl: any;
  @ViewChild('documentNumber')
  public documentNumber!:ElementRef<HTMLInputElement>;

  @ViewChild('password')
  public password!:ElementRef<HTMLInputElement>;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private loginService: LoginService,
    private toastr: ToastrService
    ) {}

  ngOnInit(): void {
    // get return url from route parameters or default to '/'
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';

    localStorage.removeItem(SESSION_LS_NAME);
    sessionStorage.removeItem(SESSION_LS_NAME);
    sessionStorage.removeItem(SESSION_TYPE_ROL);
    sessionStorage.removeItem(SESSION_ID_USER);

  }

  onLoggedin(e: Event) {
    e.preventDefault();
    let document = this.documentNumber.nativeElement.value;
    let password = this.password.nativeElement.value;

    this.loginService.setLogin(document, password).subscribe((response: RequestResult<Users> ) => {

      this.loginService.verifyToken(response.token ?? "")
      if(response.success ){

        const token = response.token ?? "";
        sessionStorage.setItem(SESSION_TOKEN, token);
        

        
        sessionStorage.setItem(SESSION_LS_NAME, 'true'); // Cambiado de localStorage a sessionStorage
        sessionStorage.setItem(SESSION_ID_ROL, response.result.rolID);

        this.loginService.getPersonByNumberDocument(document).subscribe( (response: RequestResult<Persons>) => {

          if(response.success ){
            this.toastr.success("Bienvenido " + response.result.name + " " + response.result.lastname);
            sessionStorage.setItem(SESSION_DATA_USER, JSON.stringify(response.result));
          }

        })


        this.router.navigate([this.returnUrl]);
      }
      else{
        this.toastr.error(response.message);
      }
    });
  }

  validateLenght(e:Event){
    if(this.documentNumber.nativeElement.value.length >= 11){
      e.preventDefault;
      this.documentNumber.nativeElement.value = this.documentNumber.nativeElement.value.substring(0,10);
    }

  }

}
