import { Component, OnInit, ViewChild } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { Permisos, Roles, Users } from './model/user';
import { UserService } from './services/user.service';
import { RequestResultPHP } from '../../../../models/request-result';
import { NgSelectComponent } from '@ng-select/ng-select';

@Component({
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})
export class UsersComponent implements OnInit {

  @ViewChild('selectRol') selectRol: NgSelectComponent;
  public userCreated: boolean = false;
  selectedRole: string;
  selectedState: string;
  public documentUserSelected: string;
  public roles:Roles[] = [];
  public permisos:Permisos[] = [];

  public users: Users = {
    id: '',
    documento: '',
    nombres: '',
    apellidos: '',
    telefono: '',
    email: '',
    password: '',
    confirm_password: '',
    rol: '',
    is_active: '',
    created_at: '',
    success: '',
    message: ''
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
      id: '',
      documento: '',
      nombres: '',
      apellidos: '',
      telefono: '',
      email: '',
      password: '',
      confirm_password: '',
      rol: '',
      is_active: '',
      created_at: '',
      success: '',
      message: ''
    };
  }

  getUser(document: string): void{

    if(document == undefined)
      this.toastr.warning("El numero de documento es obligatorio.");
    else
      this.userService.getUserByDocument(document)
      .subscribe((data:Users) => {

        if(data.success == "1"){
          this.toastr.success(data.message);

          this.users =  {
            id: data.id,
            documento: data.documento,
            nombres: data.nombres,
            apellidos: data.apellidos,
            telefono: data.telefono,
            email: data.email,
            password: data.password,
            confirm_password: data.password,
            rol: data.rol,
            is_active: data.is_active,
            created_at: data.created_at,
            success: data.success,
            message: data.message
          };

          const selectedRole = this.roles.find(role => role.id_rol === String(data.rol));
          
          if (selectedRole) {
            this.selectedRole = selectedRole.rol;
            this.selectRol.writeValue(selectedRole);
            
            this.selectedState = data.is_active == "1" ? "Activo" : "Inactivo";
            //Seteamos el documento del usuario buscado
            this.userService.setUserSelected(this.users.documento);
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
      this.users.rol = selectedRole?.id_rol;
      this.users.is_active = this.selectedState;
      this.userService.setUser(this.users).subscribe(
        (response: Users) => {
          if(response.success == "1" || response.success == "2"){
            // this.getUser(this.users.documento);
            
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
    
    if(user.documento == ""){
      this.toastr.warning("El documento es obligatorio.");
      return false;
    }

    if(user.nombres == ""){
      this.toastr.warning("El nombre es obligatorio.");
      return false;
    }

    if(user.apellidos == ""){
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
