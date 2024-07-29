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
  message: string;
  success: boolean;
  token?: string;
  result: T;
}

export interface RequestResultObject<T> {
  message: string;
  success: boolean;
  token?: string;
  result: T[];
}

export interface Users {
userID: string;
document: string;
name: string;
lastname: string;
address: string;
email: string;
phone: string;
password: string;
urlPicProfile : string;
urlImageSignature: string;
state: string;
rol?: string;
rolID: string;
isAdmin: boolean;
addAt: string;
}

export interface TypeDocument{
  id: string;
  type: string;
  abbreviation: string;
}

export interface Persons {
  id: string;
  name: string;
  lastname : string;
  numberDocument : number;
  email : string; 
  typeDocument : string; 
  addAt : string; 
  numberDocumentTypeDocument : string;
  fullName : string;
}