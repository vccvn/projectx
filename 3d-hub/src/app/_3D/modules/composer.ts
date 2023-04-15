import { isArray, isEmpty, isObject, Str } from '@app/_core/helpers/utils';
import createClass, { _class } from '@app/_core/helpers/es5.class';
import * as THREE from 'three';

import ComposerEffects from '../libs/composer.effects';


import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass.js';
import { TexturePass } from 'three/examples/jsm/postprocessing/TexturePass.js';
import { CubeTexturePass } from 'three/examples/jsm/postprocessing/CubeTexturePass.js';
import { ShaderPass } from 'three/examples/jsm/postprocessing/ShaderPass.js';
import { ClearPass } from 'three/examples/jsm/postprocessing/ClearPass.js';
import { CopyShader } from 'three/examples/jsm/shaders/CopyShader.js';


import { GUI } from 'three/examples/jsm/libs/dat.gui.module.js';

const params = {

    clearPass: true,
    clearColor: 'white',
    clearAlpha: 1.0,

    texturePass: true,
    texturePassOpacity: 1.0,
    texturePass2: true,
    texturePass2Opacity: 1.0,

    cubeTexturePass: true,
    cubeTexturePassOpacity: 1.0,

    renderPass: true
};


const Composer = _class('Composer').uses(ComposerEffects)({
    /**
     * @var {App}
     */
    parent: null,
    options: {},
    renderPass: null,
    /**
     * 
     * @param {App} parent doi tuong xha
     * @param {object} options thiết lập
     */
    constructor: function (parent, options) {
        this.parent = parent;
        this.renderer = parent.renderer;
        this.scene = parent.scene;
        this.camera = parent.camera;
        const clock = new THREE.Clock();
        this.clock = clock;
        if (isObject(options)) {
            this.options = options;
        }
        this.setup();
    },
    setup: function () {
        this.composer = new EffectComposer(this.renderer);
        this.renderPass = new RenderPass(this.scene, this.camera);
        this.composer.addPass(this.renderPass);

        if (isObject(this.options.effects)) {
            for (const key in this.options.effects) {
                if (this.options.effects.hasOwnProperty(key)) {
                    const opt = this.options.effects[key];
                    if (!isObject(opt)) {
                        continue;
                    } else {
                        if (!isObject(opt.params) && !opt.type) {
                            this.addEffect(key, opt);
                        } else if (!opt.type) {
                            this.addEffect(key, opt.params || opt.options || opt.effectOptions || opt.effectParams || opt);
                        }
                    }
                }
            }
        }
        else if (isArray(this.options.effects)) {
            for (let index = 0; index < this.options.effects.length; index++) {
                const effect = this.options.effects[index];
                if (!isObject(effect)) continue;
                else {
                    var type = effect.type || effect.effect || effect.effect_type;
                    var options = effect.params || effect.options || effect.effect_options;
                    if (type) {
                        this.addEffect(type, options);
                    }
                }
            }
        } else if (this.options.effect) {
            this.addEffect(
                this.options.effect, isObject(options) ? this.options.effectOptions :
                isObject(this.options.effect_options) ? this.options.effect_options :
                    isObject(this.options.params) ? this.options.params :
                        isObject(this.options.options) ? this.options.options : {}
            );
        }

        if (this.options.pass) {
            this.addPass();
        }
    },
    render: function () {
        this.composer.render(this.clock.getDelta());
    },

    addPass: function (pass, options) {
        var self = this;
        let clearPass, texturePass, texturePass2;
        let cubeTexturePassP;
        let gui, stats;

        const genCubeUrls = function (prefix, postfix) {

            return [
                prefix + 'px' + postfix, prefix + 'nx' + postfix,
                prefix + 'py' + postfix, prefix + 'ny' + postfix,
                prefix + 'pz' + postfix, prefix + 'nz' + postfix
            ];

        };
        // clearPass = new ClearPass(params.clearColor, params.clearAlpha);
        // self.composer.addPass(clearPass);



    }
});

export default Composer;

export { Composer };