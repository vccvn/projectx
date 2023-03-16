@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'File Manager')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'File Manager')
@section('body.class', 'm-brand--minimize m-aside-left--minimize')
@section('css')
    <link rel="stylesheet" href="{{ asset('static/manager/assets/fi-icons/css-file-icons.css') }}">
    <style>
        thead tr th {
            font-weight: 600;
        }

        @media (max-width: 500px) {
            .hide-xs {
                display: none;
            }
        }

        .output-command {
            max-height: 400px;
            overflow-y: auto
        }

        ..output-command div {
            margin-bottom: 10px;
        }

    </style>
@endsection
@section('content')

    @php
    $pt = trim($path, '/');
    $download = route('filemanager.download');
    $fl = 0;
    $fll = ['app', 'database', 'config', 'bootstrap', 'resources', 'routes', 'artisan'];
    @endphp

    <div class="row">
        <div class="col-12 col-md-9">

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Đường dẫn: {{ $pt . '/' }}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item d-none" id="btn-terminal-li">
                                <a href="#" data-toggle="m-tooltip" data-placement="top" title data-original-title="Mở Terminal" class="ml-2 btn-show-terminal btn btn-outline-info m-btn btn-sm"><i class="fa fa-terminal"></i> <span class="d-none d-md-inline-block">Mở Terminal</span></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" data-toggle="m-tooltip" data-placement="top" title data-original-title="Thêm folder" class="ml-2 btn-make-dir btn btn-outline-warning m-btn btn-sm"><i class="fa fa-folder"></i> <span class="d-none d-md-inline-block">Tạo thư mục</span></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" data-toggle="m-tooltip" data-placement="top" title data-original-title="Thêm tệp" class="btn-new-file btn btn-outline-info m-btn btn-sm"><i class="fa fa-file"></i> <span class="d-none d-md-inline-block">Tạo file</span></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('filemanager.upload.form', ['p' => $path]) }}" data-toggle="m-tooltip" data-placement="top" title data-original-title="Tải lên" class="btn-upload-file btn btn-outline-success m-btn btn-sm"><i class="fa fa-upload"></i> <span class="d-none d-md-inline-block">Tải lên</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">


                    <!--begin::Section-->
                    <div class="m-section">
                        <div class="m-section__content crazy-list">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped list-center">
                                    <thead>
                                        <tr>
                                            <th class="text-center check-col">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                    <input type="checkbox" class="crazy-check-all">
                                                    <span></span>
                                                </label>
                                            </th>
                                            <th class=" check-col"></th>
                                            <th class="text-left">Tên file / thư mục</th>
                                            <th class="w-100">Permission</th>
                                            <th class="w-100">Dung lượng</th>
                                            <th class="hide-xs w-100">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            
                                            $rp = $pt ? $pt . '/' : '';
                                            $editor_support_types = get_editor_support_types();
                                        @endphp

                                        @if ($rp)
                                            @php
                                                $pp = explode('/', $pt);
                                                $a = array_pop($pp);
                                                $plv = implode('/', $pp);
                                            @endphp
                                            <tr class="" id="crazy-item-up" data-name="{{ $plv }}">
                                                <td class="text-center check-col">

                                                </td>
                                                <td class="text-center check-col">
                                                    <a href="{{ $r = route('filemanager', ['p' => $plv]) }}">
                                                        <div class="fi fi-zip fi-size-xs">
                                                            <div class="fi-content">
                                                                Dir
                                                            </div>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-left"><a href="{{ $r }}"><i class="fa fa-arrow-up"></i> ../</a></td>
                                                <td class="w-100"></td>
                                                <td class="w-100"></td>
                                                <td class="text-center w-100">
                                                </td>
                                            </tr>

                                        @endif
                                        @if (isset($list) && count($list))
                                            @foreach ($list as $item)
                                                @php
                                                    $fp = $rp . $item->name;
                                                    if (!$pt && in_array($item->name, $fll)) {
                                                        $fl++;
                                                    }
                                                @endphp
                                                <tr class="" id="crazy-item-{{ str_replace(' ', '-', $item->name) }}" data-name="{{ $item->name }}">
                                                    <td class="text-center check-col">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                            <input type="checkbox" name="ids[]" value="{{ $item->name }}" data-id="{{ $item->name }}" class="crazy-check-item">
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center check-col">
                                                        <a href="{{ $r = route('filemanager', ['p' => $rp . $item->name]) }}">
                                                            @if ($item->type == 'file')
                                                                <div class="fi fi-{{ $item->extension }} fi-size-xs">
                                                                    <div class="fi-content">
                                                                        {{ $item->extension }}
                                                                    </div>
                                                                </div>

                                                            @else
                                                                <div class="fi fi-zip fi-size-xs">
                                                                    <div class="fi-content">
                                                                        Fold
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td class="text-left">
                                                        <a href="{{ $r }}">{{ $item->name }}</a>

                                                        <a href="javascript:void(0);" class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="sr-only">Menu</span>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <h6 class="dropdown-header">Tuỳ chọn cho {{ $item->name }}</h6>
                                                            @if ($item->type == 'file')
                                                                @if (in_array($item->extension, $editor_support_types))
                                                                    <a href="{{ route('filemanager.editor') . '?p=' . $fp }}" title="Sửa" class="dropdown-item">
                                                                        <i class="flaticon-edit-1"></i> Chỉnh sửa
                                                                    </a>
                                                                @endif

                                                                @if ($item->extension == 'zip')
                                                                    <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="giải nén file zip" class="dropdown-item btn-unzip">
                                                                        <i class="flaticon-folder-1"></i> Giải nén
                                                                    </a>

                                                                @endif
                                                                <a title="Tải về" href="{{ $download . '?p=' . $pt . '/' . $item->name }}" class="dropdown-item">
                                                                    <i class="flaticon-download"></i> Tải về
                                                                </a>
                                                            @endif

                                                            <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="Di Chuyển vị trí" class="dropdown-item btn-rename">
                                                                <i class="flaticon-edit"></i> Đổi tên
                                                            </a>
                                                            <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="Di Chuyển vị trí" class="dropdown-item btn-move-item ">
                                                                <i class="flaticon-more-v4"></i> Di chuyển
                                                            </a>
                                                            <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="Xoá" class="dropdown-item btn-delete-item">
                                                                <i class="flaticon-delete-1"></i> Xoá
                                                            </a>

                                                        </div>
                                                    </td>
                                                    <td class="w-100 text-center">
                                                        {{ $item->mode }}
                                                    </td>
                                                    <td class="w-100 text-right">
                                                        {{ number_format($item->size_total, 2) . ' ' . $item->size_unit }}
                                                    </td>
                                                    
                                                    <td class="text-right hide-xs w-100">

                                                        @if ($item->type == 'file')
                                                            @if (in_array($item->extension, ['html', 'js', 'css', 'php', 'txt', 'json', 'jsx', 'ts', 'asp', 'aspx', 'xhtml', 'htm', 'less', 'sass', 'scss', 'py', 'env', 'htaccess', 'example']))
                                                                <a href="{{ route('filemanager.editor') . '?p=' . $fp }}" data-original-title="Sửa" data-toggle="m-tooltip" data-placement="left" title class="text-accent btn btn-outline-accent  btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                                    <i class="flaticon-edit-1"></i>
                                                                </a>
                                                            @endif

                                                            @if ($item->extension == 'zip')
                                                                <a href="javascript:void(0);" data-filename="{{ $item->name }}" data-toggle="m-tooltip" data-placement="left" title data-original-title="giải nén file zip" class="btn-unzip text-swarning btn btn-outline-warning btn-extract btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                                    <i class="flaticon-folder-1"></i>
                                                                </a>

                                                            @endif
                                                            {{-- <a data-toggle="m-tooltip" data-placement="left" data-original-title="Tải về" href="{{ $download . '?p=' . $pt . '/' . $item->name }}" class="text-success btn btn-outline-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                                <i class="flaticon-download"></i>
                                                            </a> --}}
                                                        @endif

                                                        <a href="javascript:void(0);" data-original-title="Tùy chọn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title class=" text-accent btn btn-outline-warning  btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                            <i class="flaticon-more-v2"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <h6 class="dropdown-header">Tuỳ chọn cho {{ $item->name }}</h6>
                                                            @if ($item->type == 'file')
                                                                @if (in_array($item->extension, $editor_support_types))
                                                                    <a href="{{ route('filemanager.editor') . '?p=' . $fp }}" title="Sửa" class="dropdown-item">
                                                                        <i class="flaticon-edit-1"></i> Chỉnh sửa
                                                                    </a>
                                                                @endif

                                                                @if ($item->extension == 'zip')
                                                                    <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="giải nén file zip" class="dropdown-item btn-unzip">
                                                                        <i class="flaticon-folder-1"></i> Giải nén
                                                                    </a>

                                                                @endif
                                                                <a title="Tải về" href="{{ $download . '?p=' . $pt . '/' . $item->name }}" class="dropdown-item">
                                                                    <i class="flaticon-download"></i> Tải về
                                                                </a>
                                                            @endif

                                                            <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="Di Chuyển vị trí" class="dropdown-item btn-rename">
                                                                <i class="flaticon-edit"></i> Đổi tên
                                                            </a>
                                                            <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="Di Chuyển vị trí" class="dropdown-item btn-move-item ">
                                                                <i class="flaticon-more-v4"></i> Di chuyển
                                                            </a>
                                                            <a href="javascript:void(0);" data-filename="{{ $item->name }}" title="Xoá" class="dropdown-item btn-delete-item">
                                                                <i class="flaticon-delete-1"></i> Xoá
                                                            </a>

                                                        </div>


                                            
            {{--                                                         

                                                        <a href="javascript:void(0);" data-filename="{{ $item->name }}" data-toggle="m-tooltip" data-placement="left" data-original-title="Đổi tên" class="text-info btn-rename btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                            <i class="flaticon-edit"></i>
                                                        </a>

                                                        <a href="javascript:void(0);" data-filename="{{ $item->name }}" data-toggle="m-tooltip" data-placement="left" data-original-title="Chuyển vị trí" class="btn-move-item text-primary btn btn-outline-primary btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                            <i class="flaticon-more-v4"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" data-filename="{{ $item->name }}" data-toggle="m-tooltip" data-placement="left" data-original-title="Xoá" class="btn-delete-item text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                            <i class="flaticon-delete-1"></i>
                                                        </a> --}}

                                                    </td>
                                                </tr>

                                            @endforeach
                                        @else

                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




                    <!--end::Section-->

                    @if (isset($list) && count($list))
                        <div class="list-toolbar">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chọn tất cả" class="crazy-btn-check-all text-success btn btn-outline-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="fa fa-check"></i>
                                    </a>

                                    <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chuyển tới (Move to)" class="btn-move-all text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-more-v4"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chuyển tất cả vào thùng rác" class="btn-delete-items text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-delete-1"></i>
                                    </a>


                                </div>
                                <div class="col-12 col-md-6 col-lg-8">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!--end::Portlet-->
        </div>
        <div class="col-12 col-md-3">

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Storage
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--begin::Section-->
                    <div class="m-section m-section--last">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <td>Dung lượng</td>
                                        <td class="text-right"><span>{{ $user->userWebSetting->storage_limited }} MB</span></td>
                                    </tr>
                                    <tr>
                                        <td>Đã sử dụng</td>
                                        <td class="text-right">
                                            <span class="storage-usage">NA</span>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--end::Section-->
                </div>
            </div>

            <!--end::Portlet-->

            @if (!$pt || $pt == 'public')

                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Tiện ích
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <!--begin::Section-->
                        <div class="m-section m-section--last">
                            <p>
                                <a href="#" data-toggle="m-tooltip" data-placement="top" title data-original-title="Cài WordPress Tiếng Việt" class="ml-2 btn-wp-vi btn btn-success m-btn btn-sm"><i class="fab fa-wordpress"></i> <span class="d-none d-md-inline-block">Cài WordPress Tiếng Việt</span></a>
                            </p>
                            <p>
                                <a href="#" data-toggle="m-tooltip" data-placement="top" title data-original-title="Cài WordPress Tiếng Anh" class="ml-2 btn-wp-en btn btn-info m-btn btn-sm"><i class="fab fa-wordpress"></i> <span class="d-none d-md-inline-block">Cài WordPress Tiếng Anh</span></a>
                            </p>
                            <p>
                                <a href="#" data-toggle="m-tooltip" data-placement="top" title data-original-title="Cài Laravel" class="ml-2 btn-laravel btn btn-danger m-btn btn-sm"><i class="fab fa-laravel"></i> <span class="d-none d-md-inline-block">Cài Laravel</span></a>
                            </p>

                        </div>

                        <!--end::Section-->
                    </div>
                </div>
            @endif
            <!--end::Portlet-->
        </div>
    </div>
    @php
    $commands = get_hosting_commands();
    @endphp
    @if (!$pt && $fl == count($fll))

        @php
            $options = [];
            foreach ($commands as $id => $pr) {
                $options[$id] = $pr[0];
            }
        @endphp

        <div class="modal fade command-modal" id="command-modal" tabindex="-1" role="dialog" aria-labelledby="command-modal-title">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header custom-style bg-info">
                        <h5 class="modal-title" id="command-modal-title">
                            <i class="fa fa-crow"></i>
                            Terminal
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="output-command">
                            <div>
                                {{ $user->email }} # /home
                            </div>
                        </div>
                        <form action="?" method="post" novalidate id="terminal-form">
                            <div class="input-group text input-text-group " id="input-commands">

                                <div class="input-group-prepend">
                                    @include('cpanel.forms.templates.crazyselect', [
                                    'input' => html_input([
                                    'type' => 'crazyselect',
                                    'name' => 'command',
                                    'data' => $options,
                                    'id' => 'command',
                                    '@change' => 'App.Commands.change'
                                    ])
                                    ])
                                </div>

                                <input type="text" name="parameters" id="parameters" class="form-control m-input" placeholder="Tham số">

                                <div class="input-group-apend">
                                    <button type="submit" class="btn btn-info btn-go">Go</button>
                                </div>



                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





    @endif

