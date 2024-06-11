import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, catchError, map, Observable, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { RequestResultPHP } from 'src/app/models/request-result';
import { MenuData } from 'src/app/views/layout/sidebar/menu.model';
import { User } from '../../picture/model/person';
import { Roles, Users, Modulos, Permisos, MenuRol } from '../model/user';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  public loader: boolean = false;
  private selectedUserSubject: BehaviorSubject<string | null> = new BehaviorSubject<string | null>(null);
  private selectedRolUserSubject: BehaviorSubject<string | null> = new BehaviorSubject<string | null>(null);
  private selectedUserEditSubject: BehaviorSubject<string | null> = new BehaviorSubject<string | null>(null);
  
  constructor(
    private http: HttpClient,
    private configService: ConfigService,
    private sharedService: SharedService

  ) {
    this.configService.getAppConfig();
   }

  
  private handleError(error:any) {
    this.sharedService.showLoader(false);
    console.error(error);
    this.sharedService.error(error);
    return throwError(error);
  }
  
  getUserByDocument(document: string) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('documento', document);

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<Users>(`${this.configService?.config?.urlApi}getUsuario.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  setRol(id_rol:string, name_rol: string, state: string) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('id_rol', id_rol);
    body.set('rol', name_rol);
    body.set('state', state ?? "1");

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResultPHP<Roles>>(`${this.configService?.config?.urlApi}setRol.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  setUser(user: Users) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('documento', user.documento);
    body.set('nombres', user.nombres);
    body.set('apellidos', user.apellidos);
    body.set('telefono', user.telefono);
    body.set('email', user.email);
    body.set('password', user.password);
    body.set('rol', user.rol);
    body.set('estado', user.is_active == "Activo" ? "1" : "0");

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<Users>(`${this.configService?.config?.urlApi}setUsuario.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  getRoles() {
    this.sharedService.showLoader(true);
  
    return this.http
      .get<RequestResultPHP<Roles>>(`${this.configService?.config?.urlApi}getRoles.php`,)
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  getMenu() {
    this.sharedService.showLoader(true);
  
    return this.http
      .get<RequestResultPHP<MenuData>>(`${this.configService?.config?.urlApi}getMenu.php`,)
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  getMenuByRol(rol:string) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('rol', rol);

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResultPHP<MenuData>>(
        `${this.configService?.config?.urlApi}getMenuByRol.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);
          return response;
        })
      );
  }

  setMenuRol(menuRol: MenuRol) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('id_menu', menuRol.id_menu);
    body.set('id_rol', menuRol.id_rol);
    body.set('state', menuRol.state? "1" : "0");

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResultPHP<MenuRol>>(`${this.configService?.config?.urlApi}setMenuRol.php`,
        body.toString(),
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  getModulos() {
    this.sharedService.showLoader(true);
  
    return this.http
      .get<RequestResultPHP<Modulos>>(`${this.configService?.config?.urlApi}getModulos2.php`,)
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  getPermisos(documento : string) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('documento', documento);

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResultPHP<Permisos>>(`${this.configService?.config?.urlApi}getPermisos2.php`,
          body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
          { headers: headers }
        )      
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }

  setPermisos(documento : string, modulo: Permisos) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('documento', documento);
    body.set('id_modulo', modulo.id_modulo);
    body.set('habilitado', modulo.habilitado);

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResultPHP<any>>(`${this.configService?.config?.urlApi}setPermisos2.php`,
          body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
          { headers: headers }
        )      
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.sharedService.showLoader(false);          
          return response;
        })
      );
  }
  
  getListUsers() {
    this.sharedService.showLoader(true);
  
    return this.http
      .get<RequestResultPHP<Users>>(`${this.configService?.config?.urlApi}getListUsers.php`,)
      .pipe(
        retry(0),
        catchError(this.handleError),
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

  setUserSelectedEdit(rol: string){
    this.selectedUserEditSubject.next(rol)
  }

  getUserSelectedEdit(): Observable<string | null> {
    return this.selectedUserEditSubject.asObservable();
  }

}
