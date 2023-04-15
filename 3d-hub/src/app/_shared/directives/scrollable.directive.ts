import { Directive, HostListener, EventEmitter, Output, ElementRef } from '@angular/core';

@Directive({
  selector: '[appScrollable]',
})
export class ScrollableDirective {
  @Output() scrollBottom = new EventEmitter();
  @Output() scrollTop = new EventEmitter();
  @Output() scrollDown = new EventEmitter();

  constructor(public el: ElementRef) {}

  @HostListener('scroll', ['$event'])
  onScroll(event) {
    try {
      const top = event.target.scrollTop;
      const height = this.el.nativeElement.scrollHeight;
      const offset = this.el.nativeElement.offsetHeight;
      if (top > 0) {
        this.scrollDown.emit();
      }
      // emit bottom event
      if (top > height - offset - 1) {
        this.scrollBottom.emit();
      }

      // emit top event
      if (top === 0) {
        this.scrollTop.emit();
      }
    } catch (err) {}
  }
}
