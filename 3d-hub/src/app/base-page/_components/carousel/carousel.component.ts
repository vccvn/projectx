import { ChangeDetectorRef, Component, Input, Output, OnChanges, EventEmitter } from '@angular/core';
import { DraftTemplateModel } from '@app/base-page/_store/drafttemplate';

@Component({
  selector: 'app-carousel',
  templateUrl: './carousel.component.html',
  styleUrls: ['./carousel.component.scss'],
})
export class CarouselComponent implements OnChanges {
  options = {
    transitionDuration: 0.2,
  };

  layoutOptions = {
    margin: 16,
    column: [3, 5],
    maxSize: 200,
    minSize: 160,
  };

  maxHeight = 202;

  @Input()
  name = '';

  @Input()
  type = '';

  @Input()
  loading: boolean;

  @Input()
  page: number;

  @Input()
  items: Array<{ groupKey: number; key: number; num: number; model: Partial<DraftTemplateModel> }> = [];

  @Output()
  loadMore = new EventEmitter();

  data = [];

  constructor(private readonly cd: ChangeDetectorRef) {}

  ngOnChanges() {
    this.data = this.getItems();
  }

  getItems() {
    return this.items.map((item, index) => {
      const ok = parseInt('' + index / 8, 0) + 1;
      return {
        ...item,
        groupKey: ok,
        key: index + 1,
        num: index + 1,
      };
    });
  }

  groupBy(index, templateGroups) {
    return templateGroups.groupKey;
  }

  trackBy(index, templateGroups) {
    return templateGroups.key;
  }

  onAppend({ currentTarget, startLoading }) {
    (window as any).a = this;

    if (currentTarget.isLoading()) {
      return;
    }

    startLoading();
    this.loadMore.emit();
  }

  onLayoutComplete({ isLayout, endLoading }) {
    if (!isLayout) {
      endLoading();
    }
  }

  trackByFn(index, item) {
    return item.id;
  }
}
