import { ChangeDetectionStrategy, ChangeDetectorRef, Component, ContentChild, Input, TemplateRef, ViewChild } from '@angular/core';
import { NgxFlickingComponent } from '@egjs/ngx-flicking';

@Component({
  selector: 'app-slider',
  templateUrl: './slider.component.html',
  styleUrls: ['./slider.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class SliderComponent {
  @ViewChild('flicking', { read: NgxFlickingComponent }) flicking;

  @Input()
  name: string = '';
  @Input()
  link: string = '';

  @Input()
  cardTemplate: TemplateRef<any>;

  @Input()
  type = '';

  @Input()
  items: Array<{ TemplateModel }> = [];

  options = { bound: true, gap: 24, hanger: 0, anchor: 0, autoResize: true, threshold: 50 };
  isShowNext = true;
  isShowPrev = false;

  plugins = [];
  visiblePanels = [];
  maxHeight = 222;

  constructor(private readonly cd: ChangeDetectorRef) {}

  onHoldStart(e) {
    e.stop();
  }

  onMoveEnd(e) {
    const size = this.flicking.getPanelCount();
    const currentIndex = this.flicking.getIndex();
    const sizePanelShow = this.flicking.getVisiblePanels().length;

    if (currentIndex <= 0 && this.isShowPrev) {
      this.isShowPrev = false;
    } else {
      this.isShowPrev = true;
    }

    if (size <= currentIndex + sizePanelShow && this.isShowNext) {
      this.isShowNext = false;
    } else {
      this.isShowNext = true;
    }

    this.cd.detectChanges();
  }

  onClickNext() {
    const size = this.flicking.getPanelCount();
    const currentIndex = this.flicking.getIndex();
    const sizePanelShow = this.flicking.getVisiblePanels().length;
    const next = currentIndex + sizePanelShow >= size ? size : currentIndex + sizePanelShow;

    this.flicking.moveTo(next);
    this.cd.detectChanges();
  }

  onClickPrev() {
    const currentIndex = this.flicking.getIndex();
    const sizePanelShow = this.flicking.getVisiblePanels().length;
    const next = currentIndex - sizePanelShow >= 0 ? currentIndex - sizePanelShow : 0;

    this.flicking.moveTo(next);
    this.cd.detectChanges();
  }

  trackByFn(index, item) {
    return item.id;
  }
}
