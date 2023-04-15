import { Component, ChangeDetectionStrategy } from '@angular/core';
import { Router } from '@angular/router';
import { AuthenticationService } from '@app/auth/services';
import { SettingService } from '@app/_core/services';
import { NotificationService } from '@app/base-page/_store/notification';

@Component({
  selector: 'layout-pro-user',
  templateUrl: 'user.component.html',
  styles: [
    `
      .name {
        max-width: 220px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      @media screen and (max-width: 576px) {
        .name {
          max-width: 74px;
        }
      }
    `,
  ],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LayoutProWidgetUserComponent {
  constructor(
    public settings: SettingService,
    private router: Router,
    private authService: AuthenticationService,
    private notificationService: NotificationService
  ) {}

  logout() {
    this.authService.logout();
    this.notificationService.logoutInfo();

    const { urls } = this.settings;
    this.router.navigateByUrl(urls.login);
  }
}
