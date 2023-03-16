

<div class="modal fade team-modal" id="team-modal" tabindex="-1" role="dialog" aria-labelledby="team-modal-title">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header custom-style bg-info">
                <h5 class="modal-title" id="team-modal-title">
                    <i class="fa fa-user-friends"></i>
                    <span>Nhóm</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-4 col-lg-3 col-form-label">Trưởng nhóm</label>
                    <div class="col-md-8 col-lg-9">
                        <div id="team-leader-info" class="col-form-label"></div>
                    </div>
                </div>
                <div class="row crazy-list">
                    <label class="col-12 col-form-label">Các thành viên</label>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped header-center">
                                <thead>
                                    <tr>
                                        <th class="id-col text-center">Member ID</th>
                                        <th class="text-center">Avatar</th>
                                        <th class="min-160 text-center">Họ và tên</th>
                                        <th class="min-160 max-250 text-center">Email</th>
                                        <th class="min-100 text-center">Vị trí</th>
                                        <th class="min-100 actions">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="team-member-list">
                                    
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
                <textarea class="d-none member-item-template">
                    <tr id="member-item-{$id}" data-name="{$name}">
                        <td class="id-col text-center">{$id}</td>
                        <td class="text-center">
                            <img src="{$avatar}"class="image-thumbnail" alt="{$name}">
                        </td>
                        <td class="min-160 text-center">{$name}</td>
                        <td class="min-160 max-250 text-center">{$email}</td>
                        <td class="min-100 text-center">{$job}</td>
                        <td class="min-100 actions">
                            <a href="javascript:void(0);" data-id="{$id}" data-original-title="Sửa" data-toggle="m-tooltip" data-placement="left" title="" class="btn-edit-member text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                <i class="flaticon-edit-1"></i>
                            </a>
                            <a href="javascript:void(0);" data-id="{$id}" data-toggle="m-tooltip" data-placement="left" data-original-title="Xóa " class="btn-delete-member text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                <i class="flaticon-delete-1"></i>
                            </a>
                        </td>
                    </tr>
                </textarea>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-add-member">Thêm thành viên</button>
                <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
    

<div class="modal fade team-member-modal" id="team-member-modal" tabindex="-1" role="dialog" aria-labelledby="team-member-modal-title">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{route($route_name_prefix.'teams.members.save')}}" method="POST" id="add-team-member-form">
                <input type="hidden" name="id" value="" id="team-member-id">
                <input type="hidden" name="team_id" value="" id="team-id">
                <div class="modal-header custom-style bg-info">
                    <h5 class="modal-title" id="team-member-modal-title">
                        <i class="fa fa-info-circle"></i>
                        <span>Thêm thành viên</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Người dùng </label>
                        <div class="col-md-8 col-lg-9">
                            @include($_base.'forms.templates.crazyselect', [
                                'input' => html_input([
                                    "type" => "crazyselect",
                                    "label" => 'Người dùng',
                                    'name' => 'member_id',
                                    'id' => 'member_id',
                                    "call" => "get_staff_options",
                                    "params" => [[], "Người dùng"],
                                    "@select-type" => "search",
                                    "@search-route" => $route_name_prefix."users.select-option"
                                ])
                            ])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label" for="team-member-job">Vị trí</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" name="job" id="team-member-job" class="form-control m-input" placeholder="Vị trí trong team, công việc">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label" for="team-leader">Nhóm trưởng</label>
                        <div class="col-md-8 col-lg-9">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--info">
                                <input type="checkbox" class="crazy-checkbox" name="is_leader" id="team-leader"> 
                                Có
                                <span></span>
                            </label>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info done-btn" id="member-btn-submit">Thêm</button>
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
    