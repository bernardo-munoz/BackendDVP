import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { General, RequestResultPHP } from 'src/app/models/request-result';
import { ExportService } from './services/export.service';

@Component({
  selector: 'app-export-register',
  templateUrl: './export-register.component.html',
  styleUrls: ['./export-register.component.scss']
})
export class ExportRegisterComponent implements OnInit {

  register: General[] = [];
  type: string = "Estudiante";

  columns = [
    { prop: 'id_carnet', name: '#' },
    { prop: 'document', name: 'Documento' },
    { prop: 'name', name: 'Nombre' },
    { prop: 'last_name', name: 'Apellido' },
    { prop: 'program', name: 'Programa' },
    { prop: 'type', name: 'Tipo' },
    { prop: 'state', name: 'Estado' },
    { prop: 'rh', name: 'RH' },
    { prop: 'addAt', name: 'Registro' },
    { prop: 'updateAt', name: 'Actualizado' },
    { prop: 'url', name: 'URL Foto' },
    {
      name: 'Ver Imagen',
      cellTemplate: `
        <ng-template let-row="row" ngx-datatable-cell-template>
          <a href="{{ row.url }}" target="_blank"><i class="fas fa-eye"></i> Ver Imagen</a>
        </ng-template>
      `
    }
  ];

  // Variables de paginación
  public page: number = 1;
  pageSize: number = 10; // Número de elementos por página
  totalItems: number = 0; // Número total de elementos en tu conjunto de datos

  constructor(
    private exportService: ExportService,
    private toastr: ToastrService,
    private cdr: ChangeDetectorRef
  ) { }

  ngOnInit(): void {
    // this.getRegister();
  }

  setType(e: any) {
    this.register = [];
    this.type = e.target.value;
    // this.getRegister();
  }

  getRegister() {
    
    // Guardamos o actualizamos la información en BD del sistema y no de SMA...
    this.exportService.getReportCarnetizacionByType(this.type).subscribe(
      (res: RequestResultPHP<General>) => {
        if (res.success == "1") {
          this.register = Object.values(res.result);
          this.totalItems = this.register.length;

          // Actualizamos la detección de cambios
          this.cdr.detectChanges();
        }
      },
      (error) => {
        console.error(error);
        this.toastr.error('Error al consultar la información de carnetización. Intente nuevamente.');
      }
    );

  }

  handlePageChange(event: any) {
    // Asegúrate de que $event contiene la propiedad 'page'
    this.page = event?.page ?? 1;
    // Luego, realiza las acciones adicionales si es necesario
    // ...
  }
}
