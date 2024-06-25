import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { LoginService } from '../services/login.service';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  public registerForm: FormGroup; // Formulario Reactivo
  submitted = false; // Para verificar si el formulario ha sido enviado
  errorMessage: string = ""; // Mensaje de error

  constructor(
    private router: Router,
    private formBuilder: FormBuilder,
    private loginService: LoginService,
    private toastr: ToastrService
   ) { }

  ngOnInit(): void {
    // Inicializar el formulario con formBuilder
    this.registerForm = this.formBuilder.group({
      document: ['', Validators.required],
      name: ['', Validators.required],
      lastname: ['', Validators.required],
      address: [''],
      email: ['', [Validators.required, Validators.email]],
      phone: ['', Validators.pattern('^[0-9]{10}$')],
      password: ['', [Validators.required, Validators.minLength(6)]],
      authCheck: [false, Validators.required]
    });
  }

    get f() { return this.registerForm.controls; }

  onRegister() {

    this.submitted = true;

    // Detener aquí si el formulario es inválido
    if (this.registerForm.invalid || !this.f.authCheck.value) {
      Object.keys(this.registerForm.controls).forEach(key => {
        const control = this.registerForm.get(key);
        if (control) {
          control.markAsTouched();
          control.markAsDirty();
        }
      });
      return;
    }

    // Llamar al servicio para guardar los datos del usuario
    this.loginService.setUsers(this.registerForm.value).subscribe(
      response => {
        if(response.success){
          this.toastr.success(response.message);
          this.registerForm.reset();
          this.router.navigate(['/auth/login']);

        }else{
          this.toastr.error(response.message);

          this.router.navigate(['/auth/login']);
        }
      },
      error => {
        console.error('Error al registrar usuario', error);
        this.errorMessage = 'Error al registrar usuario. Por favor, inténtelo de nuevo.';

      }
    );
  }

}
