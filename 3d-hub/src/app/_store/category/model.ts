import { ItemModel } from "../item";
import { ProjectModel } from "../project";
import { TemplateModel } from "../template";

export enum ECategoryStatus {
    draft = 'draft',
    published = 'published',
}
export interface CategoryModel {
    id: number,
    name: string,
    status?: string, 
    description?: string,
    itemCount?: number,
    items?:ItemModel[],
    projects?:ProjectModel[],
    templates?:TemplateModel[]
    
}
