
export interface MenuItem {
  id?: number;
  label?: string;
  icon?: string;
  link?: string;
  expanded?: boolean;
  subItems?: any;
  isTitle?: boolean;
  badge?: any;
  parentId?: number;
  hasPermission?:boolean;
}

export interface MenuData {
  id_menu : string;
  label : string;
  link : string;
  is_item : string;
  is_subitem : string;
  is_parent : string;
  id_menu_parent : string;
  label_item_parent : string;
  state : string;
  addAt : string;
  updateAt : string;
  id_user : string;
  checked?: boolean;
}