import { Component, ElementRef, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { RequestResultPHP } from 'src/app/models/request-result';
import { MenuData, MenuItem } from 'src/app/views/layout/sidebar/menu.model';
import { Roles, MenuRol } from '../model/user';
import { UserService } from '../services/user.service';
import { SidebarService } from '../../../../layout/sidebar/services/sidebar.service';
import { MENU } from 'src/app/views/layout/sidebar/menu';
import { NgForm } from '@angular/forms';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { NgSelectComponent } from '@ng-select/ng-select';

@Component({
  selector: 'app-roles',
  templateUrl: './roles.component.html',
  styleUrls: ['./roles.component.scss']
})
export class RolesComponent implements OnInit {
  @ViewChild('nameRolInput') nameRolInput!: ElementRef;
  @ViewChild('selectRol') selectRol: NgSelectComponent;

  public roles:Roles[] = [];
  public selectedRol: string;
  public menuItems: MenuData[] = [];
  public modalRol: boolean = false;
  public name_rol: string;
  public id_rol: string = "0";
  basicModalCloseResult: string = "";

  constructor(
    private userService: UserService,
    private toastr: ToastrService,
    private modalService: NgbModal
  ) { this.getRoles(); }

  ngOnInit(): void {
    this.getMenuItem();
  }

  openBasicModal(content: TemplateRef<any>) {
    this.modalService.open(content, {}).result.then((result) => {
      this.basicModalCloseResult = "Modal closed" + result
    }).catch((res) => {});
  }

  onClear() {
    this.menuItems.forEach(item => item.checked = false);
    // Actualiza el valor de name_rol con el texto del rol seleccionado
    this.name_rol = "";
    this.id_rol = "0";
  }

  delRol(){
    if (this.name_rol === "" || this.name_rol === undefined) {
      this.toastr.warning("Debe seleccionar un rol a eliminar.");
      this.nameRolInput.nativeElement.focus();
    } else {

      this.userService.setRol(this.id_rol , this.name_rol, "0").subscribe((data: RequestResultPHP<Roles>) => {
        if (data.success == "1") {
          this.toastr.success(data.message);

          this.getRoles();

          // Establecer el primer elemento como la opción predeterminada
          if (this.roles.length > 0) {
            this.selectedRol = this.roles[this.roles.length].id_rol;
          }
        } else {
          this.toastr.error(data.message);
        }
      });
    }
  }

  setRol(){
    if (this.name_rol === "" || this.name_rol === undefined) {
      this.toastr.warning("Debe ingresar un rol");
      this.nameRolInput.nativeElement.focus();
    } else {

      this.userService.setRol(this.id_rol, this.name_rol, "1").subscribe((data: RequestResultPHP<Roles>) => {
        if (data.success == "1") {
          this.toastr.success(data.message);
          this.getRoles();

        } else {
          this.toastr.error(data.message);
        }
      });
    }
  }

  getRoles(){
    this.userService.getRoles().subscribe((data: RequestResultPHP<Roles>) => {

      if(data.success == "1"){
        this.toastr.success(data.message);
        this.roles = Object.values(data.result);

        // Actualiza el valor de name_rol con el texto del rol seleccionado
        this.name_rol =  "";
        this.id_rol =  "0";
        this.selectRol.clearModel();

      }
      else{
        this.toastr.error(data.message);
      }
    });
  }

  getMenuItem() {
    //Consultamos los menus asociados al usuario
    this.userService.getMenu().subscribe(
      (res: RequestResultPHP<MenuData>) => {

        if (res.success == "1") {
          this.menuItems = Object.values(res.result);


        }
      },
      (error: any) => {
        console.error(error);
        this.toastr.error('Error al consultar la información de menu. Intente nuevamente.');
      }
    );
  }

  cleanForm(){

    this.selectedRol = "";

  }

  setMenuRol(item: MenuData, event: any) {

    if(this.id_rol == "0"){
      event.target.checked = false;
      this.toastr.warning("Debe seleccionar un rol primero.");
    }
    else{
      var menuRol: MenuRol = {
        id_menu: item.id_menu,
        id_rol: this.id_rol,
        state: event.target.checked
      }

      this.userService.setMenuRol(menuRol).subscribe(
      (response: RequestResultPHP<MenuRol>) => {
        if(response.success == "1")
          this.toastr.success(response.message);
        else
          this.toastr.warning(response.message);

      },
      (error) => {
        console.error(error);
        this.toastr.error('Error al guardar la información. Intente nuevamente.');
      }
      );
    }

  }

  getMenuRoles(){
    if(this.selectedRol){
      // Obtén el rol seleccionado
      const selectedIndex = this.roles.findIndex(role => role.rol === this.selectedRol);
      if (selectedIndex !== -1) {
        const selectedRoleId = this.roles[selectedIndex].id_rol;

        // Actualiza el valor de name_rol con el texto del rol seleccionado
        this.name_rol = this.selectedRol;
        this.id_rol = selectedRoleId;

        this.userService.getMenuByRol(selectedRoleId).subscribe((data: RequestResultPHP<MenuData>) => {

          this.menuItems.forEach(item => item.checked = false);
          if(data.success == "1"){
            this.toastr.success(data.message);
            // Crear un mapa para buscar eficientemente por id_menu
            const menuMap = new Map<string, MenuData>();
            Object.values(data.result).forEach(item => {
              menuMap.set(item.id_menu, { ...item, checked: false });
            });

            // Actualizar los checkboxes según la coincidencia de id_menu
            this.menuItems = this.menuItems.map(item => {
              const menuData = menuMap.get(item.id_menu);
              if (menuData) {
                item.checked = true; // Actualizar el estado del checkbox
              }
              return item;
            });
          }
          else{
            this.toastr.error(data.message);
          }
        });
      }
    }
  }

  addRol(){
    this.modalRol = true;
  }

}
