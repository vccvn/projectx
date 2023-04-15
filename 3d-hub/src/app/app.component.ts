import { Component } from '@angular/core';
import { Angulartics2Mixpanel } from 'angulartics2/mixpanel';
import { SettingService } from './_core/services';
import { environment } from '@env/environment';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
})
export class AppComponent {
  title = 'Brandgos - Admin';
  constructor(
    angulartics2Mixpanel: Angulartics2Mixpanel,
    settingService: SettingService
  ) {
    if (environment.production) {
      const { user } = settingService;
      angulartics2Mixpanel.startTracking();
      angulartics2Mixpanel.setUsername(user.username);
    }
  }
}
