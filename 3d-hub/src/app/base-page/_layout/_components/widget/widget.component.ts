import { Component, ChangeDetectionStrategy } from '@angular/core';

@Component({
  // tslint:disable-next-line: component-selector
  selector: '[layout-pro-header-widget]',
  templateUrl: './widget.component.html',
  // tslint:disable-next-line: no-host-metadata-property
  host: {
    '[class.alain-pro__header-right]': 'true'
  },
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class LayoutProHeaderWidgetComponent {}
