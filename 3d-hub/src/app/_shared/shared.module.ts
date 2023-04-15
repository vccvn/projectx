import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { TranslateModule } from '@ngx-translate/core';
import { RouterModule } from '@angular/router';
import { pipes } from './pipes';
import { directives } from './directives';
import { DebounceInputDirective } from './directives/debounce-input.directive';
import { CanAccessDirective } from '@app/_core/directives/can-access.directive';
import { UploadFileComponent } from './components/upload/upload.component';
import { AppUIModule } from '../app-ui.module';
import { Vector3Component } from './components/inputs/vector3/vector3.component';
import { InpSwitchComponent } from './components/inputs/inp-switch/inp-switch.component';
import { InpRotationComponent } from './components/inputs/inp-rotation/inp-rotation.component';
import { InpTextComponent } from './components/inputs/inp-text/inp-text.component';
import { SelectBoxComponent } from './components/inputs/select-box/select-box.component';
import { InpColorComponent } from './components/inputs/inp-color/inp-color.component';
import { TransparentImgComponent } from './components/transparent-img/transparent-img.component';
import { InpTextureComponent } from './components/inputs/inp-texture/inp-texture.component';
import { InpSelectComponent } from './components/inputs/inp-select/inp-select.component';
import { ImageLibraryComponent } from './components/modals/image-library/image-library.component';
import { ImageLibraryItemComponent } from './components/modals/image-library/image-library-item/image-library-item.component';
import { InpRangeComponent } from './components/inputs/inp-range/inp-range.component';
import { InpSwitchGroupComponent } from './components/input-groups/inp-switch-group/inp-switch-group.component';
import { InpColorGroupComponent } from './components/input-groups/inp-color-group/inp-color-group.component';
import { InpRangeGroupComponent } from './components/input-groups/inp-range-group/inp-range-group.component';
import { InpRotationGroupComponent } from './components/input-groups/inp-rotation-group/inp-rotation-group.component';
import { InpVector3GroupComponent } from './components/input-groups/inp-vector3-group/inp-vector3-group.component';
import { InpSelectGroupComponent } from './components/input-groups/inp-select-group/inp-select-group.component';
import { InpTextGroupComponent } from './components/input-groups/inp-text-group/inp-text-group.component';
import { InpNumberComponent } from './components/inputs/inp-number/inp-number.component';
import { InpNumberGroupComponent } from './components/input-groups/inp-number-group/inp-number-group.component';
import { ViewportComponent } from './components/viewport/viewport.component';
import { MaskLayerComponent } from './components/viewport/mask-layer/mask-layer.component';
import { DroppableLayerComponent } from './components/viewport/droppable-layer/droppable-layer.component';
import { ForegroundLayerComponent } from './components/viewport/foreground-layer/foreground-layer.component';
import { CanvasLayerComponent } from './components/viewport/canvas-layer/canvas-layer.component';
import { MeshGeometryComponent } from './components/panels/mesh-geometry/mesh-geometry.component';
import { MaterialInputsComponent } from './components/form-group/material-inputs/material-inputs.component';
import { InpTextureGroupComponent } from './components/input-groups/inp-texture-group/inp-texture-group.component';
import { PropInputsComponent } from './components/form-group/prop-inputs/prop-inputs.component';
import { ObjectToolbarComponent } from './components/viewport/object-toolbar/object-toolbar.component';
import { MeshGeometryTabMaterialComponent } from './components/panels/mesh-geometry/mesh-geometry-tab-material/mesh-geometry-tab-material.component';
import { MeshGeometryTabGeometryComponent } from './components/panels/mesh-geometry/mesh-geometry-tab-geometry/mesh-geometry-tab-geometry.component';
import { MeshGeometryTabPropertiesComponent } from './components/panels/mesh-geometry/mesh-geometry-tab-properties/mesh-geometry-tab-properties.component';
import { PanelModelObjectComponent } from './components/panels/panel-model-object/panel-model-object.component';
import { PanelModelObjectTabMeshesComponent } from './components/panels/panel-model-object/panel-model-object-tab-meshes/panel-model-object-tab-meshes.component';
import { PanelModelObjectTabPropertiesComponent } from './components/panels/panel-model-object/panel-model-object-tab-properties/panel-model-object-tab-properties.component';
import { CollapseMeshMaterialComponent } from './components/collapses/collapse-mesh-material/collapse-mesh-material.component';
import { PanelLightComponent } from './components/panels/panel-light/panel-light.component';
import { PanelLightTabParamsComponent } from './components/panels/panel-light/panel-light-tab-params/panel-light-tab-params.component';
import { PanelLightTabPropertiesComponent } from './components/panels/panel-light/panel-light-tab-properties/panel-light-tab-properties.component';
import { ForegroundLayerItemComponent } from './components/viewport/foreground-layer/foreground-layer-item/foreground-layer-item.component';
import { EditorToolbarComponent } from './components/viewport/editor-toolbar/editor-toolbar.component';
import { InpTextareaComponent } from './components/inputs/inp-textarea/inp-textarea.component';
import { InpTextareaGroupComponent } from './components/input-groups/inp-textarea-group/inp-textarea-group.component';
import { InpRadioComponent } from './components/inputs/inp-radio/inp-radio.component';
import { InpRadioGroupComponent } from './components/input-groups/inp-radio-group/inp-radio-group.component';
import { VectorControlsComponent } from './components/viewport/vector-controls/vector-controls.component';
import { TabEditorInfoComponent } from './components/editor/tabs/tab-setting/tab-info/tab-info.component';
import { TabEditorSettingComponent } from './components/editor/tabs/tab-setting/tab-setting.component';
import { TabObjectComponent } from './components/editor/tabs/tab-object/tab-object.component';
import { TabModelComponent } from './components/editor/tabs/tab-object/tab-model/tab-model.component';
import { ModelListComponent } from './components/editor/tabs/tab-object/tab-model/model-list/model-list.component';
import { DraggingItemComponent } from './components/editor/drag-drop/dragging-item/dragging-item.component';
import { ModelItemComponent } from './components/editor/tabs/tab-object/tab-model/model-item/model-item.component';
import { DroppableAreaComponent } from './components/editor/drag-drop/droppable-area/droppable-area.component';
import { TabGeometryComponent } from './components/editor/tabs/tab-object/tab-geometry/tab-geometry.component';
import { TabLightComponent } from './components/editor/tabs/tab-light/tab-light.component';
import { TabSceneComponent } from './components/editor/tabs/tab-scene/tab-scene.component';
import { TabBackgroundComponent } from './components/editor/tabs/tab-scene/tab-background/tab-background.component';
import { TabForegroundComponent } from './components/editor/tabs/tab-scene/tab-foreground/tab-foreground.component';
import { ForegroundItemComponent } from './components/editor/tabs/tab-scene/tab-foreground/foreground-item/foreground-item.component';
import { TabCameraComponent } from '../_shared/components/editor/tabs/tab-controls/tab-camera/tab-camera.component';
import { ModelSearchComponent } from './components/editor/tabs/tab-object/tab-model/model-search/model-search.component';
import { DraggingGeometryComponent } from '../_shared/components/editor/drag-drop/dragging-geometry/dragging-geometry.component';
import { GeometryItemComponent } from './components/editor/tabs/tab-object/tab-geometry/geometry-item/geometry-item.component';
import { LightItemComponent } from './components/editor/tabs/tab-light/light-item/light-item.component';
import { TabShadowComponent } from './components/editor/tabs/tab-light/tab-shadow/tab-shadow.component';
import { TabLightsComponent } from './components/editor/tabs/tab-light/tab-lights/tab-lights.component';
import { TabControlsComponent } from '../_shared/components/editor/tabs/tab-controls/tab-controls.component';
import { TabControlComponent } from '../_shared/components/editor/tabs/tab-controls/tab-control/tab-control.component';
import { TabSceneSettingsComponent } from './components/editor/tabs/tab-scene/tab-scene-settings/tab-scene-settings.component';
import { TemplateSidebarComponent } from './components/editor/sidebar/template-sidebar/sidebar.component';
import { ProjectSidebarComponent } from './components/editor/sidebar/project-sidebar/project-sidebar.component';
import { TabTemplateComponent } from './components/editor/tabs/tab-template/tab-template.component';
import { TemplateListComponent } from './components/editor/tabs/tab-template/template-list/template-list.component';
import { TemplateItemComponent } from './components/editor/tabs/tab-template/template-item/template-item.component';
import { LoadingLayerComponent } from './components/viewport/loading-layer/loading-layer.component';
import { SidebarLockComponent } from './components/editor/sidebar/sidebar-lock/sidebar-lock.component';
import { TabTemplateCreateFormComponent } from './components/editor/tabs/tab-template-create-form/tab-template-create-form.component';
import { TabProjectInfoComponent } from './components/editor/tabs/tab-project-info/tab-project-info.component';
import { TabProjectSettingComponent } from './components/editor/tabs/tab-project-setting/tab-project-setting.component';
import { ViewerSidebarComponent } from './components/editor/sidebar/viewer-sidebar/viewer-sidebar.component';
import { ClientEditToolbarComponent } from './components/viewport/client-edit-toolbar/client-edit-toolbar.component';
import { ClientViewportComponent } from './components/viewport/client-viewport.component';
import { TabViewerSceneComponent } from './components/editor/tabs/tab-viewer-scene/tab-viewer-scene.component';
import { PanelMeshCustomizeComponent } from './components/panels/panel-mesh-customize/panel-mesh-customize.component';
import { ModalExportImageComponent } from './components/modals/modal-export-image/modal-export-image.component';
import { ItemViewportComponent } from './components/viewport/item-viewport.component';


