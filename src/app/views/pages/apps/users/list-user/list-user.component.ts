import { Component, Input, OnInit, SimpleChanges } from '@angular/core';
import { DataTable } from 'simple-datatables';
import { RequestResultPHP } from 'src/app/models/request-result';
import { Users } from '../model/user';
import { UserService } from '../services/user.service';
import * as XLSX from 'xlsx';
import 'datatables.net-buttons/js/dataTables.buttons';
import 'datatables.net-buttons/js/buttons.html5';
import { SharedService } from 'services/shared.service';

@Component({
  selector: 'app-list-user',
  templateUrl: './list-user.component.html',
  styleUrls: ['./list-user.component.scss']
})
export class ListUserComponent implements OnInit {
  @Input() refresh: boolean = false;
  users:Users[] = [];
  filteredUsers: Users[] = [];
  searchText: string = '';
  currentPage: number = 1;
  itemsPerPage: number = 10;
  dataTable: DataTable;
  totalItems: number = 0;     // Total de items para la paginación

  constructor(
    private userService: UserService,
    private sharedService:SharedService
  ) { }

  ngAfterViewInit(): void {

    // Agregar evento al botón de exportar
    const exportButton = document.getElementById('exportButton');
    if (exportButton) {
      exportButton.addEventListener('click', () => this.exportToExcel(this.dataTable));
    }
  }

  ngOnInit(): void {
    this.getListUsers();
  }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes.refresh && changes.refresh.currentValue) {

      if(this.refresh)
        this.getListUsers();

      this.refresh = false;

    }
  }

  getUser(id_user: string){
    this.userService.setUserSelectedEdit(id_user);
  }

  getListUsers(){
    this.userService.getListUsers().subscribe((data: RequestResultPHP<Users>) => {

      if (data.success === '1') {
        this.users = Object.values(data.result);

        this.applyFilter();
      }
    });
  }

  applyFilter() {
    if (this.searchText) {
      this.filteredUsers = this.users.filter(user =>
        user.name.toLowerCase().includes(this.searchText.toLowerCase()) ||
        user.document.toLowerCase().includes(this.searchText.toLowerCase())
      );
    } else {
      this.filteredUsers = [...this.users];
    }
  }

  onSearchTextChange() {
    this.applyFilter();
    this.currentPage = 1;
  }

  pageChanged(event: any) {
    this.currentPage = event.page;
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
