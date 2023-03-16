<?php
add_js_src('static/manager/js/dropzone.gallery.js');
add_css_link('static/manager/css/dropzone.gallery.min.css');
?>

    <div class="modal fade gallery-modal" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="gallery-modal-title">
        <div class="modal-dialog" role="document">
            <div class="modal-content">



                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <i class="fa fa-file-image mr-3"></i>
                                    Quản lý file
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#my_photos_tab_content" role="tab">
                                        <i class="fa fa-images"></i>
                                        Ảnh của tôi
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#upload_file_tab_content" role="tab">
                                        <i class="fa fa-cloud-upload-alt text-info"></i> Tải lên 
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body gallery-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="my_photos_tab_content" role="tabpanel">
                                <div class="m-form m-form--fit m-form--label-align-right dropdown-gallery-block mb-3" style="display: none">
                        
                                </div>
            
                                <div class="message pt-5 pb-5 mb-5 mt-5" style="display: none">
                                    Không có kết quã
                                </div>
                                <div class="results" style="display: none">
                                    {{-- <h3></h3> --}}
                                    <div class="gallery-images">
            
                                    </div>
                                    <div class="buttons mt-3 text-center">
                                        <button type="button" class="btn-see-more btn m-btn--pill m-btn--air btn-outline-accent m-btn m-btn--custom">Xem thêm <span class="fa fa-cloud-download-alt"></span></button>
                                    </div>
                                </div>
            
                                <textarea class="template d-none">
                                    <div class="dz-preview dz-processing dz-image-preview" data-src="{$url}" data-filename="{$original_filename}" id="gallery-image-item-{$id}">
                                        <div class="dz-image">
                                            <img data-dz-thumbnail="" alt="{$original_filename}" src="{$thumbnail}">
                                        </div>
                                        <div class="dz-details">
                                            <div class="dz-size"><span data-dz-size=""><strong>{$size}</strong> {$size_unit}</span></div>
                                            <div class="dz-filename">
                                                <span data-dz-name="">{$original_filename}</span>
                                            </div>
                                        </div>
                                        {{-- <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span></div> --}}
                                        {{-- <div class="dz-error-message"><span data-dz-errormessage=""></span></div> --}}
                                        <div class="dz-success-mark">
                                            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                <title>Check</title>
                                                <defs></defs>
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                    <path
                                                        d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                        id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475"
                                                        fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        {{-- <div class="dz-error-mark">
                                            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                <title>Error</title>
                                                <defs></defs>
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158"
                                                        fill="#FFFFFF" fill-opacity="0.816519475">
                                                        <path
                                                            d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                            id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div> --}}
                                        <a class="dz-remove btn-remove-image-file" data-id="{$id}" href="javascript:undefined;">
                                            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                <title>Xóa</title>
                                                <defs></defs>
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158"
                                                        fill="#FFFFFF" fill-opacity="0.816519475">
                                                        <path
                                                            d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                            id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                
                                </textarea>
            
                                <div class="loading text-center mt-5 mb-5 pt-5 pb-5">
                                    <span>Đang tải</span><div class="m-loader m-loader--danger" style="width: 30px; display: inline-block;"></div>
                                </div>
                                
                                <div class="footer-buttons">
                                    <button type="button" class="btn btn-info btn-insert-images">Chèn ảnh</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                            <div class="tab-pane" id="upload_file_tab_content" role="tabpanel">
                                <div class="upload-block">
                                    <form class="m-dropzone m-dropzone--primary dropzone-gallery" action="{{route($route_name_prefix.'files.images.dz-upload')}}" id="dropzone-gallery">
                                        @csrf
                                        <div class="m-dropzone__msg dz-message needsclick">
                                            <h3 class="m-dropzone__msg-title">Kéo và thả file vào đây hoặc click để chọn file tải lên</h3>
                                            <span class="m-dropzone__msg-desc">Tối đa 50 file</span>
                                        </div>
                                    </form>
                                </div>
                                <div class="footer-buttons">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                
            </div>
        </div>
    </div>