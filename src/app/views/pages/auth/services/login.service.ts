import { HttpClient, HttpErrorResponse, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, catchError, map, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { RequestResult, Users } from '../model/auth';
import { SESSION_TOKEN } from 'src/app/models/consts';

import { JwtHelperService } from '@auth0/angular-jwt';
import { Router } from '@angular/router';

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
    this.sharedService.showLoader(true);

    const body = new URLSearchParams();
    body.set('document', document);
    body.set('password', password);

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResult<Users>>(
        `${this.configService?.config?.urlApi}login.php`,
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
          const token = response.token;
          sessionStorage.setItem(SESSION_TOKEN, token); // Guardar el token en localStorage
          return response;
        })
      );
  }

  verifyToken(token: string): Observable<boolean> {
    return this.http.post<boolean>(`${this.configService.config.urlApi}verifyToken.php`, { token }).pipe(
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

  get currentUser(): any {
    const token = sessionStorage.getItem(SESSION_TOKEN) ?? "";
    return this.jwtHelper.decodeToken(token);
  }

}
