

            <div class="form-block mb-2">
                <form action="" id="{{$form_id??'upload-form'}}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-12 col-sm-7 col-md-6">
                            <div class="custom-file">
                                <input type="file" name="{{$input_name??'backup_file'}}" class="custom-file-input" id="{{$input_name??'backup_file'}}" accept="*.json,*.xlsx">
                                <label class="custom-file-label" for="{{$input_name??'backup_file'}}">Chọn file...</label>
                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-3 ">
                            <div class="input-group">
                                <input type="text" name="check_date" id="date-range" class="form-control date-picker" placeholder="Ngày tháng" data-format="yy-mm-dd" value="{{date('Y-m-d')}}" autocomplete="off">
                                <div class="input-group-append">
                                    <label for="date-range" class="mt-0 input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-sm-2 col-md-3">
                            <button type="submit" class="btn btn-primary">Kiểm tra</button>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="mb-2">Check Time: <strong id="check-time"></strong> </div>