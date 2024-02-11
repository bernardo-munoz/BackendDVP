import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, catchError, map, retry, throwError } from 'rxjs';
import { ConfigService } from 'services/config.service';
import { SharedService } from 'services/shared.service';
import { General, RequestResultPHP } from 'src/app/models/request-result';

@Injectable({
  providedIn: 'root'
})
export class ExportService {
  public loader: boolean = false;
  private selectedUserSubject: BehaviorSubject<String | null> = new BehaviorSubject<String | null>(null);
  
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

  getReportCarnetizacionByType(type:string) {
    this.sharedService.showLoader(true);
  
    const body = new URLSearchParams();
    body.set('type', type);

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http
      .post<RequestResultPHP<General>>(
        `${this.configService?.config?.urlApi}getReportCarnetizacionByType.php`,
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
  
}
