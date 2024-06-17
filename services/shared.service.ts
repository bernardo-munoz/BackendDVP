import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, catchError, map, retry, throwError } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { RequestResult, Users } from 'src/app/views/pages/auth/model/auth';
import { ConfigService } from './config.service';
import { ToastrService } from 'ngx-toastr';

@Injectable({
  providedIn: 'root'
})
export class SharedService {

  public loader: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);
  public successNotification: BehaviorSubject<{ message: string | string[], showPopUp: boolean }> = new BehaviorSubject<{ message: string | string[], showPopUp: boolean }>({ message: '', showPopUp: false });
  public errorNotification: BehaviorSubject<{ message: string | string[], showPopUp: boolean }> = new BehaviorSubject<{ message: string | string[], showPopUp: boolean }>({ message: '', showPopUp: false });
  public warningNotification: BehaviorSubject<{ message: string | string[], showPopUp: boolean }> = new BehaviorSubject<{ message: string | string[], showPopUp: boolean }>({ message: '', showPopUp: false });
  public infoNotification: BehaviorSubject<{ message: string | string[], showPopUp: boolean }> = new BehaviorSubject<{ message: string | string[], showPopUp: boolean }>({ message: '', showPopUp: false });

  constructor(
    private toastr: ToastrService,
    private http: HttpClient,
    private configService: ConfigService
  ) { }

  showLoader(valor: boolean) {
    return this.loader.next(valor);
  }

  success(message: string | string[]) {
    // this.successNotification.next({ message, showPopUp });
      this.toastr.success(Array.isArray(message) ? message.join('<br/>') : message);
  }

  error(message: string | string[]) {
    // this.errorNotification.next({ message, showPopUp });
      this.toastr.error(Array.isArray(message) ? message.join('<br/>') : message);
  }

  warning(message: string | string[]) {
    // this.warningNotification.next({ message, showPopUp });
      this.toastr.warning(Array.isArray(message) ? message.join('<br/>') : message);
  }

  info(message: string | string[]) {
    // this.infoNotification.next({ message, showPopUp });
      this.toastr.info(Array.isArray(message) ? message.join('<br/>') : message);
  }

  createHttpParams(params: any): HttpParams {
    return Object.getOwnPropertyNames(params)
      .reduce((p, key) => p.set(key, params[key]), new HttpParams());
  }

  popupHeight() {
    return 400; // Math.round(window.innerHeight / 1.3);
  }

  formHeight() {
    return 350; // Math.round(window.innerHeight / 1.3);
  }

  IsNumber(s: string) {
    const x = +s;
    return x.toString() === s;
  }

  insertValueInTextArea(inputId: string, value: string) {
    if (inputId && value) {
      const input: any = document.getElementById(inputId);
      if (input) {
        input.focus();
        const lastPost = input.selectionStart;
        input.value = input.value.slice(0, input.selectionStart) + value + input.value.slice(input.selectionStart);
        input.setSelectionRange(lastPost, (value.length + lastPost), 'forward');
        return input.value;
      }
      return '';
    }
  }

  getDataUser(id_user: string): Observable<RequestResult<Users>> {
    this.showLoader(true);

    const body = new URLSearchParams();
    body.set('id_user', id_user ?? "");

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResult<Users>>(
        `${this.configService?.config?.urlApi}getUserByID.php`,
        body.toString(), // Envía los datos en el formato application/x-www-form-urlencoded
        { headers: headers }
      )
      .pipe(
        retry(0),
        catchError(this.handleError),
        map((response) => {
          this.showLoader(false);
          return response;
        })
      );
  }

  private handleError(error: any): Observable<never> {
    this.showLoader(false);
    console.error('Error en la solicitud:', error);
    return throwError('Algo salió mal, por favor inténtelo de nuevo más tarde.');
  }
}
