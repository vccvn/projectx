import Viewport from '../components/viewport.js';
import * as THREE from 'three';
import { OrbitControls } from '../threejs/jsm/controls/OrbitControls.js';
import { ES5AbstractClass, ES5Instance } from '@app/_core/helpers/es5.class.js';
import { AppData, CameraSetting, ControlSetting, FloorSetting, SceneSetting, SceneSize, Vector3 } from '../store/data.type.js';
interface LightParam {
    type: string,
    data: {
        params: {
            color?: string,
            [param: string]: any
        },
        props: {
            [param: string]: any
        }
    }

}

interface ObjectData {
    secret_key: string,
    type: string,
    object: any,
    meshes?: THREE.Mesh[],
    size?:{
        origin?: Vector3 & SceneSize,
        custom?: Vector3 & SceneSize
    }
}
export interface EngineInstance extends ES5Instance {
    scene: THREE.Scene,

    sceneHelper: any,
    showSceneHelper: any,

    getScene(opts: any, cmt?: any): THREE.Scene
    /**
     * khởi tạo scene
     * @param {object} opts thuộc tính của scene
     */
    initScene(opts?: any): this

    setScene(scene?: any): void
    updateSceneSettings(settings: SceneSetting): this
    updateSceneFloorSetting(floor: FloorSetting): this
    /**
     * Thêm môi trường
     * @param {string} env môi trường
     */
    addSimpleEnv(env?: any): void

    /**
     * set Màu nền
     * @param {int|string} color màu
     */
    setBackgroundCokor(color?: any, scene?: any): void
    /**
     * Set nền khung cảnh
     * @param {object} opts tham số
     */
    setBackground(opts?: any, scene?: any, cmt?: any): void
    /**
     * them doi tuong vao khung
     * @param {object} obj doi tuong
     */
    addToScene(obj?: any): boolean
    removeFromScene(object?: any): void
    addAxesHelper(size?: any): boolean
    getSceneSize(): {
        min: {
            x: number, y: number, z: number
        },
        max: {
            x: number, y: number, z: number
        },
        size: {
            x: number, y: number, z: number
        }
    }

    camera: THREE.PerspectiveCamera,
    cameraList: { [id: string]: THREE.PerspectiveCamera },
    /**
     * thiết lập cam chính
     * @param {object} opts 
     */
    setMainCamera(setting: CameraSetting): this

    /**
     * thiết lập cam chính
     * @param {object} opts 
     */
    updateMainCameraSettings(setting: CameraSetting, update?: boolean): this
    /**
    * thiết lập cam chính
    * @param {object} opts 
    */
    updateControlSettings(setting: ControlSetting): this
    /**
     * thêm vào danh sách camera
     * @param {option} options thuộc tính
     */
    addCamera(options: CameraSetting): void

    /**
     * thêm nhiều camera
     * @param {Array} cameras array
     */
    addCameras(cameras?: CameraSetting[]): void
    /**
     * 
     * @param {object} opts 
     */
    getCamera(opts?: any): THREE.PerspectiveCamera

    /**
     * thiết lập vị trí
     * @param {int} x vĩ trí x
     * @param {number} y vị trí y
     * @param {number} z vị trí z
     */
    setCameraPosition(x?: any, y?: number, z?: number): void
    setCameraRotation(x?: any, y?: number, z?: number): void

    /**
     * lấy ra các camera đã dc add
     * @param {string} id 
     */
    getAddedCamera(id: any): void

    changeCamera(id: any, options?: any): void



    width: number,
    height: number,
    aspect: number,
    renderer: THREE.WebGLRenderer,
    composer: any,
    viewport: Viewport,


    animationTasks: {
        animate(): void,
        timeoutAnimate(): void,
        activeShadowAfter(): void
    }



    /**
     * @var {boolean} autoRenderMode Tự động gửi yêu cầu tạo hoạt cảnh
     */
    autoRenderMode: boolean,
    autoRenderStatus: boolean,
    autoRenderTimerStatus: boolean,
    autoRenderTimerStart: boolean,
    autoRenderCountdown: number,
    autoRenderTimerMilisecond: number,
    autoRenderDistance: number,

    deactiveShadowStatus: boolean,
    deactiveShadowTimeMstart: boolean,
    deactiveShadowTimeMilisecond: number,
    deactiveShadowTimeCountdown: number,


