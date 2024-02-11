export interface RequestResult<T> {

  isSuccessful: boolean;
  isError: boolean;
  errorMessage: string;
  messages: string[];
  result: {};
}

export interface RequestResultPHP<T> {

  success: string;
  sql: string;
  encontradas: string;
  message: string;
  result: T[];
}

export interface General{
  id_carnet: string;
  document: string;
  name: string;
  last_name: string;
  program: string;
  type: string;
  state: string;
  rh: string;
  addAt: string;
  updateAt: string;
  url: string;
}