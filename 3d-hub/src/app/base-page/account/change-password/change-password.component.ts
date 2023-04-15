import {
  Component,
  ChangeDetectionStrategy,
  OnInit,
  OnDestroy,
  ChangeDetectorRef,
} from '@angular/core';
import { Store } from '@ngrx/store';
import * as fromApp from '@app/base-page/_store';
import { Observable, Subject } from 'rxjs';

import { UsersActions, UserModalStatus } from '@app/base-page/_store/user';
import { FormBuilder, Validators, FormGroup } from '@angular/forms';
import { takeUntil } from 'rxjs/operators';

@Component({
  selector: 'app-change-password-component',
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ChangePasswordComponent implements OnInit, OnDestroy {
  private unsubscribe$: Subject<void> = new Subject();
  updateProfilePasswordLoading$: Observable<boolean>;
  validateForm: FormGroup;

  private unsubscribe: Subject<void> = new Subject();

  constructor(
    private cd: ChangeDetectorRef,
    private store$: Store<fromApp.PageState>,
    private fb: FormBuilder
  ) {}

  ngOnInit() {
    this.setup();

    this.store$
      .select(fromApp.getUserView)
      .pipe(takeUntil(this.unsubscribe$))
      .subscribe((payload) => {
        const { status, errors } = payload;
        if (errors.length > 0) {
          errors.forEach((e) => {
            const { field, message } = e;
            const control = this.validateForm.get(field);
            if (control) {
              control.setErrors([{ error: true, duplicated: true, message }]);
            }
          });
        }

        if (status === UserModalStatus.Success) {
          this.validateForm.reset();
        }
        this.cd.detectChanges();
      });
  }

  ngOnDestroy() {
    this.unsubscribe.next();
    this.unsubscribe.complete();
  }

  setup() {
    this.createForm();
  }

  createForm() {
    this.validateForm = this.fb.group({
      currentPassword: [null, [Validators.required]],
      newPassword: [null, Validators.required],
      againPassword: [null, Validators.required],
    });
  }

  onKeyupAgainPassword(value: string) {
    if (typeof value === 'string' && value !== '') {
      if (this.validateForm.get('newPassword').value !== value) {
        this.validateForm.get('againPassword').setErrors({ notmatch: true });
        this.cd.detectChanges();
      }
    }
  }

  onSumbit() {
    const value = this.validateForm.value;
    this.store$.dispatch(UsersActions.changeMyPassword({ payload: value }));
  }
}
