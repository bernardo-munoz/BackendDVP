import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { catchError, map, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { RequestResultPHP } from 'src/app/models/request-result';
import { MenuData } from '../menu.model';
import { Router } from '@angular/router';
import { SESSION_TOKEN } from 'src/app/models/consts';

@Injectable({
  providedIn: 'root'
})
export class SidebarService {

  constructor(
    private router: Router,
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
      .post<RequestResultPHP<MenuData>>(`${this.configService?.config?.urlApi}getMenuByRol.php`,
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
}
