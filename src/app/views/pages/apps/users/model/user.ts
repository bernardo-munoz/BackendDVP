export interface Users{
    id: string;
    documento: string;
    nombres: string;
    apellidos: string;
    telefono: string;
    email: string;
    password: string;
    confirm_password: string;
    rol: string;
    is_active: string;
    created_at: string;
    success: string;
    message: string;

}

export interface Roles{
    id_rol: string;
    rol: string;
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