import { MenuItem } from './menu.model';

export const MENU: MenuItem[] = [
  {
    label: 'Menu',
    isTitle: true
  },
  {
    label: 'Inicio',
    icon: 'home',
    link: '/dashboard'
  },
  {
    label: 'Opciones',
    isTitle: true
  },
  {
    label: 'Usuarios',
    icon: 'users',
    subItems: [
      {
        label: 'Listar Usuarios',
        link: '/apps/users'
      }
    ]
  }
];
