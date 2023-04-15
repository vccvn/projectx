import { SceneSize, Vector2, Vector3 } from "@app/_3D/store/data.type";
import { isNumber } from "@app/_core/helpers/utils";
import { Meshes } from "../three.libs";

export const DroppableAreas = {
    itemSize: null,
    itemShadowObject: null,
    areaObjects: null,
    setDragMoveItem: function(sceneSize: SceneSize, itemSize:Vector3, floorPositionY:number, addItemAboveFloor?:boolean, itemPosition?:Vector2){
        this.areaObjects = [];
        this.itemSize = itemSize;
        var xStart = -sceneSize.width/2, xEnd = sceneSize.width/2,
            zStart = -sceneSize.depth/2, zEnd = sceneSize.depth/2;
        var bSizeWidth = itemSize.x / 2, bSizeDepth = itemSize.z / 2;
        var bSizeHeight = bSizeWidth > bSizeDepth ? (bSizeDepth / 5) : (bSizeWidth / 5);
        var y = addItemAboveFloor && isNumber(floorPositionY) ? (floorPositionY + bSizeHeight / 2): 0;
        let xC = xStart + bSizeWidth/2, xE = xEnd - bSizeWidth / 2;
        let zC = zStart + bSizeDepth/2, zE = xEnd - bSizeDepth / 2;

        while(xC <= xE){
            while(zC <= zE){
                let box = Meshes.get({
                    geometry: {
                        type: "box", width: bSizeWidth, height: bSizeHeight, depth: bSizeDepth
                    },
                    material: {
                        type: "physical",
                        params: {
                            color: "#d9d9d9"
                        },
                        props: {
                            transparent: true
                        }
                    },
                    props: {
                        position:{
                            x: xC,
                            y: y,
                            z: zC
                        }
                    }
                });

                this.areaObjects.push(box);

                zC +=bSizeDepth;
            }
            xC+= bSizeWidth;
        }
        let plane = Meshes.get({
            geometry:{
                type: "plane", width: itemSize.x, height: itemSize.z
            },
            material:{
                type: "physical",
                params: {
                    roughness: 0.8,
                    color: "#d9d9d9",
                    metalness: 0.2,
                    bumpScale: 0.5
                },
                props: {
                    transparent: true
                }
            },
            props:{
                position: {
                    x: 0,
                    y: addItemAboveFloor && isNumber(floorPositionY) ? (floorPositionY + 0.0001): 0,
                    z: 0
                },
                rotation: {
                    x: -Math.PI / 2
                }
            }
        });
        this.itemShadowObject = plane;


    }
}