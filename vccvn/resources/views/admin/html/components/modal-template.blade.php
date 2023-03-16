<div class="nesttable-template d-none">
    <span class="component-name">{$name}</span>
</div>
<div class="item-action-template d-none">
    <div class="item-actions component-action-{$id}">
        <a href="javascript:void(0);" class="edit btn-edit-item" data-id="{$id}" data-area-id="{$area_id}">
            <i class="fa fa-pencil-alt"></i>
        </a>
        <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{$id}" data-area-id="{$area_id}" data-name="{$name}">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</div>



<div class="modal fade component-modal" id="component-modal" tabindex="-1" role="dialog" aria-labelledby="component-modal-title">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="" method="get" id="component-form">
                <input type="hidden" name="area_id" value="" id="component-area-id">
                <input type="hidden" name="id" value="" id="component-html-id">
                <div class="modal-header custom-style bg-info">
                    <h5 class="modal-title" id="component-modal-title">
                        <i class="fa fa-puzzle-piece"></i>
                        <span>Thêm commponent</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="component_id" id="component_id">
                    <div class="componnent-data-input">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Thêm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Xong</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade component-select-modal" id="component-select-modal" tabindex="-1" role="dialog" aria-labelledby="component-select-modal-title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header custom-style bg-info">
                <h5 class="modal-title" id="component-select-modal-title">
                    <i class="fa fa-crow"></i>
                     Component
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="m-portlet m-portlet--tabs mb-0">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#theme_tab_content" role="tab">
                                    Giao diện
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#system_tab_content" role="tab">
                                    Hệ thống
                                </a>
                            </li>
                            
                            
                            
                        </ul>
                    </div>
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <div class="input-group">
                                <input type="search" id="search-component-select-input" name="keyword" class="form-control" placeholder="Tìm kiếm...">
                                <div class="btn-append-group">
                                    <button class="btn btn-info btn-search-icon"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="theme_tab_content" role="tabpanel">
                            <div class="theme-component-list">

                            </div>
                        </div>
                        <div class="tab-pane" id="system_tab_content" role="tabpanel">
                            <div class="ststem-component-list">

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                
            </div>
        </div>
    </div>
</div>


