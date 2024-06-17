export interface LoginData{
    apellidos: string;
    documento: string;
    email: string;
    encontrados: string;
    id: string;
    is_active: string;
    message: string;
    nombres: string;
    password: string;
    rol: string;
    success: string;
    telefono: string;
}

export interface RequestResult<T> {
  encontrados: string;
  message: string;
  success: string;
  token: string;
  result: T[];
}

export interface Users {
id_user: string;
document: string;
name: string;
lastname: string;
phone: string;
email: string;
state: string;
id_rol: string;
addAt: string;
}
