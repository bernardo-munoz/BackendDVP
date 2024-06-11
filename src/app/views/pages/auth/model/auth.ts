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
  result: {};
}

export interface UserData {
  apellidos: string;
  documento: string;
  email: string;
  id: string;
  is_active: string;
  nombres: string;
  rol: string;
  telefono: string;
}
