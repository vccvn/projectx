import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { FolderModel, FoldersActions } from '@app/base-page/_store/folder';
import { ModalHelper } from '@delon/theme';
import { CreateFolderModalComponent } from './create-folder-modal/view.component';

@Component({
  selector: 'app-folder',
  templateUrl: './folder.component.html',
  styleUrls: ['./folder.component.scss'],
})
export class FolderComponent implements OnInit {
  folders$: Observable<Array<FolderModel>>;
  foldersEnd$: Observable<boolean>;
  loading$: Observable<boolean>;

  folders = [
    { name: 'All your design', id: 'designs' },
    { name: 'Uploads', id: 'uploads' },
    { name: 'Favorites', id: 'favorites' },
    { name: 'Purchased', id: 'purchased' },
    { name: 'Trash', id: 'trash' },
  ];

  constructor(private store$: Store<fromApp.PageState>, private cd: ChangeDetectorRef, private modalHelper: ModalHelper) {}

  ngOnInit(): void {
    this.listenFolders();
    this.fetchData();
  }

  listenFolders() {
    this.loading$ = this.store$.select(fromApp.getFoldersLoading);
    this.folders$ = this.store$.select(fromApp.getFolders);
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
      sort?: string;
      q?: string;
    } = {
      page: 0,
      limit: 10,
    };

    this.store$.dispatch(FoldersActions.getFolders({ payload: params }));
  }

  showViewInput(data: any) {
    this.store$.dispatch(FoldersActions.openFolderView());
    this.modalHelper
      .create(
        CreateFolderModalComponent,
        { data },
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
