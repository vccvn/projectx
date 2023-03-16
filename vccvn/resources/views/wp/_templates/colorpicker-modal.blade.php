<?php
add_js_src('static/crazy/js/colorpicker.js');
?>


    <div class="modal fade coior-picker-modal" id="coior-picker-modal" tabindex="-1" role="dialog" aria-labelledby="coior-picker-modal-title">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header custom-style bg-info">
                    <h5 class="modal-title" id="coior-picker-modal-title">
                        <i class="fa fa-paint-brush"></i>
                        Chọn màu
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="color-picker-section">
                        <div class="row">
                            <div class="col-md-3 show-color-preview order-md-2">
                                <div class="color-preview-background">
                                    <img alt="color" class="image-color image-transparent" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=">
                                </div>
                                <div class="hex-preview">
                                    <label for="color-picker-hex-input">Hex</label>
                                    <input type="text" name="colorpucker[hex]" id="color-picker-hex-input" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-9 color-range-col order-md-1">
                                <h3 class="d-none d-md-block text-center mb-3">Phối màu</h3>
                                <div class="row red-range align-items-center">
                                    <label for="color-picker-r-input" class="col-2 col-md-1 col-form-label">R</label>
                                    <div class="col-7 col-sm-8 col-md-9">
                                        <div id="color-picker-r-nouislider" class="crazy-nouislider m-nouislider" data-input-id="color-picker-r-input" data-start="0" data-step="1" data-min="0" data-max="255" data-on-change="App.colorpicker.updateRangeInputValue"></div>
                                    </div>
                                    <div class="col-3 col-sm-2">
                                        <input type="number" name="colorpucker[r]" id="color-picker-r-input" class="form-control range-input-number" data-ref="r" value="0" data-on-change="App.colorpicker.onChangeInputValue">
                                    </div>
                                </div>
                                <div class="row green-range align-items-center">
                                    <label for="color-picker-g-input" class="col-2 col-md-1 col-form-label">G</label>
                                    <div class="col-7 col-sm-8 col-md-9">
                                        <div id="color-picker-g-nouislider" class="crazy-nouislider m-nouislider" data-input-id="color-picker-g-input" data-start="0" data-step="1" data-min="0" data-max="255" data-on-change="App.colorpicker.updateRangeInputValue"></div>
                                    </div>
                                    <div class="col-3 col-sm-2">
                                        <input type="number" name="colorpucker[g]" id="color-picker-g-input" class="form-control range-input-number" data-ref="g" value="0" data-on-change="App.colorpicker.onChangeInputValue">
                                    </div>
                                </div>
                                <div class="row blue-range align-items-center">
                                    <label for="color-picker-b-input" class="col-2 col-md-1 col-form-label">B</label>
                                    <div class="col-7 col-sm-8 col-md-9">
                                        <div id="color-picker-b-nouislider" class="crazy-nouislider m-nouislider" data-input-id="color-picker-b-input" data-start="0" data-step="1" data-min="0" data-max="255" data-on-change="App.colorpicker.updateRangeInputValue"></div>
                                    </div>
                                    <div class="col-3 col-sm-2">
                                        <input type="number" name="colorpucker[b]" id="color-picker-b-input" class="form-control range-input-number" data-ref="b" value="0" data-on-change="App.colorpicker.onChangeInputValue">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-select-color" id="color-picker-select-color-btn">Chọn màu</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>


