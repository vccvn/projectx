import { ChangeDetectionStrategy, Component, OnInit } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { FolderModel, FoldersActions } from '@app/base-page/_store/folder';
import { ModalHelper } from '@delon/theme';
import { CreateFolderModalComponent } from '../folder/create-folder-modal/view.component';
import { ActivatedRoute } from '@angular/router';
import { takeUntil } from 'rxjs/operators';

@Component({
  selector: 'app-folder-child',
  templateUrl: './folder.component.html',
  styleUrls: ['./folder.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class FolderChildComponent implements OnInit {
  private unsubscribe$: Subject<void> = new Subject();

  folders$: Observable<Array<FolderModel>>;
  currentFolder$: Observable<FolderModel>;
  loading$: Observable<boolean>;
  folderId: string;

  constructor(private store$: Store<fromApp.PageState>, private modalHelper: ModalHelper, private activatedRoute: ActivatedRoute) {}

  ngOnInit(): void {
    this.listenFolders();

    this.activatedRoute.params.pipe(takeUntil(this.unsubscribe$)).subscribe((params) => {
      this.folderId = params.folderId;
      this.fetchData();
    });
  }

  listenFolders() {
    this.loading$ = this.store$.select(fromApp.getFoldersLoading);
    this.folders$ = this.store$.select(fromApp.getFolders);
    this.currentFolder$ = this.store$.select(fromApp.getCurrentFolder);
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
      folderId: string;
    } = {
      page: 0,
      limit: 10,
      folderId: this.folderId,
    };

    this.store$.dispatch(FoldersActions.getFolders({ payload: params }));
  }

  showViewInput(data: any) {
    this.store$.dispatch(FoldersActions.openFolderView());
    this.modalHelper
      .create(
        CreateFolderModalComponent,
        { data: { folderId: this.folderId } },
        {
          size: 640,
        }
      )
      .subscribe((res) => {});
  }

  onClickBtnCreateFolder() {
    this.showViewInput(null);
  }
}
