import { ThreeMesh } from "@app/_3D/store/data.type";

export enum EItemStatus {
    draft = 'draft',
    protected = "protected",
    published = 'published',
}

export interface ItemMeshSettings {
    name?: string,
    sid?: string,
    index?: number,
    title?: string, 
    data?: {
        material?: any,

    },
    editable?: Array<string>,
    __ref__?:ThreeMesh
    __inputs__?:any[],
    __secret_key__?:string,
    __parent_key__?:string
}


export interface ItemSettings {
    props?: {
        castShadow?: boolean,
        receiveShadow?: boolean,
        position?: {
            x?: number,
            y?: number,
            z?: number
        },
        rotation?: {
            x?: number,
            y?: number,
            z?: number
        }
        scale: {
            x?: number,
            y?: number,
            z?: number
        }
    },
    options?: {
        [x: string]: any
    },
    meshes?: Array<ItemMeshSettings>
}

export interface ItemModel {

    id: number,
    name: string,
    category_id?: number,
    description?: string,
    status?: string,
    type?: string,
    path?: string,
    file?: string,
    download_source_url?: string,
    thumbnail?: string,
    load_options?: {
        useRoughnessMipmapper?: boolean,
        materialNeedsUpdate?: boolean
    },
    settings?: ItemSettings,
    size?: {
        x?:number,
        y?:number
        z?:number
    }
}

export const ItemDefaultData: ItemModel = {
    id: 0,
    name: "",
    category_id: 0,
    description: "",
    status: EItemStatus.draft,
    type: "gltf",
    path: "https://threejs.vcc.vn/models/gltf/set21/",
    file: "scene.gltf",
    download_source_url: "https://threejs.vcc.vn/zip/set21.zip",
    thumbnail: "",
    load_options: {
        useRoughnessMipmapper: true,
        materialNeedsUpdate: true
    },
    settings: {
        
    },
    size: {
        x:0,
        y:0,
        z:0
    }
}
