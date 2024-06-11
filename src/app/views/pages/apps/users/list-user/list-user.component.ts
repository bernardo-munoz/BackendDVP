import { Component, OnInit } from '@angular/core';
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

  users:Users[] = [];
  dataTable: DataTable;

  constructor(
    private userService: UserService,
    private sharedService:SharedService
  ) { }

  ngAfterViewInit(): void {
    // this.dataTable = new DataTable('#tableUsers');
    // $('#tableUsers').DataTable();
    // Agregar evento al botón de exportar
    // const exportButton = document.getElementById('exportButton');
    // if (exportButton) {
    //   exportButton.addEventListener('click', () => this.exportToExcel(this.dataTable));
    // }
  }

  ngOnInit(): void {
    this.getListUsers();
  }

  getUser(user: Users){
    this.userService.setUserSelectedEdit(user.documento);
  }

  getListUsers(){
    this.userService.getListUsers().subscribe((data: RequestResultPHP<Users>) => {

       //Limpiamos los datos
      //  this.dataTable.destroy();

       if (data.success == "1") {
         this.users = Object.values(data.result);
         
        //  if (this.dataTable) {
        //    this.updateTableBody();
        //  }
       }
       //Inicializamos el DataTable despues de cargar los datos
      //  this.dataTable.init();
    });
  }

  
  updateTableBody() {
    if (this.dataTable && this.users.length > 0) {
      const tableBody = this.dataTable.table.querySelector('tbody');
  
      if (tableBody) {
        // Limpia el cuerpo actual de la tabla
        tableBody.innerHTML = '';
  
        // Agrega filas con los nuevos datos
        this.users.forEach((user) => {
          const row = tableBody.insertRow();
          
          // Ajusta esto según la estructura exacta de tus datos
          row.insertCell().textContent = user.id;
          row.insertCell().textContent = user.documento;
          row.insertCell().textContent = user.nombres;
          row.insertCell().textContent = user.apellidos;
          row.insertCell().textContent = user.rol;
          row.insertCell().textContent = user.is_active == "1" ? "Activo" : "Inactivo";
  
          // Crea un enlace para ver la foto
          const viewPhotoCell = row.insertCell();
          const viewPhotoLink = document.createElement('a');
          viewPhotoLink.style.cursor = 'pointer'; // Agrega el estilo del cursor
          viewPhotoLink.innerHTML = '<i class="fa fa-eye" onclick=(getUser(' + user.documento + '))></i>';
          // viewPhotoLink.addEventListener('click', () => this.getUser(user));
          viewPhotoCell.appendChild(viewPhotoLink);
          console.log('Enlace de la foto:', viewPhotoLink);
        });
      }
    }
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
