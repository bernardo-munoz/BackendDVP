import { Component, OnInit, ViewChild } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { Permisos, Roles, States, Users } from './model/user';
import { UserService } from './services/user.service';
import { RequestResultPHP } from '../../../../models/request-result';
import { NgSelectComponent } from '@ng-select/ng-select';

@Component({
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})
export class UsersComponent implements OnInit {

  @ViewChild('selectRol') selectRol: NgSelectComponent;
  public refreshList: boolean = false;
  public userCreated: boolean = false;
  selectedRole: string;
  selectedState: string;
  public documentUserSelected: string;
  public states:States[] = [{id_state: "0", state: "Inactivo"}, {id_state:"1", state: "Activo"}];
  public roles:Roles[] = [];
  public permisos:Permisos[] = [];

  public users: Users = {
    id_rol: '',
    rol: '',
    document: '',
    name: '',
    lastname: '',
    id_user: '',
    phone: '',
    email: '',
    state: '',
    addAt: ''
  };

  constructor(
    private userService: UserService,
    private toastr: ToastrService
  ) { this.getRoles();

    this.userService.getUserSelectedEdit().subscribe((documento: string | null) => {

      if(documento){
        this.getUser(documento);
      }

    });
  }

  ngOnInit(): void {
  }

  cleanForm(){

    // this.selectedRole = this.roles[0].id_rol;
    this.selectRol.clearModel();
    this.selectedState = 'Activo';
    this.userCreated = false;
    this.users = {
      id_rol: '',
      rol: '',
      document: '',
      name: '',
      lastname: '',
      id_user: '',
      phone: '',
      email: '',
      state: '',
      addAt: ''
    };
  }

  getUser(id_user: string): void{

    if(id_user == undefined)
      this.toastr.warning("El ID del usuario es obligatorio.");
    else
      this.userService.getUserByID(id_user)
      .subscribe((data:RequestResultPHP<Users>) => {

        if(data.success == "1"){
          this.toastr.success(data.message);
          //Colocamos la bandera de refrescar lista de usuarios en false
          this.refreshList = false;
          this.users =  {
            id_user: data.result[0].id_user,
            document: data.result[0].document,
            name: data.result[0].name,
            lastname: data.result[0].lastname,
            phone: data.result[0].phone,
            email: data.result[0].email,
            password: data.result[0].password,
            confirm_password: data.result[0].password,
            id_rol: data.result[0].id_rol,
            rol: data.result[0].rol,
            state: data.result[0].state,
            addAt: data.result[0].addAt
          };

          const selectedRole = this.roles.find(role => role.id_rol === String(data.result[0].id_rol));

          if (selectedRole) {
            this.selectedRole = selectedRole.rol;
            // this.selectRol.writeValue(selectedRole);

            this.selectedState = data.result[0].state == "1" ? "Activo" : "Inactivo";
            //Seteamos el documento del usuario buscado
            this.userService.setUserSelected(this.users.document);
            this.userService.setRolUserSelected(selectedRole.id_rol);
            this.userCreated = true;
          }

        }
        else{
          this.toastr.error(data.message);
          this.cleanForm();
        }
      });
  }

  getRoles(){

    this.userService.getRoles().subscribe((data: RequestResultPHP<Roles>) => {

      if(data.success == "1"){
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
      this.users.id_rol = selectedRole?.id_rol;
      this.users.state = this.selectedState;
      this.userService.setUser(this.users).subscribe(
        (response: RequestResultPHP<Users>) => {
          if(response.success == "1" || response.success == "2"){

            this.refreshList = true;
            this.cleanForm();
            this.toastr.success(response.message);
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
