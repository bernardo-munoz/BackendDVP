import { Component, OnInit } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { RequestResultPHP } from 'src/app/models/request-result';
import { MenuData } from 'src/app/views/layout/sidebar/menu.model';
import { Modulos, Permisos, Users } from '../model/user';
import { UserService } from '../services/user.service';

@Component({
  selector: 'app-detail-user',
  templateUrl: './detail-user.component.html',
  styleUrls: ['./detail-user.component.scss']
})
export class DetailUserComponent implements OnInit {

  public documento: string;
  public modulos:Modulos[] = [];
  public menu:MenuData[] = [];
  
  constructor(
    private userService: UserService,
    private toastr: ToastrService
    ) { }

  ngOnInit(): void {
    this.getMenuRoles();
  }

  getMenuRoles(){
    this.userService.getRolUserSelected().subscribe((rol: String | null) => {

      if(rol){
        this.userService.getMenuByRol(rol!.toString()).subscribe((data: RequestResultPHP<MenuData>) => {
    
          if(data.success == "1"){
            this.toastr.success(data.message);       
            this.menu = Object.values(data.result).filter(item => item.is_parent !== '1');;
    
          }
          else{
            this.menu = [];
            this.toastr.error(data.message);
          }
        });
      }
      
    });
  }
}
