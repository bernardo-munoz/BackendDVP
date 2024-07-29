import { Component, Input, OnInit, SimpleChanges } from '@angular/core';
import { DataTable } from 'simple-datatables';
import { RequestResultPHP } from 'src/app/models/request-result';
import { Users } from '../model/user';
import { UserService } from '../services/user.service';
import * as XLSX from 'xlsx';
import 'datatables.net-buttons/js/dataTables.buttons';
import 'datatables.net-buttons/js/buttons.html5';
import { SharedService } from 'services/shared.service';
import { Persons, RequestResultObject } from '../../../auth/model/auth';

@Component({
  selector: 'app-list-user',
  templateUrl: './list-user.component.html',
  styleUrls: ['./list-user.component.scss']
})
export class ListUserComponent implements OnInit {
  @Input() refresh: boolean = false;
  users:Persons[] = [];
  dataTable: DataTable;

  constructor(
    private userService: UserService,
    private sharedService:SharedService
  ) { }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes['refresh'] && changes['refresh'].currentValue === true) {
      this.getListUsers();
      this.refresh = false;  // Resetear el valor después de refrescar
    }
  }

  ngAfterViewInit(): void {
    // Agregar evento al botón de exportar
    const exportButton = document.getElementById('exportButton');
    if (exportButton) {
      exportButton.addEventListener('click', () => this.exportToExcel(this.dataTable));
    }

    // Delegación de eventos para los clics en los iconos de edición
    const listUsersElement = document.querySelector('#listUsers');
    if (listUsersElement) {
      listUsersElement.addEventListener('click', (event: Event) => {
        const target = event.target as HTMLElement;
        if (target && target.classList.contains('fa-eye')) {
          const userId = target.getAttribute('data-user-id');
          if (userId) {
            this.getUser(userId);
          }
        }
      });
    }
  }

  ngOnInit(): void {
    this.getListUsers();
  }

  getUser(id_user: string){
    this.userService.setUserSelectedEdit(id_user);
  }

  getListUsers(){
    this.userService.getListUsers().subscribe((data: RequestResultObject<Persons>) => {

      if (data.success) {
        this.users = data.result;

        // Asegurarse de que DataTable se inicializa después de que los datos se asignen
        setTimeout(() => {
          if (this.dataTable) {
            this.dataTable.destroy(); // Destruye la instancia existente antes de crear una nueva
          }
          this.dataTable = new DataTable("#listUsers");
        }, 100);
      }
    });
  }


  exportToExcel(dataTable: DataTable): void {
    this.sharedService.showLoader(true);
    const data = dataTable.data;

    if (!data || data.length === 0) {
      console.error('No hay datos para exportar.');
      this.sharedService.showLoader(false);
      return;
    }

    const dataArray: any[] = [];

    // Iterar sobre las filas de datos
    for (const row of data) {
      const rowData: any[] = [];

      // Iterar sobre las celdas de cada fila
      const cells = row.children;
      for (let i = 0; i < cells.length; i++) {
        rowData.push(cells[i].textContent);
      }

      dataArray.push(rowData);
    }

    // Crear la hoja de Excel
    const ws: XLSX.WorkSheet = XLSX.utils.aoa_to_sheet(dataArray);

    // Crear el libro de Excel y agregar la hoja de datos
    const wb: XLSX.WorkBook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    // Descargar el archivo Excel
    XLSX.writeFile(wb, 'Registros_Usuarios.xlsx');

    this.sharedService.showLoader(false);
  }
}
