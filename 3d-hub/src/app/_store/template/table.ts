import { Injectable } from '@angular/core';
import { DbTableColumns } from '@app/_core/helpers/local-db';
import { LostDbTableService } from '@app/_core/services/lost-db-table.service';
import { LostDbService } from '@app/_core/services/lost-db.service';

@Injectable({
    providedIn: 'root'
})
export class TemplateTableService extends LostDbTableService {
    name: string = 'templates';
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
        thumbnail: {
            type: "string",
            defVal: ""
        },
        renderer: {
            type: "object",
            defVal: {}
        },
        scene: {
            type: "object",
            defVal: {}
        },

        composer: {
            type: "object",
            defVal: {}
        },
        shadow: {
            type: "object",
            defVal: {}
        },
        camera: {
            type: "object",
            defVal: {}
        },
        control: {
            type: "object",
            defVal: {}
        },
        lights: {
            type: "array",
            defVal: []
        },
        // objects
        objects: {
            type: "array",
            defVal: []
        },
        // objects
        meshes: {
            type: "array",
            defVal: []
        }

    }
    constructor(private dbService: LostDbService) {
        super(dbService);
        this.init();
    }
}
