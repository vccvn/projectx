export enum ETemplateStatus {
    draft = 'draft',
    published = 'published',
}


export interface TemplateModel {
    id: number
    name: string
    category_id?: number
    description?: string
    status?: string
    thumbnail?: string
    data?: {
        renderer?: any
        scene?: any
        composer?: {
            [x: string]: any
        }
        shadow?: any
        camera?: any
        control?: any
        lights?: any[]
        // objects
        objects?: any[]
        // objects
        meshes?: any[]
        [x: string]: any
    }
    [x: string]: any

}
