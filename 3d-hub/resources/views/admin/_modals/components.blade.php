


<div class="modal fade component-modal" id="component-modal" tabindex="-1" role="dialog" aria-labelledby="component-modal-title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header custom-style bg-info">
                <h5 class="modal-title" id="component-modal-title">
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
                                    {{get_active_theme()->name}}
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <div class="input-group">
                                <input type="search" id="search-component--input" name="keyword" class="form-control" placeholder="Tìm kiếm...">
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
                            <div class="Theme-component-list">

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-select-icon">Chọn</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                
            </div>
        </div>
    </div>
</div>


