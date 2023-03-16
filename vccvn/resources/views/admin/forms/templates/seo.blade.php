<?php
    add_js_src(asset('static/plugins/real-time-content-analysis/js/script.js'));
    add_css_link('static/plugins/real-time-content-analysis/css/style.build.min.css');
?>


<div class="custom-background theme-yoast-theme woocommerce-no-js has_paypal_express_checkout theme-home theme-academy">
    <section class="content">

        <div id="input" class="form-container">
            <div id="inputForm" class="inputForm">
                <label for="focusKeyword">Focus keyword</label>
                <input type="text" id="focusKeyword" name="focus_keyword" value="{{$input->parent->formData('focus_keyword')}}" placeholder="Chọn từ khóa tập chung (từ khóa chính)" />
            </div>
            {{-- <div id="inputForm" class="inputForm">
                        <label for="focusKeyword">Focus keyword</label>
                        <input type="text" id="focusKeyword" name="focus_keyword" placeholder="Chọn từ khóa tập chung (từ khóa chính)" />
                    </div> --}}
            <div id="snippetForm" class="snippetForm">
                <label>Snippet Preview</label>
                <div id="snippet" class="output">

                </div>
            </div>
        </div>
        <div id="output-container" class="output-container">
            <p>Đây là nội dung trang của bạn khi được hiển thị trên danh sách kết quả tìm kiếm của google.</p>

            <p>Click vào Meta Title hoặc meta Description để chỉnh sửa</p>
            {{-- <h2>Đánh giá tiêu đề, tóm tắt</h2> --}}
            <div id="output" class="output">

            </div>

            <h3>Đánh giá nội dung</h3>
            <div id="contentOutput" class="contentOutput">

            </div>
        </div>
    </section>




</div>
