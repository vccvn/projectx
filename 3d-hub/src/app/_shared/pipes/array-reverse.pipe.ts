import { Pipe, PipeTransform } from '@angular/core';

@Pipe({ name: 'reverse' })
export class ReversePipe implements PipeTransform {
  transform(value) {
    if (!Array.isArray(value)) {
      return [];
    }
    return value.slice().reverse();
  }
}
