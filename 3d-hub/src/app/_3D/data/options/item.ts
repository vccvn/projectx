export const ItemOptions = {
    renderer: {
        autoStart: false,
    
        params: {
            antialias: true
        },
        shadowMap: {
            enabled: true
        },
        outputEncoding: "{THREE.sRGBEncoding}"
    },
    composer: {
        effect1: "bloom",
        params: {
            options: {
                blendFunction: 16,
                luminanceThreshold: 0.9,
                luminanceSmoothing: 0.025,
                resolutionScale: 0.5,
                intensity: 1
            }
        }
    },
    shadow: {
        pcss: false
    },
    scene: {
        background: {
            type1: "file",
            format: "hdr",
            path: "/textures/equirectangular/",
            file: "royal_esplanade_1k.hdr"

        },
        env0: {
            type: "room"
        }
    },
    camera: {
        fov: 45,
        near: 0.001,
        far: 100000,
        position: {
            x: 0,
            y: 0.3,
            z: 1
        },
        "@lookAt": [
            0,
            3,
            0
        ],
        autofit: true
    },
    control: {
        type: "orbit",
        autoUpdateScene: true,
        maxPolarAngle0: Math.PI * 0.52,
        maxDistance: 120000,
        enableDamping: true,
        dampingFactor: 0.08,
        constraint: {
            smoothZoom: true,
            zoomDampingFactor: 0.2,
            smoothZoomSpeed: 5.0
        }
    },
    lights: [
        {
            "type": "ambient",
            "data": {
                "params": {
                    "color": "#ffffff",
                    "intensity": 0.29
                }
            },
            "secret_key": "DUkWmYXqHLn30h8srtGc1fClZ5VBh7Vs"
        },
        {
            "type": "point",
            "data": {
                "params": {
                    "color": "#7979cf",
                    "intensity": 0.3
                },
                "props": {
                    "position": {
                        "x": 0,
                        "y": -10
                    }
                }
            },
            "secret_key": "QT2uvl11GYiE9lBJ31kWLN7uZ4LVUY5h"
        },
        {
            "type": "Directionallight",
            "data": {
                "params": {
                    "color": "#f6f4f1",
                    "intensity": 0.82
                },
                "props": {
                    "position": {
                        "x": 16.02500081858694,
                        "y": 18.79744380916517,
                        "z": 7.122096507786499
                    },
                    "castShadow": true,
                    "shadow": {
                        "mapSize": {
                            "width": 4096,
                            "height": 4096
                        },
                        "camera": {
                            "near": 0.1,
                            "far": 100,
                            "left": 10,
                            "right": -10,
                            "top": 10,
                            "bottom": -10
                        },
                        "darkness": 0.1,
                        "bias": -0.0002,
                        "radius": 5
                    }
                }
            },
            "secret_key": "4SBlh9qasmkym2qVinqXZQmrE1wyPz4g"
        },
        {
            "type": "Directionallight",
            "data": {
                "params": {
                    "color": "#C7CCFF",
                    "intensity": 0.43
                },
                "props": {
                    "position": {
                        "x": -16.04440520733398,
                        "y": -3.567607712100961,
                        "z": 2.6468429612346043
                    }
                }
            },
            "secret_key": "FSFhrzuO3FGYgYwdNRfMIaTuF0vwNr53"
        },
        {
            "secret_key": "wnrnh6P4c3lYDTJDWv3MUOkjp1ds3eOF",
            "type": "Directionallight",
            "data": {
                "params": {
                    "color": "#d9e6f1",
                    "intensity": 0.64
                },
                "props": {
                    "position": {
                        "x": 14.52245679582316,
                        "y": 10.872836588837433,
                        "z": -14.374035534912764
                    },
                    "castShadow": true,
                    "shadow": {
                        "mapSize": {
                            "width": 4096,
                            "height": 4096
                        },
                        "camera": {
                            "near": 0.1,
                            "far": 100,
                            "left": 10,
                            "right": -10,
                            "top": 10,
                            "bottom": -10
                        },
                        "darkness": 0.1,
                        "bias": -0.0002,
                        "radius": 5
                    }
                }
            }
        }
    ],
    objects: [

    ]
}
