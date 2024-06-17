import { Component, OnInit, ViewChild, ElementRef, AfterViewInit, Renderer2, Inject } from '@angular/core';
import { DOCUMENT } from '@angular/common';

import MetisMenu from 'metismenujs';

import { MENU } from './menu';
import { MenuItem, MenuData } from './menu.model';
import { Router, NavigationEnd } from '@angular/router';
import { RequestResultPHP } from 'src/app/models/request-result';
import { ToastrService } from 'ngx-toastr';
import { SidebarService } from './services/sidebar.service';
import { SESSION_ID_ROL, SESSION_LS_NAME, SESSION_TYPE_ROL } from 'src/app/models/consts';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit, AfterViewInit {

  @ViewChild('sidebarToggler') sidebarToggler: ElementRef;

  menuItems: MenuItem[] = [];
  @ViewChild('sidebarMenu') sidebarMenu: ElementRef;
  rol: string = sessionStorage.getItem(SESSION_ID_ROL) ?? "0";

  constructor(
    @Inject(DOCUMENT) private document: Document,
    router: Router,
    private sidebarService: SidebarService,
    private toastr: ToastrService
  ) {
    //Validamos session
    const isLoggedin = sessionStorage.getItem(SESSION_LS_NAME);

    if (isLoggedin !== 'true') {
      localStorage.removeItem(SESSION_LS_NAME);
      localStorage.removeItem(SESSION_LS_NAME);
      localStorage.removeItem(SESSION_TYPE_ROL);

      // Redirige a la página de inicio de sesión
      router.navigate(['/auth/login']);
    }

    router.events.forEach((event) => {
      if (event instanceof NavigationEnd) {

        /**
         * Activating the current active item dropdown
         */
        this._activateMenuDropdown();

        /**
         * closing the sidebar
         */
        if (window.matchMedia('(max-width: 991px)').matches) {
          this.document.body.classList.remove('sidebar-open');
        }

      }
    });
  }

  ngOnInit(): void {

    this.menuItems = MENU;
    this.getMenuItem();
    /**
     * Sidebar-folded on desktop (min-width:992px and max-width: 1199px)
     */
    const desktopMedium = window.matchMedia('(min-width:992px) and (max-width: 1199px)');
    desktopMedium.addEventListener('change', () => {
      this.iconSidebar;
    });
    this.iconSidebar(desktopMedium);
  }

  getMenuItem() {
    //Consultamos los menus asociados al usuario
    this.sidebarService.getMenuByRol(this.rol).subscribe(
      (res: RequestResultPHP<MenuData>) => {

        if (res.success == "1") {
          const menuData: MenuData[] = Object.values(res.result);

          //Si no eres admin se filtran los menus
          if(this.rol.toString() != "1"){
            // Obtener las etiquetas permitidas
            const allowedMenuLabels = menuData.map(item => item.label).filter(label => label !== undefined);

            // Filtrar el menú basado en las etiquetas permitidas, excluyendo ciertos elementos
            this.menuItems = this.filterMenuItems(MENU, allowedMenuLabels, ['Menu', 'Inicio', 'Opciones']);
          }
        }
        else{
          this.menuItems = [];
        }
      },
      (error: any) => {
        console.error(error);
        this.toastr.error('Error al consultar la información de carnetización. Intente nuevamente.');
      }
    );
  }

  // Función para filtrar los elementos del menú basados en etiquetas permitidas, excluyendo ciertos elementos
  filterMenuItems(menu: MenuItem[], allowedLabels: (string | undefined)[], exceptions: string[]): MenuItem[] {
    return menu.filter(item => {
      // Verificar si el elemento es una excepción, si lo es, mantenerlo
      if (item.label !== undefined && exceptions.includes(item.label)) {
        return true;
      }

      // Si el elemento tiene subelementos, aplicar recursividad
      if (item.subItems && item.subItems.length > 0) {
        item.subItems = this.filterMenuItems(item.subItems, allowedLabels, exceptions);
        return item.subItems.length > 0;
      }

      // Si el label está permitido (y no es undefined), mantener el elemento
      return item.label !== undefined && allowedLabels.includes(item.label);
    });
  }

  ngAfterViewInit() {
    // activate menu item
    new MetisMenu(this.sidebarMenu.nativeElement);

    this._activateMenuDropdown();
  }

  /**
   * Toggle sidebar on hamburger button click
   */
  toggleSidebar(e: Event) {
    this.sidebarToggler.nativeElement.classList.toggle('active');
    this.sidebarToggler.nativeElement.classList.toggle('not-active');
    if (window.matchMedia('(min-width: 992px)').matches) {
      e.preventDefault();
      this.document.body.classList.toggle('sidebar-folded');
    } else if (window.matchMedia('(max-width: 991px)').matches) {
      e.preventDefault();
      this.document.body.classList.toggle('sidebar-open');
    }
  }


  /**
   * Toggle settings-sidebar
   */
  toggleSettingsSidebar(e: Event) {
    e.preventDefault();
    this.document.body.classList.toggle('settings-open');
  }


  /**
   * Open sidebar when hover (in folded folded state)
   */
  operSidebarFolded() {
    if (this.document.body.classList.contains('sidebar-folded')){
      this.document.body.classList.add("open-sidebar-folded");
    }
  }


  /**
   * Fold sidebar after mouse leave (in folded state)
   */
  closeSidebarFolded() {
    if (this.document.body.classList.contains('sidebar-folded')){
      this.document.body.classList.remove("open-sidebar-folded");
    }
  }

  /**
   * Sidebar-folded on desktop (min-width:992px and max-width: 1199px)
   */
  iconSidebar(mq: MediaQueryList) {
    if (mq.matches) {
      this.document.body.classList.add('sidebar-folded');
    } else {
      this.document.body.classList.remove('sidebar-folded');
    }
  }


  /**
   * Switching sidebar light/dark
   */
  onSidebarThemeChange(event: Event) {
    this.document.body.classList.remove('sidebar-light', 'sidebar-dark');
    this.document.body.classList.add((<HTMLInputElement>event.target).value);
    this.document.body.classList.remove('settings-open');
  }


  /**
   * Returns true or false if given menu item has child or not
   * @param item menuItem
   */
  hasItems(item: MenuItem) {
    return item.subItems !== undefined ? item.subItems.length > 0 : false;
  }


  /**
   * Reset the menus then hilight current active menu item
   */
  _activateMenuDropdown() {
    this.resetMenuItems();
    this.activateMenuItems();
  }


  /**
   * Resets the menus
   */
  resetMenuItems() {

    const links = document.getElementsByClassName('nav-link-ref');

    for (let i = 0; i < links.length; i++) {
      const menuItemEl = links[i];
      menuItemEl.classList.remove('mm-active');
      const parentEl = menuItemEl.parentElement;

      if (parentEl) {
          parentEl.classList.remove('mm-active');
          const parent2El = parentEl.parentElement;

          if (parent2El) {
            parent2El.classList.remove('mm-show');
          }

          const parent3El = parent2El?.parentElement;
          if (parent3El) {
            parent3El.classList.remove('mm-active');

            if (parent3El.classList.contains('side-nav-item')) {
              const firstAnchor = parent3El.querySelector('.side-nav-link-a-ref');

              if (firstAnchor) {
                firstAnchor.classList.remove('mm-active');
              }
            }

            const parent4El = parent3El.parentElement;
            if (parent4El) {
              parent4El.classList.remove('mm-show');

              const parent5El = parent4El.parentElement;
              if (parent5El) {
                parent5El.classList.remove('mm-active');
              }
            }
          }
      }
    }
  };


  /**
   * Toggles the menu items
   */
  activateMenuItems() {

    const links: any = document.getElementsByClassName('nav-link-ref');

    let menuItemEl = null;

    for (let i = 0; i < links.length; i++) {
      // tslint:disable-next-line: no-string-literal
        if (window.location.pathname === links[i]['pathname']) {

            menuItemEl = links[i];

            break;
        }
    }

    if (menuItemEl) {
        menuItemEl.classList.add('mm-active');
        const parentEl = menuItemEl.parentElement;

        if (parentEl) {
            parentEl.classList.add('mm-active');

            const parent2El = parentEl.parentElement;
            if (parent2El) {
                parent2El.classList.add('mm-show');
            }

            const parent3El = parent2El.parentElement;
            if (parent3El) {
                parent3El.classList.add('mm-active');

                if (parent3El.classList.contains('side-nav-item')) {
                    const firstAnchor = parent3El.querySelector('.side-nav-link-a-ref');

                    if (firstAnchor) {
                        firstAnchor.classList.add('mm-active');
                    }
                }

                const parent4El = parent3El.parentElement;
                if (parent4El) {
                    parent4El.classList.add('mm-show');

                    const parent5El = parent4El.parentElement;
                    if (parent5El) {
                        parent5El.classList.add('mm-active');
                    }
                }
            }
        }
    }
  };


}
