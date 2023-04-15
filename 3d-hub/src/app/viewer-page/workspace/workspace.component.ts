import { Component, OnInit, ChangeDetectorRef, ViewEncapsulation, ElementRef, AfterViewInit, OnDestroy } from '@angular/core';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { assignValue, assignWithout, copyByList, getTimeStamp, inArray, isBoolean, isEmpty, Str } from '@app/_core/helpers/utils';
import { MeshGeometryService } from '@app/_shared/components/panels/mesh-geometry/mesh-geometry.service';
import { PanelLightService } from '@app/_shared/components/panels/panel-light/panel-light.service';
import { PanelModelObjectService } from '@app/_shared/components/panels/panel-model-object/panel-model-object.service';
import { EditorToolbarService } from '@app/_shared/components/viewport/editor-toolbar/editor-toolbar.service';
import { VectorControlsService } from '@app/_shared/components/viewport/vector-controls/vector-controls.service';
import { ViewportService } from '@app/_shared/components/viewport/viewport.service';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';
import { ModalConfirmService } from '@app/_shared/services/modal-confirm.service';
import { CategoryService } from '@app/_store/category';
import { ItemService, ItemTableService } from '@app/_store/item';
import { ProjectModel, ProjectService } from '@app/_store/project';
import { ProjectTableService } from '@app/_store/project/table';
import { TemplateModel, TemplateService } from '@app/_store/template';
import { TemplateTableService } from '@app/_store/template/table';
import ViewerEditor from '@app/_3D/libs/viewer-editor';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import ClientEditorEngine from '@app/_3D/engines/client-editor.engine';
import { ClientEditToolbarService } from '@app/_shared/components/viewport/client-edit-toolbar/client-edit-toolbar.service';
import { ViewerEditorService } from '@app/_3D/services/viewer-editor.service';
import { BlankData, getBlankAppData } from '@app/_3D/store/data.type';
import { A } from '@app/_core/helpers/html-elements';



@Component({
    selector: 'app-workspace',
    templateUrl: './workspace.component.html',
    styleUrls: ['../../../styles/design/_index.scss', './workspace.component.scss'],
    encapsulation: ViewEncapsulation.None,
})
export class WorkspaceComponent extends BaseComponent implements OnInit, AfterViewInit, OnDestroy {
    isInited: boolean = false;
    id: number = 0;
    mode: string = 'create';
    isLoading: boolean = true;
    app: ViewerEditorService = null;
    urlPath: string = null;
    projects: ProjectModel[] = [];
    templates: TemplateModel[] = [];
    defaultThumbnail: string = TransparentBase64Image;
    lockSidebar: boolean = false;
    allow_custom: boolean = false;
    subEventService: AppEditorEventService = null;
    workspaceKey: string = "viewer-page";

    
    downloadBtn = A(".download", {target: "_blank", href: "", download: "screenshot.png"});

    engineEvent: any = {
        "load.success": e => e.tasks == 0 && this.hideLoading(),
        "load.fail": e => e.tasks == 0 && this.hideLoading(),
        "object.load.starting": () => this.showLoading(),
        "object.load.completed": () => {
            if (!this.isFocus) return;
            this.app.editor.allowCustom = isBoolean(this.app.data.allow_custom) ? this.app.data.allow_custom : false;
            this.hideLoading();
            this.app.editor.hideLightHelpers();
        }
    };
    appinit: (e) => any = e => {
        this.app.engine.setControlEngine(this.vectorControls.engine);
        this.app.editor.hideLightHelpers();
        this.app.editor.detachLight();
    };

    appBeforeInit: (e) => any = e => {
        this.app.engine.on(this.engineEvent);
    }

