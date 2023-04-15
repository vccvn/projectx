import { ES5Instance } from "@app/_core/helpers/es5.class";
import { EventDispatcherInstance } from "../libs/event-dispatcher";
import { App3DService } from "../services/app-3d.service";
import { SceneSize, Vector2, Vector3 } from "./data.type";

export interface iEditor extends ES5Instance, EventDispatcherInstance {
    app: App3DService
    setup(): void
    updateHelperByObject(object: any): any
    updateHelperByLight(object: any): any
    updateLightTargetByTargetControlObject(targetControl: any): any
    addObject(object: any): any


    removeObject(object: any): any

    addLight(light: any): any

    removeLight(light: any): any
    showLightHelpers():any
    hideLightHelpers():any
    
    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestObjectInScene(obj: any): any
    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestLightInScene(obj: any): any
    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestLightTargetControlInScene(obj: any): any
    /**
     * chọn object
     * @param {Vector3} pointer diểm click
     * @returns 
     */
    selectObjectByPointer(pointer: any): any

    select(object: any): any

    selectById(id: any): any

    deselect(): any
    focus(object: any): any
    focusById(id: any): any
    isSelected(object: any): any

    /**
     * attach
     * @param {string|object} object 
     */

    attach(object: any): any
    attachObject(object3D: any): any
    detachObject(): any

    attachLight(light: any): any

    detachLight(): any

    attachLightTargetControl(target: any): any

    detactLightTargetControl(): any


    /**
     * Them target vontrol
     * @param {Object} light anh sang
     */
    getLightTargetControlObject(light: any): any

    getHelper(): any

    removeHelper(object: any): any
    executeCommand(command: any): any
    updateDropAreaAreas(sceneSize: SceneSize, floorPositionY: number, addItemAboveFloor?: boolean) : any
    setDragMoveItem(itemSize: Vector3, itemPosition?: Vector2, customObject?:any): any
    removeDragMoveItem(): any
    checkDroppablePosition(pointer: Vector2): any,
    removeDropAreaAreas():void
    [prop:string]:any
}

export interface EditorClass {
    (app, engine): iEditor
    new(app, engine): iEditor

}



export type GeoConstructor = (args: { [name: string]: any }) => any;

export interface GeometryConfig {
    params: {
        width?: string,
        height?: string,
        depth?: string,
        widthSegments?: string,
        heightSegments?: string,
        depthSegments?: string,
        radiu?: string,
        phiStart?: string,
        phiLength?: string,
        thetaStart?: string,
        thetaLength?: string,
        radius?: string,
        radialSegments?: string,
        openEnded?: string,
        radiusTop?: string,
        radiusBottom?: string,
        segments?: string,
        innerRadius?: string,
        outerRadius?: string,
        thetaSegments?: string,
        phiSegments?: string,
        detail?: string,


    },
    props: {
        [prop: string]: any
    },
    data: {
        params: {
            [par: string]: number | undefined
        }
    }
}

export interface GeometryConfigInstances {
    [key: string]: {
        [x: string]: GeometryConfig
    }
}

export interface _Geometry {
    getGeometry(type: any, args?: any): any,
    get(type: any, args?: any): any,
    getConfig(key?: string): GeometryConfig,
    [name: string]: any | GeoConstructor
    config: {
        instances: GeometryConfigInstances
        options: Array<{ name: string, type: string, value: string, label: string }>
        propTypes: {
            [prop: string]: any
        }

    }

}
export interface MaterialInput {
    type: string,
    editable: boolean,
    data: {
        min?: number,
        max?: number,
        step?: number,
        inputType?: string,
        [x: string]: any
    },
    value: (string | number | boolean)
    [x: string]: any
}
export interface _Materials {
    getMaterial(type: any, args?: any, props?: any, ignoreFlipY?: boolean, success?: any): any
    get(type: any, args?: any, props?: any, ignoreFlipY?: boolean, success?: any): any
    setProperties(type: any, material?: any, props?: any, success?: any, ignoreFlipY?: boolean): any
    /**
     * lay ra kieu thuoc tinh cuar loaai material tuong ung
     * @param {string} type loai material
     */
    getTypeProps(type: any): any

    /**
     * chuan hoa thuoc tinh matẻial
     * @param {string} type loai5 matẻial
     * @param {object} props 
     */
    parseProps(type: any, props: any): any
    /**
     * Lấy key material
     * @param type loai material
     */
    parseType(type: ({ type?: string, [x: string]: any } | string)): string
    getDetectedProps(material: any): any
    getPropData(material: any): any
    getMaterialInputs(type: string, material?: any, settings?: any, editable?: any): any[]
    getMaterialType(type: string): string
    config: {
        data: {
            basic: {
                type: string,
                props: any,
            },
            lambert: {
                type: string,
                props: any,
            },
            normal: {
                type: string,
                props: any,
            },
            phong: {
                type: string,
                props: any,
            },
            physical: {
                type: string,
                props: any,
            },
            standard: {
                type: string,
                props: any,
            },
        },
        options: { [x: string]: any },
        editable: {
            name: string,
            opacity: number,
            side: number,
            shadowSide: number,
            transparent: boolean,
            visible: boolean,
        },
        properties: {
            [x: string]: MaterialInput
        },

        propGroup: {
            default: string[],
            basic: string[],
            depth: string[],
            distance: string[],
            lambert: string[],
            matcap: string[],
            normal: string[],
            phong: string[],
            physical: string[],
            standard: string[],
            toon: string[],
            points: string[],
            shadow: string[],
        }
        [x: string]: any
    }
}
