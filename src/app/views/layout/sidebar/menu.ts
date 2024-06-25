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
    label: 'Documentos',
    icon: 'file-minus',
    subItems: [
      {
        label: 'Pendientes',
        link: '/apps/pending-documents',
      },
      {
        label: 'Firmados',
        link: '/apps/signed-documents'
      },
    ]
  },
  {
    label: 'Usuarios',
    icon: 'users',
    subItems: [
      {
        label: 'Crear Usuarios',
        link: '/apps/users'
      }
    ]
  }
];
