import { AppEditorEventService } from "@app/_3D/services/app-editor-event.service";
import { AppEditorService } from "@app/_3D/services/app-editor.service";
import { MeshGeometryService } from "./components/panels/mesh-geometry/mesh-geometry.service";
import { PanelLightService } from "./components/panels/panel-light/panel-light.service";
import { PanelModelObjectService } from "./components/panels/panel-model-object/panel-model-object.service";
import { EditorToolbarService } from "./components/viewport/editor-toolbar/editor-toolbar.service";
import { ObjectToolbarService } from "./components/viewport/object-toolbar/object-toolbar.service";
import { VectorControlsService } from "./components/viewport/vector-controls/vector-controls.service";
import { ViewportService } from "./components/viewport/viewport.service";
import { AppEditorStorageService } from "../_3D/services/app-editor-storage.service";
import { ModalConfirmService } from "./services/modal-confirm.service";
import { SidebarLockService } from "./components/editor/sidebar/sidebar-lock/sidebar-lock.service";
import { ClientViewportService } from "./components/viewport/client-viewport.service";
import { ClientEditToolbarService } from "./components/viewport/client-edit-toolbar/client-edit-toolbar.service";

export const SHARE_SERVICES = [
    ViewportService,
    MeshGeometryService,
    ObjectToolbarService,
    ModalConfirmService,
    PanelModelObjectService,
    PanelLightService,
    EditorToolbarService,
    VectorControlsService,
    SidebarLockService,


    AppEditorService,
    AppEditorEventService,
    AppEditorStorageService,
    ClientViewportService,
    ClientEditToolbarService
]