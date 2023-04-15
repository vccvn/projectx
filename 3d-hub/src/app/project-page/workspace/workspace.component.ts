import { Component, NgZone, OnInit, ChangeDetectorRef, ViewEncapsulation, ElementRef, AfterViewInit, OnDestroy } from '@angular/core';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { assignValue, assignWithout, copyByList, degreeToRadians, inArray, isBoolean, isEmpty, Str } from '@app/_core/helpers/utils';
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
import { getBlankAppData } from '@app/_3D/store/data.type';
import { TemplateModel, TemplateService } from '@app/_store/template';
import { ClientEditToolbarService } from '@app/_shared/components/viewport/client-edit-toolbar/client-edit-toolbar.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ProjectEditorService } from '@app/_3D/services/project-editor.service';
import { A } from '@app/_core/helpers/html-elements';
import { runTask } from '@app/_core/tasks';
import { getConfig } from '@app/_core/config';

let _id = 0;

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
    editMode : string = 'update';
    isLoading: boolean = true;
    app: ProjectEditorService = null;
    urlPath: string = null;
    projects: ProjectModel[] = [];
    templates: TemplateModel[] = [];
    project: ProjectModel = null;
    template: TemplateModel = null;
    defaultThumbnail: string = TransparentBase64Image;
    lockSidebar: boolean = false;
    isLockEventListenner: boolean = true;
    workspaceKey: string = "projectWorkspace";
    subEventService: AppEditorEventService;
    downloadBtn = A(".download", {target: "_blank", href: "", download: "screenshot.png"});

    engineEvent: any = {
        "load.success": e => e.tasks == 0 && this.hideLoading(),
        "load.fail": e => e.tasks == 0 && this.hideLoading(),
        "object.load.starting": () => this.showLoading(),
        "object.load.completed": () => {
            this.hideLoading()
            runTask('loading.complete');
        },
        "loadmore.progress": e => runTask("loading.progress", [e.percent])
    };
    appinit: (e) => any = e => {
        this.app.engine.setControlEngine(this.vectorControls.engine);
        this.app.editor.detachLight();
    };

    appBeforeInit: (e) => any = e => {
        this.app.engine.on(this.engineEvent);
    }

    constructor(
        public cd: ChangeDetectorRef, 
        public elemRef: ElementRef, 
        public activatedRoute: ActivatedRoute, 
        public router: Router, 
        public editor: ProjectEditorService, 
        public events: AppEditorEventService, 
        public storage: AppEditorStorageService, 
        public geoService: MeshGeometryService, 
        public toolbar: ClientEditToolbarService, 
        public confirmService: ModalConfirmService, 
        public panelModelService: PanelModelObjectService, 
        public panelLightService: PanelLightService, 
        public editorToolbar: EditorToolbarService, 
        public viewportService: ViewportService, 
        public vectorControls: VectorControlsService, 
        public categoryService: CategoryService, 
        public itemService: ItemService, 
        public projectService: ProjectService, 
        public templateService: TemplateService
        
    ) {
        super();
        this.subEventService = this.events.sub(this.workspaceKey);
        this.editor.events = this.subEventService;
        this.app = this.editor;
        this.toolbar = toolbar.sub(this.workspaceKey);
        this.viewportService = viewportService.sub(this.workspaceKey);
        this.vectorControls = vectorControls.sub(this.workspaceKey);
        this.editorToolbar = editorToolbar.sub(this.workspaceKey)


        
        
        // window['projectWorkspace'] = this;
    }

    initOnce() {
        // this.events = this.events.sub(this.workspaceKey);
        this.moduleKey = this.workspaceKey;
        this.storage.assign('project', this.project, project => this.project = project);
        this.storage.assign('mode', this.mode, mode => this.mode = mode);
        this.storage.assign('editMode', this.editMode, mode => this.editMode = mode);
        // window['wpStorage'] = this.storage;


        this.viewportService.emit({
            type: 'app.set',
            app: this.app
        }, true)
        // quan ly khac

        this.router.events.subscribe((val) => {
            // see also 
            // console.log(val instanceof NavigationEnd)

        });

        
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
            beforeinit: this.appBeforeInit,
            init: this.appinit

        })
        this.registerEventService(this.events, {
            "modelitem.drop.confirm": e => this.dropModelItem(e.data),
            "template.import": e => this.importTemplate(e.template),
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
        })

        this.registerEventService(document, {
            'pointerup': e => this.subEventService.emit(e),
            'pointermove': e => this.subEventService.emit(e)
        });


        // this.checkDemoData()
    }

    onInit() {
        this.isLockEventListenner = false;
        this.activeEventServiceRegistered(this.app);
        // this.activeEventServiceRegistered(this.app.engine);
        this.activeEventServiceRegistered(this.events);
        this.activeEventServiceRegistered(this.toolbar);
        this.activeEventServiceRegistered(document);

        if (this.app.engine) {
            this.app.engine.on(this.engineEvent);
        }
        this.vectorControls.emit({
            type: "show",
            value: true
        }, null, true);

        this.editorToolbar.show({
            saveView: e => this.app.saveCurrentCameraPosition(),
            saveThumbnail: e => this.saveThumbnail(),
            exportImage: e => this.exportImage()
        })


        this.preload();


        this.cd.detectChanges();
    }

    onDestroy() {
        this.isLockEventListenner = true;
        this.deactiveEventServiceRegistered(this.app);
        // this.activeEventServiceRegistered(this.app.engine);
        this.deactiveEventServiceRegistered(this.events);
        this.deactiveEventServiceRegistered(this.toolbar);
        this.deactiveEventServiceRegistered(document);

        this.vectorControls.emit({
            type: "show",
            value: false
        }, null, true);

        this.editorToolbar.hide();


        if (this.app.engine) {
            this.app.engine.off(this.engineEvent);
        }
    }

    showLoading() {
        if (!this.isFocus) return false;
        this.viewportService.emit("show:loading", null, true);
        this.events.emit("show:sidebar-lock");
    }
    hideLoading() {
        if (!this.isFocus) return false;
        this.viewportService.emit("hide:loading", true, true);
        this.events.emit("hide:sidebar-lock");
    }

    initUpdate() {
        if (!this.isFocus) return false;
        this.id = +this.activatedRoute.snapshot.paramMap.get("id");
        if (this.id > 0) {
            this.loadProject(this.id);

        }
        else {
            this.storage.editorMode = 'notfound';
            this.cd.detectChanges();
        }
    }
    initCreate() {
        if (!this.isFocus) return false;
        this.storage.mode = 'create';
        let data = getBlankAppData();
        this.setProjectData(data);
        // console.log("create", data);
        this.isLoading = false;
        this.cd.detectChanges();
    }

    preload() {
        if (!this.isFocus) return false;
        this.secret_id = this.activatedRoute.snapshot.paramMap.get("id");
        if (this.secret_id == getConfig('data.project.secret_id')) {
            let data = getConfig('data.project');
            this.storage.project = data;
            this.lazyLoadProject(data.data);
            this.isLoading = false;
            this.storage.mode = 'update';
            this.storage.editMode = getConfig('mode')
            this.cd.detectChanges();

        } else {
            this.storage.mode = 'notfound';
            this.isLoading = false;
        }

    }

    importTemplate(template: TemplateModel) {
        if (!this.isFocus) return false;
        this.showLoading();
        setTimeout(() => this.app.importTemplate(template.data), 100);

    }

    clickSave(event) {
        if (!this.isFocus) return false;
        if (this.mode == "update") {
            this.project.data = this.app.data;
            this.projectService.update(this.project).subscribe(rs => {
                // lam gi do
            });
        } else if (this.mode == "create") {
            this.project.data = this.app.data;
            this.projectService.create(this.project).subscribe(rs => {
                this.id = rs.data.id;
                this.mode = "update";
                this.app.data.id = this.id;

            });

        }
    }




    loadProject(id: number) {
        if (!this.isFocus) return false;
        this.showLoading();
        // var project = this.projectTable.find(id);
        // if (project && !isEmpty(project)) {
        //     this.storage.editorMode = 'update';
        //     this.storage.project = project;
        //     this.isLoading = false;
        //     this.hideLoading();
        //     this.lazyLoadProject(project as ProjectModel);
        //     this.cd.detectChanges();
        // } else {
            this.projectService.get(this.id).subscribe(data => {
                this.storage.project = data;
                this.isLoading = false;
                this.hideLoading();
                this.lazyLoadProject(data);
                this.storage.mode = 'update';
                this.cd.detectChanges();
            }, error => {
                this.storage.mode = 'notfound';
                this.hideLoading();
                this.cd.detectChanges();
            });
        // }

    }

    lazyLoadProject(project) {
        let preData = assignWithout({}, project, ['objects', 'meshes', 'models', 'scene']);
        preData.scene = assignWithout({}, project.scene, ['foregrounds', 'background']);
        this.setProjectData(preData);
        runTask('loading.progress', [20]);
        setTimeout(() => {
            if (!project.objects || !project.objects.length) {
                setTimeout(() => {
                    runTask('loading.progress', [50]);
                    setTimeout(() => {
                        runTask('loading.progress', [100]);
                        setTimeout(() => {
                            runTask('loading.complete', [project]);
                        }, 1000);
                    }, 1000);
                }, 500);
            }
            else {
                this.showLoading();
            }

        }, 11);
        setTimeout(() => {
            this.setProjectData(project);
        }, 25);
    }




    setProjectData(data: ProjectModel) {
        if (!this.isFocus) return false;
        this.app.setProject(data);
    }


    saveThumbnail() {
        if (!this.isFocus) return false;
        this.app.editor.unselect();
        this.showLoading();
        setTimeout(() => {
            this.app.capture(image => {
                this.project.thumbnail = image;
                this.projectService.updateThumbnail({
                    id: this.project.id,
                    thumbnail: this.project.thumbnail
                } as ProjectModel).subscribe(rs => {
                    this.hideLoading();
                }, e => {
                    this.hideLoading();
                });
            });

        }, 1000);
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

    



    onMeshAttach(data) {
        if (!this.isFocus) return false;
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
        if (!this.isFocus) return false;
        // this.toolbar.hide();
        this.geoService.close();
        this.panelModelService.close();
        this.panelLightService.close();
    }

    onDetach() {
        if (!this.isFocus) return false;
        this.toolbar.hide();
        this.closeAllPanel();

    }

    showLight(data) {
        if (!this.isFocus) return false;
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
        if (!this.isFocus) return false;
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


            if (model.type == "model" && model.data.download_source_url != "") {
                const link = document.createElement('a');
                link.setAttribute('target', '_blank');
                link.setAttribute('href', model.data.download_source_url);
                link.setAttribute('download', model.data.name + ".zip");
                document.body.appendChild(link);
                link.click();
                link.remove();
            }
        }

    }

    dropModelItem(data) {
        if (!this.isFocus) return false;
        this.confirmService.showConfirm({
            title: "Drop Item confirm",
            content: "Item's size is bigger than size of Scene. Do you want to continue?"
        }, d => {
            this.showLoading();
            this.events.emit({
                type: 'item.dropped',
                item: data.item,
                success: (dat) => {
                    this.events.emit('viewport.droppable.hide');
                    var size = data.item.size;
                    this.app.updateSceneSizeAndFloorAndGridNyChildren(2);
                    // this.app.updateSceneSizeSetting()
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


                    var sceneData = this.app.getRealSceneSize();
                    var x = sceneData.size.x;
                    var y = sceneData.size.y;
                    var z = sceneData.size.z;
                    var fov = this.app.engine.camera.fov;
                    var tan = Math.tan(degreeToRadians(fov / 2));
                    var ds = (z / 2) + ((x > y ? x : y) / 2) / tan;
                    var dz = ds * 1.5;
                    var far = this.app.engine.camera.far > dz ? this.app.engine.camera.far : dz;
                    var near = this.app.engine.camera.near;
                    if (z >= 50) {
                        near = 1;
                    }
                    else if (z > 20) {
                        near = 0.5;
                    }
                    else if (z > 10) {
                        near = 0.1;
                    }
                    if (near < this.app.engine.camera.near) near = this.app.engine.camera.near;


                    this.app.updateCameraSetting({
                        far: far,
                        near: near,
                        position: {
                            z: ds * 1.5,
                            y: y / 2,
                            x: 0
                        },
                        settings: {
                            position: {
                                type: "custom",
                                custom: {
                                    z: ds * 1.5,
                                    y: y / 2,
                                    x: 0
                                }
                            }
                        }
                    }, true);

                }
            })
        }, () => {
            this.events.emit('viewport.droppable.hide');
        });
    }

    nzCollapsedChange(event) {
        if (!this.isFocus) return false;
        this.app.updateCanvasSize();
    }


    ngAfterViewInit(): void {
        if (!this.isFocus) return;
        this.app.updateCanvasSize();
    }

}
