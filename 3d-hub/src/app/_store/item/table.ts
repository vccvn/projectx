import { Injectable } from '@angular/core';
import { DbTableColumns } from '@app/_core/helpers/local-db';
import { LostDbTableService } from '@app/_core/services/lost-db-table.service';
import { LostDbService } from '@app/_core/services/lost-db.service';

@Injectable({
    providedIn: 'root'
})
export class ItemTableService extends LostDbTableService {
    name: string = 'items';
    columns: DbTableColumns = {
        id: {
            type: "number",
            autoIncrement: true
        },
        name: {
            type: "string",
            required: true,
        },
        category_id: {
            type: "number",
            defVal: 0
        },
        description: {
            type: "string",
            defVal: ""
        },
        status: {
            type: "string",
            defVal: "draft"
        },
        type: {
            type: "string",
            defVal: "gltf"
        },
        path: {
            type: "string",
            defVal: ""
        },
        file: {
            type: "string",
            defVal: ""
        },
        download_source_url: {
            type: "string",
            defVal: ""
        },
        thumbnail: {
            type: "string",
            defVal: ""
        },
        load_options: {
            type: "object",
            defVal: {
                useRoughnessMipmapper: true,
                materialNeedsUpdate: true
            }
        },
        settings: {
            type: "object",
            defVal: {}
        },
        size: {
            type: "object",
            defVal: {
                x: 0,
                y: 0,
                z: 0
            }
        },
    }
    constructor(private dbService: LostDbService) {
        super(dbService);
        this.init();
    }
}
