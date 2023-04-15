import { isArray, isEmpty, isObject, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';
import * as POSTPROCESSING from '../modules/postprocessing.esm.js';
import {Props} from './props';

const params = {

    clearPass: true,
    clearColor: 'white',
    clearAlpha: 1.0,

    texturePass: true,
    texturePassOpacity: 1.0,

    cubeTexturePass: true,
    cubeTexturePassOpacity: 1.0,

    renderPass: true
};


const ComposerEffects = {
    
    addEffect: function (type:any, options:any) {
        var effectPass = new POSTPROCESSING.EffectPass(
            this.camera,
            // new POSTPROCESSING.BloomEffect()
            this.getEffect(
                type,
                isObject(options) ? options : {}
            )
        );
        effectPass.renderToScreen = true;
        this.composer.addPass(effectPass);
    },
    
    getEffect: function (key:any, options:any) {
        var k = Str.replace(Str.lower(String(key)), "effect", "");
        var ek = typeof this.effects[k] != "undefined" ? this.effects[k] : this.effects.bloom;
        var eff = new POSTPROCESSING.ColorDepthEffect();
        try {
            if (typeof this[ek] == "function") {
                var e = this[ek].apply(this, [options]);
                eff = e;
            }
        } catch (error) {

        }
        return eff;
    },

    BloomEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.BloomEffect(params.options);
        }
        return new POSTPROCESSING.BloomEffect();

    },
    BokehEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.BokehEffect(params.options);
        }
        return new POSTPROCESSING.BokehEffect();
    },

    BrightnessContrastEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.BrightnessContrastEffect(params.options);
        }
        return new POSTPROCESSING.BrightnessContrastEffect();
    },

    ColorAverageEffect: function (options:any) {
        var params = Props.parseParams(options, {
            blendFunction: undefined
        });
        if (params.blendFunction !== undefined) {
            return new POSTPROCESSING.ColorAverageEffect(params.blendFunction);
        }
        return new POSTPROCESSING.ColorAverageEffect();
    },

    ColorDepthEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.ColorDepthEffect(params.options);
        }
        return new POSTPROCESSING.ColorDepthEffect();
    },


    ChromaticAberrationEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.ChromaticAberrationEffect(params.options);
        }
        return new POSTPROCESSING.ChromaticAberrationEffect();
    },



    DepthEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.DepthEffect(params.options);
        }
        return new POSTPROCESSING.DepthEffect();
    },

    DepthOfFieldEffect: function (options:any) {
        var params = Props.parseParams(options, {
            camera: this.camera,
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.DepthOfFieldEffect(params.camera, params.options);
        }
        return new POSTPROCESSING.DepthOfFieldEffect(params.camera);
    },



    DotScreenEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.DotScreenEffect(params.options);
        }
        return new POSTPROCESSING.DotScreenEffect();
    },


    GammaCorrectionEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.GammaCorrectionEffect(params.options);
        }
        return new POSTPROCESSING.GammaCorrectionEffect();
    },
    GlitchEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.GlitchEffect(params.options);
        }
        return new POSTPROCESSING.GlitchEffect();
    },

    GodRaysEffect: function (options:any) {
        var params = Props.parseParams(options, {
            camera: this.camera,
            lightSource: {},
            options: {}
        });
        if (params.lightSource) return null;
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.GodRaysEffect(params.camera, params.lightSource, params.options);
        }
        return new POSTPROCESSING.GodRaysEffect(params.camera, params.lightSource);
    },

    GridEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.GridEffect(params.options);
        }
        return new POSTPROCESSING.GridEffect();
    },
    HueSaturationEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.HueSaturationEffect(params.options);
        }
        return new POSTPROCESSING.HueSaturationEffect();
    },

    NoiseEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.NoiseEffect(params.options);
        }
        return new POSTPROCESSING.NoiseEffect();
    },

    OutlineEffect: function (options:any) {
        var params = Props.parseParams(options, {
            scene: this.scene,
            camera: this.camera,
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.OutlineEffect(params.scene, params.camera, params.options);
        }
        return new POSTPROCESSING.OutlineEffect(params.scene, params.camera);
    },

    PixelationEffect: function (options:any) {
        var params = Props.parseParams(options, {
            granularity: 30.0,
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.OutlineEffect(params.granularity);
        }
        return new POSTPROCESSING.OutlineEffect(params.granularity);
    },


    RealisticBokehEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.RealisticBokehEffect(params.options);
        }
        return new POSTPROCESSING.RealisticBokehEffect();
    },

    ScanlineEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.ScanlineEffect(params.options);
        }
        return new POSTPROCESSING.ScanlineEffect();
    },

    ShockWaveEffect: function (options:any) {
        var params = Props.parseParams(options, {
            camera: this.camera,
            epicenter: new THREE.Vector3(),
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.ShockWaveEffect(params.camera, params.epicenter, params.options);
        }
        return new POSTPROCESSING.ShockWaveEffect(params.camera, params.epicenter);
    },




    SelectiveBloomEffect: function (options:any) {
        var params = Props.parseParams(options, {
            scene: this.scene,
            camera: this.camera,
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.SelectiveBloomEffect(params.scene, params.camera, params.options);
        }
        return new POSTPROCESSING.SelectiveBloomEffect(params.scene, params.camera);
    },



    SepiaEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.SepiaEffect(params.options);
        }
        return new POSTPROCESSING.SepiaEffect();
    },

    TextureEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.TextureEffect(params.options);
        }
        return new POSTPROCESSING.TextureEffect();
    },

    ToneMappingEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.ToneMappingEffect(params.options);
        }
        return new POSTPROCESSING.ToneMappingEffect();
    },

    VignetteEffect: function (options:any) {
        var params = Props.parseParams(options, {
            options: {}
        });
        if (!isEmpty(params.options)) {
            return new POSTPROCESSING.VignetteEffect(params.options);
        }
        return new POSTPROCESSING.VignetteEffect();
    },


    aaaaa: {
        "SMAAEffect": {}, "SSAOEffect": {}, "": {}
    },


    effects: {
        bloom: "BloomEffect", b: "BloomEffect", bl: "BloomEffect", be: "BloomEffect", bokeh: "BokehEffect", bk: "BokehEffect", bke: "BokehEffect", brightnesscontrast: "BrightnessContrastEffect", bc: "BrightnessContrastEffect", brctr: "BrightnessContrastEffect", bce: "BrightnessContrastEffect", chromaticaberration: "ChromaticAberrationEffect", cma: "ChromaticAberrationEffect", cmabe: "ChromaticAberrationEffect", coloraverage: "ColorAverageEffect", cla: "ColorAverageEffect", colordepth: "ColorDepthEffect", cd: "ColorDepthEffect", cde: "ColorDepthEffect", depth: "DepthEffect", d: "DepthEffect", de: "DepthEffect", depthoffield: "DepthOfFieldEffect", dof: "DepthOfFieldEffect", dofe: "DepthOfFieldEffect", dotscreen: "DotScreenEffect", ds: "DotScreenEffect", dse: "DotScreenEffect", gammacorrection: "GammaCorrectionEffect", gc: "GammaCorrectionEffect", gce: "GammaCorrectionEffect", glitch: "GlitchEffect", g: "GlitchEffect", ge: "GlitchEffect", godrays: "GodRaysEffect", gr: "GodRaysEffect", gre: "GodRaysEffect", grid: "GridEffect", huesaturation: "HueSaturationEffect", hs: "HueSaturationEffect", hse: "HueSaturationEffect", noise: "NoiseEffect", n: "NoiseEffect", ne: "NoiseEffect", outline: "OutlineEffect", o: "OutlineEffect", ol: "OutlineEffect", oe: "OutlineEffect", pixelation: "PixelationEffect", p: "PixelationEffect", px: "PixelationEffect", pe: "PixelationEffect", realisticbokeh: "RealisticBokehEffect", rb: "RealisticBokehEffect", rbe: "RealisticBokehEffect", smaa: "SMAAEffect", smaae: "SMAAEffect", ssao: "SSAOEffect", ssaoe: "SSAOEffect", scanline: "ScanlineEffect", s: "ScanlineEffect", se: "ScanlineEffect", selectivebloom: "SelectiveBloomEffect", sb: "SelectiveBloomEffect", sbe: "SelectiveBloomEffect", sepia: "SepiaEffect", shockwave: "ShockWaveEffect", sw: "ShockWaveEffect", swe: "ShockWaveEffect", texture: "TextureEffect", t: "TextureEffect", te: "TextureEffect", tonemapping: "ToneMappingEffect", tm: "ToneMappingEffect", tme: "ToneMappingEffect", vignette: "VignetteEffect", v: "VignetteEffect", ve: "VignetteEffect"
    }
};
export default ComposerEffects;
export { ComposerEffects };