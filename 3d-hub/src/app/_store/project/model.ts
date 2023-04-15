export enum EProjectStatus {
    draft = 'draft',
    published = 'published',
}


export interface ProjectModel {

    id: number,
    name: string,
    category_id?: number,
    description?: string,
    status?: string,
    allow_custom?:boolean,
    thumbnail?: string
    renderer?: any
    scene?:any
    
    composer?: {
        [x: string]: any
    }
    
    shadow?: any
    camera?:any
    control?:any
    lights?: any[],
    // objects
    objects?: any[]
    // objects
    meshes?: any[]
    [x: string]: any


}