// Shared

@NgModule({
    declarations: [
        ...pipes,
        ...directives,
        DebounceInputDirective,
        CanAccessDirective,
        UploadFileComponent,
        Vector3Component,
        InpSwitchComponent,
        InpRotationComponent,
        InpTextComponent,
        SelectBoxComponent,
        InpColorComponent,
        TransparentImgComponent,
        InpTextureComponent,
        InpSelectComponent,
        ImageLibraryComponent,
        ImageLibraryItemComponent,
        InpRangeComponent,
        InpSwitchGroupComponent,
        InpColorGroupComponent,
        InpRangeGroupComponent,
        InpRotationGroupComponent,
        InpVector3GroupComponent,
        InpSelectGroupComponent,
        InpTextGroupComponent,
        InpNumberComponent,
        InpNumberGroupComponent,
        ViewportComponent,
        MaskLayerComponent,
        DroppableLayerComponent,
        ForegroundLayerComponent,
        CanvasLayerComponent,
        MeshGeometryComponent,
        MaterialInputsComponent,
        InpTextureGroupComponent,
        PropInputsComponent,
        ObjectToolbarComponent,
        MeshGeometryTabMaterialComponent,
        MeshGeometryTabPropertiesComponent,
        MeshGeometryTabGeometryComponent, 
        PanelModelObjectComponent, 
        PanelModelObjectTabMeshesComponent, 
        PanelModelObjectTabPropertiesComponent,
        CollapseMeshMaterialComponent,
        PanelLightComponent, 
        PanelLightTabParamsComponent, 
        PanelLightTabPropertiesComponent,
        ForegroundLayerItemComponent, 
        EditorToolbarComponent,
        InpTextareaComponent, 
        InpTextareaGroupComponent,
        InpRadioComponent, 
        InpRadioGroupComponent, 
        VectorControlsComponent,
        TabEditorInfoComponent,
        TabEditorSettingComponent,
        TabGeometryComponent,
        TabModelComponent,
        TabObjectComponent,
        ModelListComponent,
        ModelItemComponent,
        DraggingItemComponent,
        DroppableAreaComponent,
        TabLightComponent,
        TabSceneComponent,
        TabBackgroundComponent,
        TabForegroundComponent,
        ForegroundItemComponent,
        TabCameraComponent,
        ModelSearchComponent,
        DraggingGeometryComponent,
        GeometryItemComponent,
        LightItemComponent,
        TabShadowComponent,
        TabLightsComponent,
        TabControlsComponent,
        TabControlComponent,
        TabSceneSettingsComponent,
        TemplateSidebarComponent,
        ProjectSidebarComponent,
        TabTemplateComponent,
        TemplateListComponent,
        TemplateItemComponent,
        LoadingLayerComponent,
        SidebarLockComponent,
        TabTemplateCreateFormComponent,
        TabProjectInfoComponent,
        TabProjectSettingComponent,
        ViewerSidebarComponent,
        ClientEditToolbarComponent,
        ClientViewportComponent,
        TabViewerSceneComponent,
        PanelMeshCustomizeComponent,
        ModalExportImageComponent,
        ItemViewportComponent

    ],
    imports: [CommonModule, FormsModule, RouterModule, HttpClientModule, ReactiveFormsModule, TranslateModule, AppUIModule],
    exports: [
        ...pipes,
        ...directives,
        FormsModule,
        RouterModule,
        HttpClientModule,
        ReactiveFormsModule,
        CanAccessDirective,
        TranslateModule,
        ImageLibraryComponent,
        UploadFileComponent,
        InpSwitchComponent,
        Vector3Component,
        InpRotationComponent,
        InpTextComponent,
        SelectBoxComponent,
        InpColorComponent,
        InpTextureComponent,
        InpSelectComponent,
        InpRangeComponent,
        InpNumberComponent,
        InpSwitchGroupComponent,
        InpVector3GroupComponent,
        InpRotationGroupComponent,
        InpTextGroupComponent,
        InpColorGroupComponent,
        InpSelectGroupComponent,
        InpRangeGroupComponent,
        InpNumberGroupComponent,
        InpTextureGroupComponent,
        PropInputsComponent,
        ViewportComponent,
        ForegroundLayerComponent,
        MaskLayerComponent,
        DroppableLayerComponent,
        CanvasLayerComponent,
        MeshGeometryComponent,
        MaterialInputsComponent,
        CollapseMeshMaterialComponent,
        ObjectToolbarComponent,
        MeshGeometryTabGeometryComponent,
        MeshGeometryTabMaterialComponent,
        MeshGeometryTabPropertiesComponent,
        PanelModelObjectComponent,
        PanelModelObjectTabMeshesComponent,
        PanelModelObjectTabPropertiesComponent,
        PanelLightComponent,
        PanelLightTabParamsComponent,
        PanelLightTabPropertiesComponent,
        ForegroundLayerItemComponent,
        EditorToolbarComponent,
        InpTextareaComponent,
        InpTextareaGroupComponent,
        InpRadioComponent,
        InpRadioGroupComponent,
        VectorControlsComponent,
        TabEditorInfoComponent,
        TabEditorSettingComponent,
        TabGeometryComponent,
        TabModelComponent,
        TabObjectComponent,
        ModelListComponent,
        ModelItemComponent,
        DraggingItemComponent,
        DroppableAreaComponent,
        TabLightComponent,
        TabSceneComponent,
        TabBackgroundComponent,
        TabForegroundComponent,
        ForegroundItemComponent,
        TabCameraComponent,
        ModelSearchComponent,
        DraggingGeometryComponent,
        GeometryItemComponent,
        LightItemComponent,
        TabShadowComponent,
        TabLightsComponent,
        TabControlsComponent,
        TabControlComponent,
        TabSceneSettingsComponent,
        TemplateSidebarComponent,
        ProjectSidebarComponent,
        TabTemplateComponent,
        TemplateListComponent,
        TemplateItemComponent,
        SidebarLockComponent,
        LoadingLayerComponent,
        TabTemplateCreateFormComponent,
        TabProjectInfoComponent,
        TabProjectSettingComponent,
        ViewerSidebarComponent,
        ClientEditToolbarComponent,
        ClientViewportComponent,
        TabViewerSceneComponent,
        PanelMeshCustomizeComponent,
        ItemViewportComponent

    ]
})
export class SharedModule { }