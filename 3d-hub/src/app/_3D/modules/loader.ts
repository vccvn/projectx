import { _class } from '@app/_core/helpers/es5.class';
import { LoaderLib } from '../libs/three.libs';

var Loader = _class('Loader').uses(LoaderLib)({

    /**
     * 
     * @param {App} parent 
     */

    constructor: function (parent:any=undefined) {
        this.setParent(parent);
    }
});

export default Loader;