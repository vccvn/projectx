import { Component, ChangeDetectionStrategy, ChangeDetectorRef, OnInit, OnDestroy, ViewChild, ElementRef } from '@angular/core';
import { FormGroup, Validators, FormBuilder } from '@angular/forms';

import { Subject } from 'rxjs';
import { takeUntil } from 'rxjs/operators';
import { NzModalRef } from 'ng-zorro-antd/modal';

import { Store } from '@ngrx/store';
import * as fromApp from '../../_store';

import { noWhitespaceValidator } from '@app/_shared/validators';
import { FolderModalStatus, FolderModalType, FoldersActions } from '@app/base-page/_store/folder';

@Component({
  selector: 'app-create-folder-modal',
  templateUrl: './view.component.html',
  styleUrls: ['./view.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class CreateFolderModalComponent implements OnInit, OnDestroy {
  private unsubscribe$: Subject<void> = new Subject();
  validateForm: FormGroup;
  data: any;

  loading = false;
  isCloseView = false;
  isEdited = false;
  categories = [];
  tags = [];

  inputVisible = false;
  inputValue = '';
  @ViewChild('inputElement', { static: false }) inputElement?: ElementRef;

  constructor(
    private cd: ChangeDetectorRef,
    private store$: Store<fromApp.PageState>,
    private fb: FormBuilder,
    private modal: NzModalRef
  ) {}

  ngOnInit(): void {
    this.setupModel();
    this.setupView();
    this.fetchData();
  }

  setupView() {
    this.store$
      .select(fromApp.getFolderView)
      .pipe(takeUntil(this.unsubscribe$))
      .subscribe((payload) => {
        const { isLoading, type, status, errors } = payload;
        this.loading = isLoading;

        if (errors.length > 0) {
          errors.forEach((e) => {
            const { field, message } = e;
            const control = this.validateForm.get(field);
            if (control) {
              control.setErrors([{ error: true, duplicated: true, message }]);
            }
          });
        }

        if (type === FolderModalType.Create && status === FolderModalStatus.Success) {
          this.validateForm.reset();
        }

        if (this.isCloseView === true && this.loading === false && status === FolderModalStatus.Success) {
          this.modal.close();
        }
        this.cd.detectChanges();
      });
  }

  ngOnDestroy() {
    this.unsubscribe$.next();
    this.unsubscribe$.complete();
  }

  onClickSave(isCloseView): void {
    this.isCloseView = isCloseView;
    const value = {
      ...this.validateForm.value,
    };
    if (this.isEdited) {
      this.fetchUpdate(this.data.id, value);
    } else {
      if (this.data && this.data.folderId) {
        value.parentId = this.data.folderId;
      }
      this.fetchCreate(value);
    }
  }

  onClickClose(): void {
    this.modal.close(null);
  }

  setEdited() {
    this.isEdited = this.data && this.data.id ? true : false;
  }

  setupModel() {
    this.setEdited();
    this.createForm(this.data);
  }

  createForm(model: any) {
    this.validateForm = this.fb.group({
      name: [model?.name || '', [Validators.required, noWhitespaceValidator]],
    });
  }

  fetchData() {
    // this.store$.dispatch(FoldersActions.getCategories({ payload: { page: 1, limit: 100 } }));
  }

  fetchUpdate(templateId, value) {
    // this.store$.dispatch(FoldersActions.updateFolder({ payload: { templateId, value } }));
  }

  fetchCreate(value) {
    this.store$.dispatch(FoldersActions.createFolder({ payload: value }));
  }
}
