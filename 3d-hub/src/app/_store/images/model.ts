export enum EImageStatus {
    draft = 'draft',
    published = 'published',
}


export interface ImageModel {

    id: number,
    owner_id: number,
    upload_by: number,
    sid: string,
    privacy: string,
    date_path: string,
    filename: string,
    original_filename: string,
    filetype: string,
    mime: string,
    size: number,
    extension: string,
    title: string,
    description: string,
    created_at: string,
    updated_at: string,
    url: string,
    thumbnail: string,
    size_unit:string,
    source: string,

    [x:string]:any

}
