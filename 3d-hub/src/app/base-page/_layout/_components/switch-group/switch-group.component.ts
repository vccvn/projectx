import { Component, ChangeDetectionStrategy } from '@angular/core';
import { Router } from '@angular/router';
import { SettingService } from '@app/_core/services';

@Component({
  // tslint:disable-next-line: component-selector
  selector: 'layout-pro-switch-group',
  templateUrl: 'switch-group.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LayoutProWidgetSwitchGroupComponent {
  groups = [];
  constructor(public settings: SettingService, private router: Router) {}

  change(item) {}
}
