import { Component, ChangeDetectionStrategy } from '@angular/core';
import { SettingsService } from '@delon/theme';

@Component({
  // tslint:disable-next-line: component-selector
  selector: 'layout-pro-logo',
  templateUrl: './logo.component.html',
  styleUrls: ['./logo.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LayoutProLogoComponent {
  get name() {
    return this.setting.app.name;
  }
  constructor(private setting: SettingsService) {}
}