@endsection
@section('jsinit')
    <script>
        window.filemanagerInit = function() {
            App.FileManager.init({
                path: '{{ $path }}',
                urls: {
                    create: '{{ route('filemanager.items.create') }}',
                    move: '{{ route('filemanager.items.move') }}',
                    rename: '{{ route('filemanager.items.rename') }}',
                    unzip: '{{ route('filemanager.items.unzip') }}',
                    delete: '{{ route('filemanager.items.delete') }}',
                    download: '{{ route('filemanager.download') }}',
                    mkdir: '{{ route('filemanager.folders.make') }}',
                    install: '{{ route('filemanager.packages.install') }}',

                    editor: '{{ route('filemanager.editor') }}'


                }
            })
        };

        window.commandInit = function() {
            App.Commands.init({
                urls: {
                    command: '{{ route('filemanager.command') }}'
                },
                commands: @json($commands)
            })
        }
    </script>
@endsection

@section('js')
    <script src="{{ asset('static/crazy/js/items.js') }}"></script>
    <script src="{{ asset('static/crazy/js/filemanager.js') }}"></script>
    <script src="{{ asset('static/crazy/js/commands.js') }}"></script>
    <script>
        $(function() {
            App.api.get("{{ route('filemanager.folders.size') }}").then(function(rs) {
                if (rs.status) {
                    $('.storage-usage').html(rs.data.size + " " + rs.data.unit);
                }
            })
            @if (!$pt && $fl == count($fll))
            
                $('#btn-terminal-li').removeClass('d-none')
            
                // @endif



        });
    </script>
@endsection
