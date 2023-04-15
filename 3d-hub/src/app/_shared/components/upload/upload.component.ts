import { Component, Input, Output, EventEmitter, ChangeDetectionStrategy } from '@angular/core';
import { NzUploadXHRArgs, NzUploadFile } from 'ng-zorro-antd/upload';
import { RestService } from '@app/_core/services/rest.service';
import { Observer, Observable } from 'rxjs';

@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class UploadFileComponent {
  @Input()
  fileList: Array<any>;
  @Output()
  fileListChange = new EventEmitter<Array<any>>();
  @Input()
  size: { width: number; height: number };
  @Input()
  quantity = 1;
  @Input()
  fileTypes = ['image/png', 'image/jpeg'];

  @Input()
  sizeFile = 10;

  @Input()
  path: string;

  error: string;

  previewImage: string;
  previewVisible = false;

  showUploadList = {
    showPreviewIcon: true,
    showRemoveIcon: true,
    hidePreviewIconInNonImage: true,
  };

  constructor(private restService: RestService) {}

  handlePreview = (file: NzUploadFile) => {
    this.previewImage = file.url || file.thumbUrl;
    this.previewVisible = true;
    // tslint:disable-next-line: semicolon
  };

  customReq = (item: NzUploadXHRArgs) => {
    const formData = new FormData();
    formData.append('image', item.file as any);
    return this.restService.upload(this.path, formData).subscribe(
      (res) => {
        item.onSuccess(res, item.file, null);
        this.emitFileListValue();
      },
      (err) => {
        item.onError(err, item.file);
        this.showError(err.message);
      }
    );
    // tslint:disable-next-line: semicolon
  };

  showError(messsage) {
    this.error = messsage;

    setTimeout(() => {
      this.error = '';
    }, 5000);
  }

  beforeUpload = (file: File) => {
    return new Observable((observer: Observer<boolean>) => {
      const typeOk = this.fileTypes.includes(file.type);

      if (!typeOk) {
        this.showError(`File tải lên phải thuộc các dạng file sau ${this.fileTypes.join(', ').replace(/image\//gi, '')}`);
        observer.complete();
        return;
      }
      const fileSize = file.size / 1024 / 1024 < this.sizeFile;

      if (!fileSize) {
        this.showError(`File tải lên phải nhỏ hơn ${this.sizeFile}Mb`);
        observer.complete();
        return;
      }
      observer.next(true);
      observer.complete();
    });
    // tslint:disable-next-line: semicolon
  };

  emitFileListValue() {
    this.fileListChange.emit(this.fileList);
  }

  handleRemove = (item) => {
    this.fileList = this.fileList.filter((f) => {
      return f.status !== 'removed';
    });
    this.emitFileListValue();
    // tslint:disable-next-line: semicolon
  };
}
