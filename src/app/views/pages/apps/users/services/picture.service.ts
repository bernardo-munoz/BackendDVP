import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Router } from "@angular/router";
import { BehaviorSubject, Observable } from "rxjs";
import { ConfigService } from "services/config.service";
import { SharedService } from "services/shared.service";
import { Users } from "../model/user";

@Injectable({
  providedIn: 'root'
})
export class PictureService {

  private selectedUserSubject: BehaviorSubject<Users | null> = new BehaviorSubject<Users | null>(null);
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



  setSelectedUser(user: Users) {
    this.selectedUserSubject.next(user);
  }

  getSelectedUser(): Observable<Users | null> {
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


}
