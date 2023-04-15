import { AppData } from "@app/_3D/store/data.type";

export const BlankData: AppData = {
    id: 1,
    name: "View 1",
    category_id: 2,
    description: "Đây là màn hình view",
    thumbnail: "",
    status: "published",
    renderer: {
        params: {
            antialias: true,
            alpha: true
        },
        shadowMap: {
            enabled: true
        },
        outputEncoding: "{THREE.sRGBEncoding}"
    },
    composer: {},
    shadow: {
        enabled: true,
        pcss: false
    },
    scene: {
        size: {
            width: 4,
            height: 4,
            depth: 4
        },
        floor: {
            enabled: true,
            above: true,
            params: {
                type: "plane",
                width: 4,
                height: 4
            },
            props: {
                position: {
                    x:0,
                    y: -0.2,
                    z: 0
                }
            }
        }
    },
    camera: {
        fov: 45,
        near: 0.001,
        far: 1000,
        position: {
            x: 0,
            y: 0.4,
            z: 1.5
        },
        autofit: true

    },
    control: {
        type: "orbit",
        autoUpdateScene: true,
        maxDistance: 1200,
        minDistance: 0.001,
        enableDamping: true,
        dampingFactor: 0.1,
        enablePan: false,
        highPerformance: true,
        constraint: {
            smoothZoom: true,
            zoomDampingFactor: 0.2,
            smoothZoomSpeed: 5
        }
    },
    lights: [
        {
            type: "ambient",
            data: {
                params: {
                    color: "#ffffff",
                    intensity: 0.5
                }
            },
            secret_key: "DUkWmYXqHLn30h8srtGc1fClZ5VBh7Vs"
        },
        {
            type: "point",
            data: {
                params: {
                    color: "#4444cc",
                    intensity: 0.3
                },
                props: {
                    position: {
                        x: 0,
                        y: -10
                    }
                }
            },
            secret_key: "QT2uvl11GYiE9lBJ31kWLN7uZ4LVUY5h"
        },
        {
            type: "Directionallight",
            data: {
                params: {
                    color: "#FFE0B5",
                    intensity: 0.4
                },
                props: {
                    position: {
                        x: 10,
                        y: 10,
                        z: 8
                    },
                    castShadow: true,
                    shadow: {
                        mapSize: {
                            width: 4096,
                            height: 4096
                        },
                        camera: {
                            near: 0.1,
                            far: 100,
                            left: 10,
                            right: -10,
                            top: 10,
                            bottom: -10
                        },
                        darkness: 0.1,
                        bias: -0.0002,
                        radius: 5
                    }
                }
            },
            secret_key: "4SBlh9qasmkym2qVinqXZQmrE1wyPz4g"
        },
        {
            type: "Directionallight",
            data: {
                params: {
                    color: "#ffffff",
                    intensity: 0.4
                },
                props: {
                    position: {
                        x: -8.713868426053745,
                        y: 2.1376221949126535,
                        z: -1.994170574933185
                    }
                }
            },
            secret_key: "FSFhrzuO3FGYgYwdNRfMIaTuF0vwNr53"
        },
        {
            secret_key: "wnrnh6P4c3lYDTJDWv3MUOkjp1ds3eOF",
            type: "Directionallight",
            data: {
                params: {
                    color: "#b5ebff",
                    intensity: 0.28
                },
                props: {
                    position: {
                        x: 10,
                        y: 10,
                        z: -7
                    },
                    castShadow: true,
                    shadow: {
                        mapSize: {
                            width: 4096,
                            height: 4096
                        },
                        camera: {
                            near: 0.1,
                            far: 100,
                            left: 10,
                            right: -10,
                            top: 10,
                            bottom: -10
                        },
                        darkness: 0.1,
                        bias: -0.0002,
                        radius: 5
                    }
                }
            }
        }
    ],
    objects: [

    ],
    meshes: [

    ]
    

}