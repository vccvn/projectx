import { Component, OnInit } from '@angular/core';
import { Store } from '@ngrx/store';
import * as fromAuth from '../store';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  submitted = false;
  error = false;
  isAuthenticating$: Observable<boolean>;
  constructor(private store: Store<fromAuth.AuthState>, private formBuilder: FormBuilder) {}

  ngOnInit() {
    this.loginForm = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required],
      remember: [false, Validators.required],
    });

    this.isAuthenticating$ = this.store.select(fromAuth.getIsAuthenticating);
  }

  get f(): any {
    if (typeof this.loginForm !== 'undefined') {
      return this.loginForm.controls;
    }
  }

  onSubmit(): void {
    this.submitted = true;
    if (this.loginForm.valid) {
      const actionPayload = {
        email: this.f.email.value,
        password: this.f.password.value,
      };
      this.store.dispatch(new fromAuth.Login(actionPayload));
    }
  }
}
