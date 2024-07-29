import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, catchError, map, Observable, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { RequestResultPHP } from 'src/app/models/request-result';
import { Roles, Users, Modulos, Permisos, MenuRol } from '../model/user';
import { SESSION_TOKEN } from 'src/app/models/consts';
import { Router } from '@angular/router';
import { Persons, RequestResult, RequestResultObject } from '../../../auth/model/auth';

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

  getUserByID(id_user: string): Observable<RequestResult<Users>> {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('UserID', id_user);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<RequestResult<Users>>(`${this.configService?.config?.urlApi}Users/GetUsersById`,
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
  setUser(user: Users, userExist: boolean) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = {
      userID: user.userID,
      document: user.document.toString(),
      name: user.name,
      lastname: user.lastname,
      address: user.address,
      phone: user.phone,
      email: user.email,
      password: user.password,
      rolID: user.rolID,
      state: user.state == "Activo" ? "1" : "0",
      isAdmin: user.rol == "Administrador"
    }

    const headers = new HttpHeaders()
      .set('Content-Type', 'application/json')
      .set('Authorization', `Bearer ${token}`);

    var endPoint = userExist ? "Users/UpdateUsers" : "Users/CreateUser";

    return this.http
      .post<RequestResult<Users>>(`${this.configService?.config?.urlApi}${endPoint}`,
        JSON.stringify(body),
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


  getRoles(): Observable<RequestResultObject<Roles>> {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .get<RequestResultObject<Roles>>(`${this.configService?.config?.urlApi}Roles/GetAllRoles`,
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

  getListUsers() {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .get<RequestResultObject<Persons>>(`${this.configService?.config?.urlApi}Persons/GetAllPersons`,
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

  setUserSelectedEdit(id_user: string){
    this.selectedUserEditSubject.next(id_user)
  }

  getUserSelectedEdit(): Observable<string | null> {
    return this.selectedUserEditSubject.asObservable();
  }

}
