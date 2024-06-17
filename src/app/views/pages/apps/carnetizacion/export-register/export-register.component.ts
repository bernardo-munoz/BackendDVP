import { AfterViewInit, Component, OnInit } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { General, RequestResultPHP } from 'src/app/models/request-result';
import { ExportService } from './services/export.service';
import * as XLSX from 'xlsx';
import { DataTable } from "simple-datatables";
// import DataTable from 'simple-datatables';
import 'datatables.net-buttons/js/dataTables.buttons';
import 'datatables.net-buttons/js/buttons.html5';
import { SharedService } from '../../../../../../../services/shared.service';
@Component({
  selector: 'app-export-register',
  templateUrl: './export-register.component.html',
  styleUrls: ['./export-register.component.scss']
})
export class ExportRegisterComponent implements AfterViewInit, OnInit {

  register: General[] = [];
  type: string = "Estudiante";
  dataTable: DataTable;

  constructor(
    private exportService: ExportService,
    private toastr: ToastrService,
    private sharedService: SharedService
  ) { }

  ngAfterViewInit(): void {
    this.dataTable = new DataTable('#tablePictures');

    // Agregar evento al botón de exportar
    const exportButton = document.getElementById('exportButton');
    if (exportButton) {
      exportButton.addEventListener('click', () => this.exportToExcel(this.dataTable));
    }
  }

  ngOnInit(): void { }

  setType(e: any) {
    this.register = [];
    this.type = e.target.value;
    // this.getRegister();
  }

  getRegister() {

    // Guardamos o actualizamos la información en BD del sistema y no de SMA...
    this.exportService.getReportCarnetizacionByType(this.type).subscribe(
      (res: RequestResultPHP<General>) => {

        //Limpiamos los datos
        this.dataTable.destroy();

        if (res.success == "1") {
          this.register = Object.values(res.result);

          if (this.dataTable) {
            this.updateTableBody();
          }
        }
        //Inicializamos el DataTable despues de cargar los datos
        this.dataTable.init();
      },
      (error) => {
        console.error(error);
        this.toastr.error('Error al consultar la información de carnetización. Intente nuevamente.');
      }
    );

  }

  updateTableBody() {
    if (this.dataTable && this.register.length > 0) {
      const tableBody = this.dataTable.table.querySelector('tbody');

      if (tableBody) {
        // Limpia el cuerpo actual de la tabla
        tableBody.innerHTML = '';

        // Agrega filas con los nuevos datos
        this.register.forEach((person) => {
          const row = tableBody.insertRow();

          // Ajusta esto según la estructura exacta de tus datos
          row.insertCell().textContent = person.id_carnet;
          row.insertCell().textContent = person.document;
          row.insertCell().textContent = person.name;
          row.insertCell().textContent = person.last_name;
          row.insertCell().textContent = person.program;
          row.insertCell().textContent = person.type;
          row.insertCell().textContent = person.state;
          row.insertCell().textContent = person.rh;
          row.insertCell().textContent = person.addAt;
          row.insertCell().textContent = person.updateAt;
          row.insertCell().textContent = person.url;

          // Crea un enlace para ver la foto
          const viewPhotoCell = row.insertCell();
          const viewPhotoLink = document.createElement('a');
          viewPhotoLink.target = '_blank';
          viewPhotoLink.href = person.url;
          viewPhotoLink.innerHTML = '<i class="fa fa-eye"></i>';
          viewPhotoCell.appendChild(viewPhotoLink);
        });
      }
    }
  }

  handlePageChange(event: any) {
    // Asegúrate de que $event contiene la propiedad 'page'
    // Luego, realiza las acciones adicionales si es necesario
    // ...
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
    XLSX.writeFile(wb, 'Registros_'+this.type+'.xlsx');

    this.sharedService.showLoader(false);
  }
}
