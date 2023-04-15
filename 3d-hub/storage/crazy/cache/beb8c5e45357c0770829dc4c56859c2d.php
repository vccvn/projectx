<?php
return [
    "title" => [
        "type" => "text",
        "label" => "Tiêu đề",
        "placeholder" => "Nhập tiêu đề",
        "required" => "true"
    ],
    "slug" => [
        "type" => "text",
        "label" => "Đường dẫn (slug)",
        "placeholder" => "Nhập đường dẫn",
        "template" => "crazyslug",
        "@check-field" => "custom_slug",
        "@extension" => ".html",
        "@get-check-slug-url" => "admin_dynamic_url",
        "@get-check-slug-url-params" => [
            "check-slug"
        ],
        "@get-get-slug-url" => "admin_dynamic_url",
        "@get-get-slug-url-params" => [
            "get-slug"
        ],
        "@source-id" => "title",
        "@ajax-param-selectors" => "#input-hidden-id",
        "@ajax-check-name" => "slug",
        "@ajax-get-name" => "slug"
    ],
    "custom_slug" => [
        "type" => "checkbox",
        "label" => "Tùy chọn slug",
        "check_label" => "Tùy chỉnh",
        "@hidden" => true
    ],
    "category_id" => [
        "type" => "crazyselect",
        "label" => "Danh mục",
        "required" => "true",
        "template" => "crazyselect",
        "call" => "App\\Repositories\\Posts\\CategoryRepository::getCategorySelectOptions",
        "option_label_type" => "label"
    ],
    "content" => [
        "type" => "textarea",
        "label" => "Nội dung",
        "placeholder" => "Nhập nội dung",
        "className" => "tiny-mce",
        "template" => "tinymce",
        "height" => 450
    ],
    "content_type" => [
        "type" => "crazyselect",
        "label" => "Nội dung mở rộng",
        "required" => "true",
        "data" => [
            "text" => "Không (Chỉ văn bản)",
            "gallery" => "Bộ sưu tập ảnh",
            "video_embed" => "Nhúng video",
            "news" => "Nguồn tin bài"
        ],
        "default" => "text",
        "@change" => "Crazy.posts.form.changePostType"
    ],
    "gallery" => [
        "type" => "file",
        "label" => "Thư viện ảnh",
        "template" => "gallery",
        "call" => "get_client_file_uploads",
        "params" => [
            [
                "ref" => "post",
                "ref_id" => "#hidden_id"
            ]
        ]
    ],
    "feature_image" => [
        "type" => "file",
        "label" => "Hình xem trước",
        "template" => "cropit",
        "data-width" => 414,
        "data-height" => 276
    ],
    "description" => [
        "type" => "textarea",
        "label" => "Mô tả",
        "placeholder" => "Nhập mô tả"
    ],
    "meta_title" => [
        "type" => "text",
        "label" => "Meta Title",
        "placeholder" => "Nhập meta title"
    ],
    "meta_description" => [
        "type" => "textarea",
        "label" => "Meta Description",
        "placeholder" => "Nhập meta description",
        "row" => 4
    ],
    "keywords" => [
        "type" => "text",
        "label" => "Từ khóa",
        "placeholder" => "Từ khóa"
    ],
    "tags" => [
        "type" => "crazytag",
        "label" => "Thẻ",
        "placeholder" => "Nhập thẻ...",
        "template" => "crazytag",
        "@type" => "dynamic",
        "@search-route" => "admin.tags.data",
        "@create-route" => "admin.tags.create",
        "@create-field" => "tags",
        "call" => "get_input_tag_data",
        "params" => [
            "post", "#hidden_id", [
                "id" => ":defval"
            ]
        ]
    ],
    "privacy" => [
        "type" => "radio",
        "template" => "radio",
        "label" => "Riêng tư",
        "data" => [
            "public" => "Công khai",
            "private" => "Không công khai"
        ],
        "default" => "public",
        "@options" => [
            "form_group_class" => "row",
            "label_class" => "col-12 col-lg-3 col-xl-2 col-form-label",
            "wrapper_class" => "col-12 col-lg-9 col-xl-10"
        ]
    ],
    "source" => [
        "type" => "text",
        "label" => "Nguồn",
        "placeholder" => "Nhập nguồn. ví dụ: http://dantri.com.vn/bai-viet/abc.html"
    ],
    "video_url" => [
        "type" => "text",
        "template" => "videopreview",
        "label" => "Đường dẫn video",
        "placeholder" => "Nhập Đường dẫn video. ví dụ: https://www.youtube.com/watch?v=ABcD123",
        "required" => "true"
    ]
];