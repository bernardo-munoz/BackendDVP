import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, catchError, map, Observable, of, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { RequestResultSMA, User } from '../model/person';
import { Router } from '@angular/router';
import { SESSION_TOKEN } from 'src/app/models/consts';

@Injectable({
  providedIn: 'root'
})
export class PictureService {

  private selectedUserSubject: BehaviorSubject<User | null> = new BehaviorSubject<User | null>(null);
  public loader: boolean = false;
  private urlBase: string;
  private photoSrcSubject: BehaviorSubject<string> = new BehaviorSubject<string>('');
  public photoSrc$: Observable<string> = this.photoSrcSubject.asObservable();

  constructor(
    private router: Router,
    private http: HttpClient,
    private configService: ConfigService,
    private sharedService: SharedService

  ) {
    this.configService.getAppConfig();
    this.urlBase = this.configService.config.urlPhoto;
   }


  private handleError(error:any) {
    this.sharedService.showLoader(false);
    console.error(error);
    this.sharedService.error(error);
    return throwError(error);
  }

  getPersonSMA(document: string) {
    this.sharedService.showLoader(true);

    const body = new URLSearchParams();
    body.set('document', document);

    const headers = new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResultSMA>(`${this.configService?.config?.urlApi}sma_services.php`, body.toString(), { headers: headers })
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

  setImagePerson(data: User, imagen:string) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('document', data.document);
    body.set('type', data.type);
    body.set('imagen', imagen);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<User>(
        `${this.configService?.config?.urlApi}setImagePerson.php`,
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

  setCarnet(data: User) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('document', data.document);
    body.set('name', data.name);
    body.set('last_name', data.last_name);
    body.set('program', data.program);
    body.set('type', data.type);
    body.set('state', data.state);
    body.set('rh', data.rh);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<User>(`${this.configService?.config?.urlApi}setCarnet.php`,
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

  setSelectedUser(user: User) {
    this.selectedUserSubject.next(user);
  }

  getSelectedUser(): Observable<User | null> {
    return this.selectedUserSubject.asObservable();
  }

  getURLBasePhoto(): string {
    return this.urlBase.toString();
  }

  setPhotoSrc(photoSrc: string): void {
    this.photoSrcSubject.next(photoSrc);
  }

  updatePhotoSrc(url: string) {
    this.photoSrcSubject.next(url);
  }

  //Valida que exista la URL
  validateURL(url: string): Observable<boolean> {
    return this.http.get(url, { responseType: 'blob' }).pipe(
      map(() => true), // La solicitud fue exitosa, la URL es válida
      catchError(() => of(false)) // La solicitud falló, la URL no es válida
    );
  }

  getPersonCarnetizacion(data: User) {
    this.sharedService.showLoader(true);

    // Obtener el token de localStorage o sessionStorage
    const token = sessionStorage.getItem(SESSION_TOKEN);

    const body = new URLSearchParams();
    body.set('document', data.document);

    const headers = new HttpHeaders()
    .set('Content-Type', 'application/x-www-form-urlencoded')
    .set('Authorization',`Bearer ${token}`);

    return this.http
      .post<User>(
        `${this.configService?.config?.urlApi}getPersonCarnetizacion.php`,
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
