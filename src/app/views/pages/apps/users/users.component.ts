import { Component, OnInit, ViewChild } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { Permisos, Roles, States, Users } from './model/user';
import { UserService } from './services/user.service';
import { RequestResultPHP } from '../../../../models/request-result';
import { NgSelectComponent } from '@ng-select/ng-select';
import { RequestResult, RequestResultObject } from '../../auth/model/auth';

@Component({
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})
export class UsersComponent implements OnInit {

  @ViewChild('selectRol') selectRol: NgSelectComponent;
  public refreshList: boolean = false;
  selectedRole: string;
  selectedState: string;
  public documentUserSelected: string;
  public states:States[] = [{id_state: "0", state: "Inactivo"}, {id_state:"1", state: "Activo"}];
  public roles:Roles[] = [];
  public permisos:Permisos[] = [];
  public userExist: boolean = false;

  public users: Users = {
    rolID: '',
    rol: '',
    document: '',
    name: '',
    lastname: '',
    userID: '',
    phone: '',
    address: '',
    email: '',
    state: '',
    addAt: ''
  };

  constructor(
    private userService: UserService,
    private toastr: ToastrService
  ) { 
    //this.getRoles();

    /* this.userService.getUserSelectedEdit().subscribe((documento: string | null) => {

      if(documento){
        this.getUser(documento);
      }

    }); */
  }

  ngOnInit(): void {
  }

  cleanForm(){

    // this.selectedRole = this.roles[0].rolID;
    this.selectRol.clearModel();
    this.selectedState = 'Activo';
    this.userExist = false;
    this.users = {
      rolID: '',
      rol: '',
      document: '',
      name: '',
      lastname: '',
      address: '',
      userID: '',
      phone: '',
      email: '',
      state: '',
      addAt: ''
    };
  }

  getUser(userID: string): void{

    if(userID == undefined)
      this.toastr.warning("El ID del usuario es obligatorio.");
    else
      this.userService.getUserByID(userID)
      .subscribe((data:RequestResult<Users>) => {

        if(data.success){
          this.toastr.success(data.message);
          //Colocamos la bandera de refrescar lista de usuarios en false
          this.refreshList = false;
          this.users =  data.result;
          this.users.confirm_password = data.result.password;
          this.selectedRole = data.result.rol;
          this.userExist = true;

          if (this.selectedRole) {

            this.selectedState = data.result.state;
            this.userService.setUserSelected(this.users.document);
          }

        }
        else{
          this.toastr.error(data.message);
          this.cleanForm();
        }
      });
  }

  getRoles(){

    this.userService.getRoles().subscribe((data: RequestResultObject<Roles>) => {

      if(data.success){
        this.toastr.success(data.message);
        this.roles = this.roles.concat(Object.values(data.result));
      }
      else{
        this.toastr.error(data.message);
      }
    });
  }

  setUser(e:Event){
    e.preventDefault();
    const selectedRole = this.roles.find(role => role.rol === this.selectedRole);
    if(selectedRole){
      this.users.rolID = selectedRole?.id_rol;
      this.users.state = this.selectedState;
      this.userService.setUser(this.users, this.userExist).subscribe(
        (response: RequestResult<Users>) => {
          if(response.success){

            this.refreshList = false;
            setTimeout(() => {
              this.refreshList = true;
              this.cleanForm();
              this.toastr.success(response.message);
            }, 0);

          }
          else
            this.toastr.warning(response.message);

        },
        (error) => {
          console.error(error);
          this.toastr.error('Error al guardar la información. Intente nuevamente.');
        }
      );
    }
    else
      this.toastr.warning("No se pudo encontrar el rol a asignar.");
  }

  validateUser(user: Users){

    if(user.document == ""){
      this.toastr.warning("El documento es obligatorio.");
      return false;
    }

    if(user.name == ""){
      this.toastr.warning("El nombre es obligatorio.");
      return false;
    }

    if(user.lastname == ""){
      this.toastr.warning("El apellido es obligatorio.");
      return false;
    }

    if(user.password == ""){
      this.toastr.warning("El password es obligatorio.");
      return false;
    }

    if(user.confirm_password == ""){
      this.toastr.warning("Confirmar password es obligatorio.");
      return false;
    }

    if(this.selectedRole == "0"){
      this.toastr.warning("El rol es obligatorio.");
      return false;
    }

    return true;
  }

}
