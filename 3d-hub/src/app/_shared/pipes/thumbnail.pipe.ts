import { Pipe, PipeTransform } from '@angular/core';

@Pipe({ name: 'thumbnail' })
export class ThumbnailPipe implements PipeTransform {
  transform(value: Array<any>, field: string): number {
    if (!Array.isArray(value)) {
      return null;
    }
    return value.find((v) => v.quanlity === field)?.url;
  }
}