    inViewport: boolean,
    pointerPosition: {
        x: number,
        y: number
    },
    pointerStart: boolean,


    lastOrbitControlData: string,
    createRenderer(opts?: any): this

    getCanvas(): HTMLElement,

    setSize(width?: any, height?: any): this

    updateCanvasSize(e?: any): boolean

    windowResize(e): this

    updateViewportSize(): void

    render(): this



    refresh(): void

    /**
     * Chụp màn hình
     */
    capture(): string

    /**
     * khởi dộng trình auto render
     * @param {int} timer thời gian render tự dộng
     * @param {int} checkDistance thời gian cách nhau giữa 2 lần kiềm tra trạng thái
     */
    startAnimateTimer(timer?: any, checkDistance?: any): void
    /**
     * khởi dộng trình auto render
     * @param {int} timer thời gian render tự dộng
     * @param {int} checkDistance thời gian cách nhau giữa 2 lần kiềm tra trạng thái
     */
    startDeactiveShadowTimer(timer?: any, checkDistance?: any): void

    start(): void
    ready(): void

    reset(data?:AppData): void
    renew(data:AppData): void
    

    control: OrbitControls,
    controlEnableDamping: boolean,
    controlList: any,

    /**
     * set control chính
     * @param {object} opts thuộc tính, tham số tạo 
     */
    setMainControl(opts?: any): this
    /**
     * tao control
     * @param {object} options tham số + thuộc tính
     */
    addControl(options?: any): OrbitControls

    /**
     * Tạo nhiều control
     * @param {array} controls 
     */
    addControls(controls?: any[]): void

    /**
     * lấy control từ ThreeJS
     * @param {object} options thuộc tính và tham số
     */
    getControl(options?: any): OrbitControls

    getAddedControl(id): OrbitControls

    setCurrentConttrolProp(prop, value): void
    checkControlChangeStopped(): void
    controlMouseDown(): void


    /**
     * 
     * @param {object} obj 
    */
    getMeshFromObject(obj?: any): THREE.Mesh[]
    /**
     * load moidel
     * @param {object} option các thông số load
     * @param {function} success hoàn thành quá trình load
     * @param {function} progress tiến trình load
     * @param {function} error xảy ra lổi
     */
    loadModel(option?: any, success?: (...args: any[]) => any, progress?: (...args: any[]) => any, error?: (...args: any[]) => any): void

    /**
     * 
     * @param {Object3D} obj 
     * @param {Object} options 
     */
    parseModel(obj?: any, options?: any, model?: any): any
    /**
     * Get model
     * @param {Object} options các thong so load
     * @param {function(obj, model)} onSuccess 
     * @param {function(error)} onError 
     * @param {function(proccessing)} onProgress
     */
    getMode(options?: any, onSuccess?: any, onError?: any, onProgress?: any): any

    /**
     * them model
     * @param {object} options các thong so load
     * @param {function(data)} onSuccess 
     * @param {function(s)} onError 
     */
    getModelAndConvertToAppObjectData(options?: any, onSuccess?: any, onError?: any, onProgress?: any): void

    lightTypes: string[],
    lights: THREE.Light,
    /**
     * them doi tuong vao khung
     * @param {object} obj doi tuong
     * @param {function(<object>)} success
     */
    addLightObject(obj: any, secret_key?: string, success?: (...args: any[]) => any): {
        type: string,
        object: THREE.Light,
        secret_key: string

    },


    removeLightObject(args: any): void
    /**
     * them êm hiệu ung anh sang
     * @param {string} type loai hieu ung anh sang
     * @param {function(lightData:<Object>)} success 
     */
    addLight(lightOptions: any, success?: (...args: any[]) => any): {
        type: string,
        object: THREE.Light,
        secret_key: string

    },

    /**
     * Thêm nhiều ánh sáng
     * @param {array} lights mảng các tham số
     */
    addLights(lights: any[]): Array<{
        type: string,
        object: THREE.Light,
        secret_key: string

    }>

    /**
     * 
     * @param {string} secret_key
     * @returns 
     */
    getLight(secret_key: any): {
        type: string,
        object: THREE.Light,
        secret_key: string

    },

    /**
     * 
     * @param {string} secret_key
     * @returns 
     */
    removeLight(secret_key?: any): boolean

    updateLightProps(secret_key?: any, properties?: any): void
    getLightTemplateDatafunction(type?: any): LightParam

