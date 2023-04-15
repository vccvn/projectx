import {assignWithout, isArray, isObject} from '@app/_core/helpers/utils';
import * as THREE from 'three';
import Props from '../libs/props';

const GridHelper = {
    addGrid: function (options?:any) {
        var self = this;
        var opt = typeof options == "object" ? options : {};
        var params:any = {};
        var t = String(opt.type || "").toLowerCase();
        var grid = null;
        if(t == "polar"){
            params = Props.parseParams(opt.params || opt, {
                radius : 10, radials : 16, circles : 8, divisions : 64, color1 : undefined, color2 : undefined
            });
            
            grid = new THREE.PolarGridHelper( params.radius, params.radials, params.circles, params.divisionsl, params.color1, params.color2 );

        }
        else{
            params = Props.parseParams(opt.params || opt, {
                size : 16, divisions : 10, colorCenterLine : undefined, colorGrid : undefined
            });
            
            grid = new THREE.GridHelper( params.size, params.divisions , params.colorCenterLine, params.colorGrid);
        }
        if(grid){
            assignWithout(grid, opt.props || opt, ['parama', 'props', 'type'], params);
            this.addToScene(grid, opt.handler || opt.updateHandler || opt.handlerData || opt.updateHandlerData);
        }

    },
    addGrids: function addGrids(grids?:any) {
        if (isArray(grids)) {
            for (let index = 0; index < grids.length; index++) {
                const grid = grids[index];
                if (isObject(grid)) {
                    this.addGrid(grid);
                }
            }
        }
        return this;
    },
};


export default GridHelper;
