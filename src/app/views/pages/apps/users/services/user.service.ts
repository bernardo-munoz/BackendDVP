import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, catchError, map, Observable, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { RequestResultPHP } from 'src/app/models/request-result';
import { MenuData } from 'src/app/views/layout/sidebar/menu.model';
import { User } from '../../carnetizacion/picture/model/person';
import { Roles, Users, Modulos, Permisos, MenuRol } from '../model/user';
import { SESSION_TOKEN } from 'src/app/models/consts';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  public loader: boolean = false;
  private selectedUserSubject: BehaviorSubject<string | null> = new BehaviorSubject<string | null>(null);
  private selectedRolUserSubject: BehaviorSubject<string | null> = new BehaviorSubject<string | null>(null);
  private selectedUserEditSubject: BehaviorSubject<string | null> = new BehaviorSubject<string | null>(null);

  constructor(
    private router: Router,
    private http: HttpClient,
    private configService: ConfigService,
    private sharedService: SharedService

  ) {
    this.configService.getAppConfig();
   }


  private handleError(error:any) {
    this.sharedService.error(error);
    return throwError(error);
  }

  getUserByID(id_user: string) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('id_user', id_user);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<RequestResultPHP<Users>>(`${this.configService?.config?.urlApi}getUserByID.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error: HttpErrorResponse) => {
          let errorMessage = '';
          if (error.status === 401) {
            errorMessage = 'Token expirado o no válido. Por favor, inicia sesión de nuevo.';

            this.router.navigate(['/auth/login']);
          } else {
            errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
          }
          this.sharedService.showLoader(false);
          this.sharedService.error(errorMessage);
          return throwError(() => new Error(errorMessage));
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  setRol(id_rol:string, name_rol: string, state: string) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('id_rol', id_rol);
    body.set('rol', name_rol);
    body.set('state', state ?? "1");

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<RequestResultPHP<Roles>>(`${this.configService?.config?.urlApi}setRol.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error: HttpErrorResponse) => {
          let errorMessage = '';
          if (error.status === 401) {
            errorMessage = 'Token expirado o no válido. Por favor, inicia sesión de nuevo.';

            this.router.navigate(['/auth/login']);
          } else {
            errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
          }
          this.sharedService.showLoader(false);
          this.sharedService.error(errorMessage);
          return throwError(() => new Error(errorMessage));
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  setUser(user: Users) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('document', user.document);
    body.set('name', user.name);
    body.set('lastname', user.lastname);
    body.set('phone', user.phone);
    body.set('email', user.email);
    body.set('password', user.password ?? "");
    body.set('id_rol', user.id_rol);
    body.set('state', user.state == "Activo" ? "1" : "0");

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<RequestResultPHP<Users>>(`${this.configService?.config?.urlApi}setUsers.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error: HttpErrorResponse) => {
          let errorMessage = '';
          if (error.status === 401) {
            errorMessage = 'Token expirado o no válido. Por favor, inicia sesión de nuevo.';

            this.router.navigate(['/auth/login']);
          } else {
            errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
          }
          this.sharedService.showLoader(false);
          this.sharedService.error(errorMessage);
          return throwError(() => new Error(errorMessage));
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  getRoles() {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .get<RequestResultPHP<Roles>>(`${this.configService?.config?.urlApi}getRoles.php`,
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error: HttpErrorResponse) => {
          let errorMessage = '';
          if (error.status === 401) {
            errorMessage = 'Token expirado o no válido. Por favor, inicia sesión de nuevo.';

            this.router.navigate(['/auth/login']);
          } else {
            errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
          }
          this.sharedService.showLoader(false);
          this.sharedService.error(errorMessage);
          return throwError(() => new Error(errorMessage));
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  getMenu() {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .get<RequestResultPHP<MenuData>>(`${this.configService?.config?.urlApi}getMenu.php`,
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error: HttpErrorResponse) => {
          let errorMessage = '';
          if (error.status === 401) {
            errorMessage = 'Token expirado o no válido. Por favor, inicia sesión de nuevo.';

            this.router.navigate(['/auth/login']);
          } else {
            errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
          }
          this.sharedService.showLoader(false);
          this.sharedService.error(errorMessage);
          return throwError(() => new Error(errorMessage));
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  getMenuByRol(rol:string) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('rol', rol);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<RequestResultPHP<MenuData>>(
        `${this.configService?.config?.urlApi}getMenuByRol.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error: HttpErrorResponse) => {
          let errorMessage = '';
          if (error.status === 401) {
            errorMessage = 'Token expirado o no válido. Por favor, inicia sesión de nuevo.';

            this.router.navigate(['/auth/login']);
          } else {
            errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
          }
          this.sharedService.showLoader(false);
          this.sharedService.error(errorMessage);
          return throwError(() => new Error(errorMessage));
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  setMenuRol(menuRol: MenuRol) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('id_menu', menuRol.id_menu);
    body.set('id_rol', menuRol.id_rol);
    body.set('state', menuRol.state? "1" : "0");

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);


    return this.http
      .post<RequestResultPHP<MenuRol>>(`${this.configService?.config?.urlApi}setMenuRol.php`,
        body.toString(),
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error) => {
          this.sharedService.showLoader(false);
          // Manejo de errores
          return this.handleError(error);
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  getListUsers() {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .get<RequestResultPHP<Users>>(`${this.configService?.config?.urlApi}getListUsers.php`,
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError((error) => {
          this.sharedService.showLoader(false);
          // Manejo de errores
          return this.handleError(error);
        }),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  setUserSelected(documento: string){
    this.selectedUserSubject.next(documento)
  }

  getUserSelected(): Observable<string | null> {
    return this.selectedUserSubject.asObservable();
  }

  setRolUserSelected(rol: string){
    this.selectedRolUserSubject.next(rol)
  }

  getRolUserSelected(): Observable<string | null> {
    return this.selectedRolUserSubject.asObservable();
  }

  setUserSelectedEdit(id_user: string){
    this.selectedUserEditSubject.next(id_user)
  }

  getUserSelectedEdit(): Observable<string | null> {
    return this.selectedUserEditSubject.asObservable();
  }

}