    lightTemplateData: {
        [type: string]: LightParam
    }


    objects: ObjectData[],



    /**
     * them doi tuong vao khung
     * @param {object} obj doi tuong
     * @param {function} updateHandler hanh dong khi update
     */
    addObjectData(obj: any, updateHandler?: (...args: []) => any, secret_key?: any): string

    removeObjectData(args?: any): boolean
    /**
     * Thêm model item để thiết lập 
     * @param {Object} options 
     * @param {function(obj, model)} onSuccess 
     * @param {function(error)} onError 
     * @param {function(proccessing)} onProgress
     */
    addSettingModelItem(options: any, onSuccess?: (obj?: any, model?: any) => any, onError?: (error?: any) => any, onProgress?: (percent?: number) => any): any
    /**
    * Thêm model item để thiết lập templates
    * @param {string} secret_key 
    * @param {Object} options 
    * @param {function(obj, model)} onSuccess 
    * @param {function(error)} onError 
    * @param {function(proccessing)} onProgress
    */
    addItemToTemplateSettingWorkspace(secret_key: string, options?: any, onSuccess?: (object?: any, model?: any) => any, onError?: (error?: any) => any, onProgress?: (percent?: number) => any): any
    /**
    * them model
    * @param {object} options các thong so load
    * @param {function} success 
    * @param {function} onError 
    */
    addModel(options: any, success?: (data?: any) => any, onError?: (error?: any) => any, onProgress?: (percent?: number) => any): any
    /**
     * Thêm nhiều ánh model
     * @param {array} models mảng các tham số
     */
    addModels(models?: any[]): this

    addMesh(options: any, success?: (data?: any) => any): string
    addMeshes(meshes: any[]): this
    addObject(object: any, onSuccess?: (data?: any) => any, onError?: (error?: any) => any): void
    addObjects(objects?: any[]): void

    getObjectSize(secret_key: any): { x: number, y: number, z: number }
    /**
     * Nhóm các đối tượng
     * @param {object} groupData dữ liệu nhóm
     */
    addGroup(groupData: any, success?: (data?: any) => any): void
    getObject(secret_key: any): ObjectData

    removeObject(args: any): boolean

    getMesh(args: any): ObjectData
    parseUpdateHandler(handler: any): void

    __floorObject: any,
    addFloor(options: any): void

    updateFloor(): void

    /**
     * Cập nhật thuộc tính cho đối tượng
     * @param {string} id key nhan dien doi tuong trong scene
     * @param {*} settings 
     */
    updateObjectSettings(id: any, settings?: any, updateList?: any, meshIndex?: any, materialIndex?: number): boolean

    updateMeshMaterial(secret_key: any, meshName: any, material: any, materialIndex?: any): boolean

    updateMeshesSettings(secret_key: any, settings?: any): boolean

    getDownloadLinkElement(): string


    downloadUrl(url?: string, filename?: string): void
    exportItemAsGltf(id: any, options?: any, callback?: (data: any) => any): void
    save(blob: any, filename?: string): void

    saveString(text: string, filename: string): boolean


    saveArrayBuffer(buffer: any, filename: string): boolean


    /**
     * chuẩn hóa hàn lắng nghe sự kiện
     * @param {string|function} handler tên phương thức hoạc hàm handler
     * @returns function
     */

    parseEventHandler(handler: any): (...args: any[]) => any

    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} dispatch Thực thi trên tất cả các sự kiện trước đó
     * @returns this
     */
    addEventListener(type: string, handler: any, dispatch?: any): this
    /**
     * Kiểm tra sự kiện có tồn tại hay không
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    hasEventListener(type: string, listener?: any): boolean
    /**
     * Xóa / Gỡ sự kiện
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    removeEventListener(type: string, listener?: any): boolean
    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    dispatchEvent(event: any, data?: any): boolean
    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} passed tham số báo có cần kiểm tra hay ko
     * @returns this
     */
    on(type: any, listener?: any): this
    off(type: any, listener?: any): boolean,
    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    emit(event: any, data?: any): boolean
    addDispatchedEvent(event?: any): this
    handleDispatchedEvents(type: string, handler: (...args: any[]) => any): void
    [method: string]: any
}

export interface EngineClass extends ES5AbstractClass {
    (...args: any[]): EngineInstance
    new(...args: any[]): EngineInstance
}