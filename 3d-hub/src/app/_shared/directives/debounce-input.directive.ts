import { Directive, Input, HostListener, Output, EventEmitter } from '@angular/core';
import { debounce } from 'lodash-es';

@Directive({
  selector: '[appDebounceInput]',
})
export class DebounceInputDirective {
  private defaultDebounceTime = 1000;
  @Input() time: number;

  private debounceEmit = debounce(this.updateChange, this.defaultDebounceTime);

  @Output() changeInput = new EventEmitter<string>();
  @HostListener('keyup', ['$event']) onkeyup(e) {
    const value = e.target.value;
    this.debounceEmit(value);
  }

  updateChange(value) {
    this.changeInput.emit(value);
  }
  constructor() {}
}