    constructor(
        public cd: ChangeDetectorRef,
        private elemRef: ElementRef,
        public activatedRoute: ActivatedRoute,
        public router: Router,
        // app tong quan
        public editor: ViewerEditorService,
        public events: AppEditorEventService,
        public storage: AppEditorStorageService,


        // cac dich vu hien thi
        public geoService: MeshGeometryService,
        public toolbar: ClientEditToolbarService,
        public confirmService: ModalConfirmService,
        public panelModelService: PanelModelObjectService,
        public panelLightService: PanelLightService,
        public editorToolbar: EditorToolbarService,
        public viewportService: ViewportService,
        public vectorControls: VectorControlsService,

        // truy xuất dữ liệu
        public categoryService: CategoryService,
        public itemService: ItemService,
        // public itemTable: ItemTableService,


        public projectService: ProjectService,
        // public projectTable: ProjectTableService,
        public templateService: TemplateService,
        // public templateTable: TemplateTableService

    ) {
        super();

        // this.events = this.events.sub(this.workspaceKey);
        this.editor.events = this.events;
        this.app = this.editor;
        // editor.events = this.events;
        // this.app = editor;
        this.registerEventService(this.app, {
            "editor.update.mesh.props": e => this.geoService.updateProps(e.data),
            "editor.update.model.props": e => this.panelModelService.updateProps(e.data),
            "editor.update.light.props": e => this.panelLightService.updateProps(e.data),
            "editor.update.light.props.target": e => this.panelLightService.updateTargetProps(e.data),
            "editor.attach:object": e => this.toolbar.show("object", e.secret_key),
            "editor.attach:mesh": e => this.toolbar.show("mesh", e.secret_key),
            "editor.attach:light": e => this.toolbar.show("light", e.secret_key),
            "editor.delete:light": e => this.doAction({ action: "delete", type: "light", secret_key: e.secret_key }),
            "editor.delete:object": e => this.doAction({ action: "delete", type: "object", secret_key: e.secret_key }),
            "editor.detach": e => this.onDetach(),
            "light.showform": e => this.showLight(e.data),
            init: this.appinit,
            beforeinit: this.appBeforeInit
        });

        this.registerEventService(this.events, {
            // "modelitem.drop.confirm": e => this.dropModelItem(e.data),
            // "template.import": e => this.importTemplate(e.template),
            "app.loading.show": e => this.showLoading(),
            "app.loading.hide": e => this.hideLoading()
        })

        this.registerEventService(this.toolbar, {
            "mode.select": e => this.app.emit({ type: "toolbar.change:mode", mode: e.mode }),
            "action": e => this.doAction(e.data)
        });


        this.registerEventService(document, {
            'pointerup': e => this.events.emit(e),
            'pointermove': e => this.events.emit(e)
        });

        // window['viewerWorkspace'] = this;

    }

    initOnce() {

        this.moduleKey = this.workspaceKey;

        // khai báo các biến có thể dùng chung ở nhiều nơi
        this.storage.assign({
            project: {},
            info: {}
        })
        this.categoryService.getAll({ s: "" }).subscribe(data => {
            this.storage.setState("categories", data.data);
        });



        this.viewportService.emit({
            type: 'app.set',
            app: this.app
        }, true)
        // quan ly khac


    }
    onInit() {
        this.activeEventServiceRegistered(this.app);
        this.activeEventServiceRegistered(this.events);
        this.activeEventServiceRegistered(this.toolbar);
        this.activeEventServiceRegistered(document);

        if (this.app.engine) {
            this.app.engine.on(this.engineEvent);
        }

        this.id = +this.activatedRoute.snapshot.paramMap.get("id");
        if (this.id > 0) {
            this.app.setProject(assignValue({}, BlankData));
            this.loadProject(this.id);

        } else {
            this.mode = 'notfound';
            this.isLoading = false;
        }

        this.editorToolbar.hide();
        this.editorToolbar.show({
            exportImage: e => this.exportImage()
        })
        this.cd.detectChanges();

    }


    onDestroy() {
        this.deactiveEventServiceRegistered(this.app);
        this.deactiveEventServiceRegistered(this.events);
        this.deactiveEventServiceRegistered(this.toolbar);
        this.deactiveEventServiceRegistered(document);

        this.editorToolbar.hide();
        if (this.app.engine) {
            this.app.engine.off(this.engineEvent);
        }
    }

    exportImage() {
        if (!this.isFocus) return false;
        this.app.editor.unselect();
        this.showLoading();
        setTimeout(() => {
            this.app.capture(image => {
                this.downloadBtn.attr("href", image); 
                this.downloadBtn.el.click();
                this.hideLoading();
            });
            
        }, 2000);
        
    }


    

    showLoading() {
        if (!this.isFocus) return;
        this.viewportService.emit("show:loading", null, true);
        this.events.emit("show:sidebar-lock");
    }
    hideLoading() {
        if (!this.isFocus) return;
        this.viewportService.emit("hide:loading", true, true);
        this.events.emit("hide:sidebar-lock");
    }





    loadProject(id: number) {
        if (!this.isFocus) return;
        // var project = this.projectTable.find(id);
        // if (project && !isEmpty(project)) {
        //     this.allow_custom = project.allow_custom;
        //     this.hideLoading();
        //     if (this.allow_custom) {
        //         this.vectorControls.emit({
        //             type: "show",
        //             value: true
        //         }, null, true);
        //     } else {
        //         this.vectorControls.emit({
        //             type: "show",
        //             value: false
        //         }, null, true);;
        //     }
        //     this.storage.project = project;
        //     this.lazyLoadProject(project as ProjectModel);
        //     this.cd.detectChanges();
        // } else {
            this.projectService.get(this.id).subscribe(data => {
                this.allow_custom = data.allow_custom;
                this.isLoading = false;
                if (this.allow_custom) {
                    this.vectorControls.emit({
                        type: "show",
                        value: true
                    }, null, true);
                } else {
                    this.vectorControls.emit({
                        type: "show",
                        value: false
                    }, null, true);
                }
                this.hideLoading();
                this.storage.project = data;
                this.lazyLoadProject(data);
                this.cd.detectChanges();
            }, error => {
                this.vectorControls.emit("hide", null, true);
                this.hideLoading();
                this.cd.detectChanges();
            });
        // }


    }


