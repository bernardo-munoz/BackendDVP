export interface Users{
  id_user: string;
  document: string;
  name: string;
  lastname: string;
  phone: string;
  email: string;
  state: string;
  id_rol: string;
  addAt: string;
  rol: string;
  password?:string;
  confirm_password?:string;

}

export interface Roles{
    id_rol: string;
    rol: string;
    state?: string;
}

export interface States{
  id_state: string;
  state?: string;
}

export interface Modulos{
    id_menu : string;
    label : string;
    is_item : string;
    is_subitem : string;
}

export interface Permisos{
    id_permiso : string;
    documento : string;
    id_modulo : string;
    habilitado : string;
}

export interface MenuRol{
    id_menu : string;
    id_rol : string;
    state?: boolean;
}
