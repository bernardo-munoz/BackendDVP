import { HttpClient, HttpErrorResponse, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, catchError, map, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { Persons, RequestResult, TypeDocument, Users } from '../model/auth';
import { SESSION_TOKEN } from 'src/app/models/consts';

import { JwtHelperService } from '@auth0/angular-jwt';
import { Router } from '@angular/router';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(
    private router: Router,
    private http: HttpClient,
    private configService: ConfigService,
    private sharedService: SharedService,
    private jwtHelper: JwtHelperService

  ) {
    this.configService.getAppConfig();
   }

   private handleError(error: any): Observable<never> {
    this.sharedService.showLoader(false);
    console.error('Error en la solicitud:', error);
    return throwError('Algo salió mal, por favor inténtelo de nuevo más tarde.');
  }

  setLogin(document: string, password: string): Observable<RequestResult<Users>> {
  // Crea el cuerpo de la solicitud en formato JSON
  const body = {
    user: document,
    pass: password
  };

  // Configura los encabezados para enviar datos en formato JSON
  const headers = new HttpHeaders().set('Content-Type', 'application/json');

  return this.http
    .post<RequestResult<Users>>(
      `${this.configService?.config?.urlApi}Users/Login`,
      JSON.stringify(body), // Convierte el cuerpo a una cadena JSON
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

  verifyToken(token: string): Observable<boolean> {
    return this.http.post<boolean>(`${this.configService.config.urlApi}}Users/ValidateToken`, { token }).pipe(
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
    );
  }

  setUsers(formData: any): Observable<RequestResult<Users>> {
    const headers = new HttpHeaders().set('Content-Type', 'application/json');

    const body = {
      "name": formData.name,
      "lastname": formData.lastname,
      "typeDocument": formData.typeDocument,
      "numberDocument": formData.document,
      "email": formData.email,
      "user": formData.user,
      "pass": formData.password
    }

    return this.http
      .post<RequestResult<Users>>(
        `${this.configService?.config?.urlApi}Users/CreatePersonUser`,
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

  getTypeDocuments(): Observable<RequestResult<TypeDocument>> {
    this.sharedService.showLoader(true);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .get<RequestResult<TypeDocument>>(`${this.configService?.config?.urlApi}Users/GetTypesDocuments`,
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

  
  getPersonByNumberDocument(numberDocument: string): Observable<RequestResult<Persons>> {
    this.sharedService.showLoader(true);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .get<RequestResult<Persons>>(`${this.configService?.config?.urlApi}Persons/GetPersonByNumberDocument?numberDocument=${numberDocument}`,
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

  get currentUser(): any {
    const token = sessionStorage.getItem(SESSION_TOKEN) ?? "";
    return this.jwtHelper.decodeToken(token);
  }

}
