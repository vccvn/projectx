import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { NzCollapseModule } from 'ng-zorro-antd/collapse';

import { WorkspaceComponent } from './workspace/workspace.component';

import { HeaderComponent } from './workspace/header/header.component';
import { SidebarComponent } from './workspace/sidebar/sidebar.component';

import { TabInfoComponent } from './workspace/sidebar/tab-info/tab-info.component';
import { ObjectPropComponent } from '@app/_shared/components/form-group/object-prop/object-prop.component';
import { ActiveSwitchComponent } from './workspace/sidebar/tab-meshes/activate-inputs/active-switch/active-switch.component';
import { ActivateCheckboxComponent } from './workspace/sidebar/tab-meshes/activate-inputs/input-group/activate-checkbox/activate-checkbox.component';
import { MeshActivateInputsComponent } from './workspace/sidebar/tab-meshes/activate-inputs/mesh-activate-inputs/mesh-activate-inputs.component';
import { MaterialActivateInputsComponent } from './workspace/sidebar/tab-meshes/activate-inputs/material-activate-inputs/material-activate-inputs.component';
import { ActivateTextComponent } from './workspace/sidebar/tab-meshes/activate-inputs/input-group/activate-text/activate-text.component';
import { ActivateRangeComponent } from './workspace/sidebar/tab-meshes/activate-inputs/input-group/activate-range/activate-range.component';
import { ActivateColorComponent } from './workspace/sidebar/tab-meshes/activate-inputs/input-group/activate-color/activate-color.component';
import { ActivateSelectComponent } from './workspace/sidebar/tab-meshes/activate-inputs/input-group/activate-select/activate-select.component';
import { ActivateNumberComponent } from './workspace/sidebar/tab-meshes/activate-inputs/input-group/activate-number/activate-number.component';
import { ActivateTextureComponent } from './workspace/sidebar/tab-meshes/activate-inputs/input-group/activate-texture/activate-texture.component';
import { TabMeshesComponent } from './workspace/sidebar/tab-meshes/tab-meshes.component';
import { TabPropertiesComponent } from './workspace/sidebar/tab-properties/tab-properties.component';
import { PanelMeshSettingsComponent } from './workspace/sidebar/panel-mesh-settings/panel-mesh-settings.component';
// import { InpSwitchComponent } from '@app/_shared/components/inputs/inp-switch/inp-switch.component';
export const ENTRIES_COMPONENTS = [];


export const COMPONENTS = [
  WorkspaceComponent,
  HeaderComponent,
  SidebarComponent,
  TabInfoComponent,
  ObjectPropComponent,
  ActiveSwitchComponent,
  ActivateCheckboxComponent,
  MeshActivateInputsComponent,
  MaterialActivateInputsComponent,
  ActivateTextComponent,
  ActivateRangeComponent,
  ActivateColorComponent,
  ActivateTextureComponent,
  ActivateSelectComponent,
  ActivateNumberComponent,
  TabMeshesComponent,
  TabPropertiesComponent,
  PanelMeshSettingsComponent
];

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: ':secret_id/edit',
        component: WorkspaceComponent,
      },
      // {
      //   path: ':id/use',
      //   component: WorkspaceComponent,
      // },
      // {
      //   path: 'create',
      //   component: WorkspaceComponent,
      // },
      // {
      //   path: '**',
      //   redirectTo: 'create',
      // },
    ],
  },
];

@NgModule({
  imports: [
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule],
})
export class ItemRoutingModule { }
