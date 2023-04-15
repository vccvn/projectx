$(function(){
    if(!App) App = {};
    if(!App.colorpicker) App.colorpicker = (function(){
        var ColorPicker = function(){
            var $input = null;
            var $colors = [
                ['000000', '111111', '2d2d2d', '434343', '5b5b5b', '737373', '8b8b8b', 'a2a2a2', 'b9b9b9', 'd0d0d0', 'e6e6e6', 'ffffff'],
                ['7f7f00', 'bfbf00', 'ffff00', 'ffff40', 'ffff80', 'ffffbf', '525330', '898a49', 'aea945', 'c3be71', 'e0dcaa', 'fcfae1'],
                ['407f00', '60bf00', '80ff00', 'a0ff40', 'c0ff80', 'dfffbf', '3b5738', '668f5a', '7f9757', '8a9b55', 'b7c296', 'e6ebd5'],
                ['007f40', '00bf60', '00ff80', '40ffa0', '80ffc0', 'bfffdf', '033d21', '438059', '7fa37c', '8dae94', 'acc6b5', 'ddebe2'],
                ['007f7f', '00bfbf', '00ffff', '40ffff', '80ffff', 'bfffff', '033d3d', '347d7e', '609a9f', '96bdc4', 'b5d1d7', 'e2f1f4'],
                ['00407f', '0060bf', '0080ff', '40a0ff', '80c0ff', 'bfdfff', '1b2c48', '385376', '57708f', '7792ac', 'a8bed1', 'deebf6'],
                ['00007f', '0000bf', '0000ff', '4040ff', '8080ff', 'bfbfff', '212143', '373e68', '444f75', '585e82', '8687a4', 'd2d1e1'],
                ['40007f', '6000bf', '8000ff', 'a040ff', 'c080ff', 'dfbfff', '302449', '54466f', '655a7f', '726284', '9e8fa9', 'dcd1df'],
                ['7f007f', 'bf00bf', 'ff00ff', 'ff40ff', 'ff80ff', 'ffbfff', '4a234a', '794a72', '936386', '9d7292', 'c0a0b6', 'ecdae5'],
                ['7f003f', 'bf005f', 'ff007f', 'ff409f', 'ff80bf', 'ffbfdf', '451528', '823857', 'a94a76', 'bc6f95', 'd8a5bb', 'f7dde9'],
                ['800000', 'c00000', 'ff0000', 'ff4040', 'ff8080', 'ffc0c0', '441415', '82393c', 'aa4d4e', 'bc6e6e', 'd8a3a4', 'f8dddd'],
                ['7f3f00', 'bf5f00', 'ff7f00', 'ff9f40', 'ffbf80', 'ffdfbf', '482c1b', '855a40', 'b27c51', 'c49b71', 'e1c4a8', 'fdeee0']
            ];
            var $color2 = [
                ["800000","8B0000","A52A2A","B22222","DC143C","FF0000","FF6347","FF7F50","CD5C5C","F08080","E9967A","FA8072"],
                ["FFA07A","FF4500","FF8C00","FFA500","FFD700","B8860B","DAA520","EEE8AA","BDB76B","F0E68C","808000","FFFF00"],
                ["9ACD32","556B2F","6B8E23","7CFC00","7FFF00","ADFF2F","006400","008000","228B22","00FF00","32CD32","90EE90"],
                ["98FB98","8FBC8F","00FA9A","00FF7F","2E8B57","66CDAA","3CB371","20B2AA","2F4F4F","008080","008B8B","00FFFF"],
                ["00FFFF","E0FFFF","00CED1","40E0D0","48D1CC","AFEEEE","7FFFD4","B0E0E6","5F9EA0","4682B4","6495ED","00BFFF"],
                ["1E90FF","ADD8E6","87CEEB","87CEFA","191970","000080","00008B","0000CD","0000FF","4169E1","8A2BE2","4B0082"],
                ["483D8B","6A5ACD","7B68EE","9370DB","8B008B","9400D3","9932CC","BA55D3","800080","D8BFD8","DDA0DD","EE82EE"],
                ["FF00FF","DA70D6","C71585","DB7093","FF1493","FF69B4","FFB6C1","FFC0CB","FAEBD7","F5F5DC","FFE4C4","FFEBCD"],
                ["F5DEB3","FFF8DC","FFFACD","FAFAD2","FFFFE0","8B4513","A0522D","D2691E","CD853F","F4A460","DEB887","D2B48C"],
                ["BC8F8F","FFE4B5","FFDEAD","FFDAB9","FFE4E1","FFF0F5","FAF0E6","FDF5E6","FFEFD5","FFF5EE","F5FFFA","708090"],
                ["778899","B0C4DE","E6E6FA","FFFAF0","F0F8FF","F8F8FF","F0FFF0","FFFFF0","F0FFFF","FFFAFA","000000","696969"],
                ["808080","A9A9A9","C0C0C0","D3D3D3","DCDCDC","F5F5F5","FFFFFF","855a40","b27c51","c49b71","e1c4a8","fdeee0"]
            ];
            var $imgSrc = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=";

            var $rgbColor = {
                r: 0,
                g: 0,
                b: 0
            };
            var $hexColor = "#000000";

            var $rgbInputs = {};
            var $hexInput = null;

            var $ChangeColorSelector = null;





            var componentToHex = function(c) {
                var hex = c.toString(16);
                return hex.length == 1 ? "0" + hex : hex;
            };
            var rgbToHex = function (r, g, b) {
                return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
            };

            var cutHex = function (h) {
                return h.length >= 6 ? ((h.charAt(0)=="#") ? h.substring(1,7):h) : (
                    (function (n){
                        return [n[0], n[0], n[1], n[1], n[2], n[2]].join("");
                    }((h.charAt(0)=="#") ? h.substring(1,4):h))
                );
            };
              
            var hexToR = function (h) {return parseInt((cutHex(h)).substring(0,2),16)}
            var hexToG = function (h) {return parseInt((cutHex(h)).substring(2,4),16)}
            var hexToB = function (h) {return parseInt((cutHex(h)).substring(4,6),16)}
            


            var setInput = function(input, ChangeColorSelector){
                $input = input;
                if(typeof ChangeColorSelector == "undefined" || !ChangeColorSelector) ChangeColorSelector = null;
                $ChangeColorSelector = ChangeColorSelector;
            };
            
            var createTable = function(id){
                var table = '<div class="color-picker color-table" id="'+id+'">';
                for (let i = 0; i < $colors.length; i++) {
                    const colorline = $color2[i];
                    table += '<div class="color-table-row row">';
                    for (let j = 0; j < colorline.length; j++) {
                        const hex = colorline[j];
                        table += '<div class="color-table-cell col-1 pl-0 pr-0" style="background:#'+hex+'">'
                            + '<a href="javascript:void(0)" class="color-item" data-color="'+hex+'">'
                                + '<img src="'+$imgSrc+'" class="color-mask-image">'
                            + '</a>'
                        + '</div>';
                    }
                    table += '</div>';
                }
                table += '</div>';
                return table;
            };

            var self = this;

            var setRgbColor = function(r, g, b){
                $hexColor = rgbToHex(r, g, b);
                $rgbColor = {
                    r: r,
                    g: g,
                    b: b
                };
            };

            this.getRgb = function(){
                return $rgbColor;
            };

            this.getHex = function(){
                return $hexColor;
            };

            this.getRGBInputValue = function(key){
                var value = 0;
                if($rgbInputs[key]) value = parseInt($rgbInputs[key].value);
                return value;
            };

            this.updateRGBInputValue = function (key, value){
                if($rgbInputs[key]) $rgbInputs[key].value = parseInt(value);
                return this; 
            }
            this.updateRGBInputs = function(r,g,b){
                return this.updateRGBInputValue('r', r).updateRGBInputValue('g',g).updateRGBInputValue('b', b);
            }

            this.onChangeInputValue = function(value, el){
                var ref = el.getAttribute('data-ref');
                this.updateRGBInputValue(ref, value);
            }

            this.updateRangeInputValue = function () {
                var r = this.getRGBInputValue('r') || 0;
                var g = this.getRGBInputValue('g') || 0;
                var b = this.getRGBInputValue('b') || 0;
                if(r == $rgbColor.r && g == $rgbColor.g && b == $rgbColor.b) return this;
                setRgbColor(r,g,b);
                this.updatePreviewBackground();
                this.updateHexPreview();
            }

            this.updatePreviewBackground = function(){
                $('.color-preview-background').css('background', $hexColor);
            };
            this.updateHexPreview = function(){
                if($hexInput && $hexInput.value != $hexColor){
                    $hexInput.value = $hexColor;
                }
            };
            this.updateRgbSlider = function () {
                var r = document.getElementById('color-picker-r-nouislider'),
                    g = document.getElementById('color-picker-g-nouislider'),
                    b = document.getElementById('color-picker-b-nouislider');
                var rc = $rgbColor.r,
                    gc = $rgbColor.g,
                    bc = $rgbColor.b;
                    cl(rgbToHex(rc, gc, bc))
                if(r) r.noUiSlider.set(rc);
                if(g) g.noUiSlider.set(gc);
                if(b) b.noUiSlider.set(bc);
            }

            this.updateAllData = function(){
                self.updatePreviewBackground();
                self.updateHexPreview();
                setTimeout(function(){
                    self.updateRgbSlider();
                }, 100);
            };

            this.setColor = function (color){
                if(typeof color == "object"){
                    var r = parseInt(color.r || color.r || 0);
                    var g = parseInt(color.g || color.g || 0);
                    var b = parseInt(color.b || color.b || 0);
                    $hexColor = rgbToHex(r, g, b);
                    $rgbColor = {
                        r: r,
                        g: g,
                        b: b
                    };
                    this.updateRGBInputs(r, g, b);
                }else{
                    var r = hexToR(color);
                    var g = hexToG(color);
                    var b = hexToB(color);
                    $hexColor = color.charAt(0) == "#" ? color: "#"+color;
                    $rgbColor = {
                        r: r,
                        g: g,
                        b: b
                    };
                    this.updateRGBInputs(r, g, b);
                    
                }
                return this;
            }

            this.showTable = function (input) {
                $input = input;
                var table = createTable(App.str.rand());
                App.modal.custom({
                    title: "Chọn màu",
                    size: "color-picker",
                    content: table
                });
            };

            this.hideTable = function(){
                $('.color-picker.color-table').remove();
                App.modal.hide('custom-modal');
            };



            this.showColorPicker = function(input, ChangeColorSelector){
                if(!input) return this;
                setInput(input, ChangeColorSelector);
                if(input){
                    if(input.value){
                        self.setColor(input.value);
                    }else{
                        self.setColor("#FFFFFF");
                    }
                }else{
                    self.setColor("#FFFFFF");
                }
                App.modal.show("coior-picker-modal", null, function () {
                    self.reset();
                    cl(App.modal.last_open);
                    if(App.modal.last_open != "coior-picker-modal"){
                        App.modal.show(App.modal.last_open);
                    }
                });
            }
            this.init = function(){
                $rgbInputs = {
                    r: document.getElementById('color-picker-r-input'),
                    g: document.getElementById('color-picker-g-input'),
                    b: document.getElementById('color-picker-b-input')
                };
                var hextInput = document.getElementById('color-picker-hex-input');
                if(hextInput){
                    $hexInput = hextInput;
                    hextInput.addEventListener('change', function(){
                        if(this.value != $hexColor){
                            self.setColor(this.value);
                            self.updateAllData();
                        }
                    })
                }

                document.getElementById('color-picker-select-color-btn').addEventListener('click', function(){
                    if($input) {
                        $input.value = $hexColor;
                        $($input).css({
                            boderColor: $hexColor
                        });
                    }

                    if($ChangeColorSelector){
                        $($ChangeColorSelector).css('color', $hexColor);
                    }
                    App.modal.hide();
                });
                $(document).on('click', '.color-picker-btn', function(e){
                    var $el = $(this);
                    var inp = document.getElementById($el.data('input-id'));
                    // self.showTable(inp);
                    self.showColorPicker(inp, $el.data('change-color-selector'));
                    self.updateAllData();
                });

                
            };
            this.reset = function(){
                $input = null;
                $ChangeColorSelector = null;
                if($hexInput) $hexInput.value = '#fff';
                $hexColor = '#fff';
                $rgbColor = {
                    r: 255,
                    g: 255,
                    b: 255
                };
                
                self.updateAllData();
                
            }
        };

        var colorpicker = new ColorPicker();
        colorpicker.init();



        return colorpicker;
    }());
});