    lazyLoadProject(project) {
        let preData = assignWithout({}, project, ['objects', 'meshes', 'models', 'scene']);
        preData.scene = assignWithout({}, project.scene, ['foregrounds', 'background']);
        
        this.setProjectData(preData);
        setTimeout(() => {
            this.showLoading();
        }, 11);
        setTimeout(() => {
            this.setProjectData(project)
        }, 25);
    }


    setProjectData(data: ProjectModel) {
        if (!this.isFocus) return;

        this.storage.info = copyByList(data, ['name', 'category_id', 'description', 'status', 'allow_custom']);
        setTimeout(() => {
            this.isLoading = false;
            this.app.setProject(data);
        }, 10);
    }



    onMeshAttach(data) {
        if (!this.isFocus) return;
        this.geoService.open(data, e => {
            let d: any = {};
            if (inArray(['props', 'geometry', 'material'], e.key)) {
                d[e.key] = e.data[e.key];
                switch (e.key) {
                    case "props":

                        break;
                    case "geometry":

                        break;

                    case "material":

                        break;


                    default:
                        break;
                }
                this.events.emit({
                    type: "mesh.setting.update",
                    secret_key: data.secret_key,
                    data: d
                });
            }

        });
    }

    closeAllPanel() {
        if (!this.isFocus) return;
        // this.toolbar.hide();
        this.geoService.close();
        this.panelModelService.close();
        this.panelLightService.close();
    }

    onDetach() {
        if (!this.isFocus) return;
        this.toolbar.hide();
        this.closeAllPanel();

    }

    showLight(data) {
        if (!this.isFocus) return;
        this.panelLightService.open(data, e => {
            let update: any = {};
            // if(e.type=="params"){
            update[e.type] = {};
            update[e.type][e.name] = e.value;

            // }
            this.app.updateLightDataAndScene(e.secret_key, update);
        })
    }

    doAction(data) {
        if (!this.isFocus) return;
        if (data.action == "delete") {
            var title = inArray(['object', 'mesh'], data.type) ? "Are you sure delete this object?" : "Are you sure delete this light?";
            this.confirmService.showDeleteConfirm(title, () => {
                if (inArray(['object', 'mesh'], data.type)) {
                    this.app.emit({
                        type: "toolbar.delete:object",
                        secret_key: data.secret_key,
                        success: () => this.onDetach()
                    })
                }
                else if (data.type == "light") {
                    this.app.deleteLight(data.secret_key, () => this.onDetach());
                }
            })
        }
        else if (data.action == "edit") {
            let ed = this.app.getEditObjectData(data.secret_key);
            if (ed != null) {
                if (ed.type == "mesh") {
                    this.closeAllPanel();
                    this.geoService.open(ed, e => {
                        let d: any = {};
                        if (inArray(['props', 'geometry', 'material'], e.key)) {
                            d[e.key] = e.data[e.key];
                            switch (e.key) {
                                case "props":

                                    break;
                                case "geometry":

                                    break;

                                case "material":

                                    break;


                                default:
                                    break;
                            }
                            this.events.emit({
                                type: "mesh.setting.update",
                                secret_key: data.secret_key,
                                data: d
                            });
                        }

                    });
                } else if (ed.type == "model") {
                    this.closeAllPanel();
                    let obj = this.app.engine.getObject(data.secret_key).object;
                    ed.object = obj;

                    this.panelModelService.open(ed, e => {
                        if (e.type == "material") {
                            this.app.updateModelMeshMaterial(e.secret_key, e.name, e.data);
                        }
                        else if (e.type == "props") {
                            let props: any = {};
                            props[e.key] = e.data[e.key];
                            this.app.updateObjectSettingDataAndScene(e.secret_key, { props: props }, { props: true })
                        }

                    });
                }
                else if (ed.type == "light") {
                    this.showLight(ed.data);
                }
            }
        }
        else if (data.action == 'download') {
            let model = this.app.getObject(data.secret_key);
        }

    }

    dropModelItem(data) {
        if (!this.isFocus) return;
        this.confirmService.showConfirm({
            title: "Drop Item confirm",
            content: "Item's size is bigger than size of Scene. Do you want to continue?"
        }, d => {
            this.showLoading();
            this.events.emit({
                type: 'item.dropped',
                item: data.item,
                success: (dat) => {
                    this.hideLoading();
                    var size = data.item.size;
                    if (this.app.data.scene.floor.above) {
                        data.position.y = this.app.data.scene.floor.props.position.y + size.y / 2;
                    } else {
                        data.position.y = size.y / 2;
                    }
                    this.app.updateObjectSettingDataAndScene(dat.secret_key, {
                        props: {
                            position: data.position
                        }
                    }, { props: true })

                }
            })
        }, () => {
            this.events.emit('viewport.droppable.hide');
        });
    }

    nzCollapsedChange(event) {
        if (!this.isFocus) return;
        this.app.updateCanvasSize();
    }


    ngAfterViewInit(): void {
        if (!this.isFocus) return;
        this.app.updateCanvasSize();

    }

}
