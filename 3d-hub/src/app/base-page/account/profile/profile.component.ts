import { Component, OnInit, OnDestroy, ChangeDetectorRef, ChangeDetectionStrategy } from '@angular/core';
import { oc } from 'ts-optchain';
import * as fromApp from '@app/base-page/_store';
import { Store } from '@ngrx/store';
import { Observable, Subject } from 'rxjs';

import * as fromUser from '@app/base-page/_store';

import { UserModel, UsersActions, UserModalStatus } from '@app/base-page/_store/user';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { takeUntil } from 'rxjs/operators';

@Component({
  selector: 'app-profile-component',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ProfileComponent implements OnInit, OnDestroy {
  private unsubscribe$: Subject<void> = new Subject();
  model: UserModel;
  loading$: Observable<boolean>;
  validateForm: FormGroup;
  fileList = [];
  path = 'users/avatar';
  updateLoading = false;

  constructor(private store$: Store<fromApp.PageState>, private fb: FormBuilder, private cd: ChangeDetectorRef) {}

  ngOnInit() {
    this.setup();
    this.store$
      .select(fromUser.getProfile)
      .pipe(takeUntil(this.unsubscribe$))
      .subscribe((profile) => {
        this.model = profile;
        this.patchModel(profile);
        this.cd.detectChanges();
      });
    this.loading$ = this.store$.select(fromUser.getProfileLoading);
    this.dispatchFetch();

    this.store$
      .select(fromApp.getUserView)
      .pipe(takeUntil(this.unsubscribe$))
      .subscribe((payload) => {
        const { isLoading, status, errors } = payload;
        this.updateLoading = isLoading;

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
    this.unsubscribe$.next();
    this.unsubscribe$.complete();
  }

  setup() {
    this.createForm(null);
  }

  dispatchFetch() {
    this.store$.dispatch(UsersActions.getProfile());
  }

  createForm(data: UserModel) {
    const value = oc(data);
    this.validateForm = this.fb.group({
      id: [value.id()],
      fullName: [value.fullName(), [Validators.required]],
      email: [value.email(), Validators.required],
      phone: [value.phone(), Validators.required],
      username: [value.username()],
    });
    if (value.avatarUrl()) {
      this.fileList = [
        {
          url: value.avatarUrl(),
          status: 'done',
          name: 'done',
          uid: 'done',
        },
      ];
    }
  }

  patchModel(data) {
    const value = oc(data);
    if (this.validateForm) {
      this.validateForm.patchValue({
        id: value.id(),
        fullName: value.fullName(),
        email: value.email(),
        phone: value.phone(),
        username: value.username(),
      });
    }
    if (value.avatarUrl()) {
      this.fileList = [
        {
          url: value.avatarUrl(),
          status: 'done',
          name: 'done',
          uid: 'done',
        },
      ];
    }
  }

  onSumbit() {
    const value = this.validateForm.value;
    if (this.fileList.length > 0) {
      const { response } = this.fileList[0];
      if (response) {
        if (response.data && response.data.id) {
          value.avatarExtId = response.data.id;
        }
      }
    } else {
      value.avatarExtId = null;
    }
    this.store$.dispatch(UsersActions.updateMyProfile({ payload: value }));
  }
}
