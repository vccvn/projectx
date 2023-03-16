

            <div class="form-block">
                <div class="form-group row">
                    <div class="col-9 col-sm-7 col-md-6 mb-1">
                        <div class="custom-file">
                            <input type="file" name="{{$file_input_name??'backup_file'}}" class="custom-file-input backup-file" id="{{$file_input_name??'backup_file'}}" accept="*.json,*.xlsx">
                            <label class="custom-file-label" for="{{$file_input_name??'backup_file'}}">Chọn file...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                    </div>
                    
                    <div class="col-3 col-sm-2 col-md-3 mb-1">
                        <button class="btn btn-primary btn-check-backup">Kiểm tra</button>
                    </div>
                </div>
                
            
            </div>
            <div class="mb-2">Check Time: <strong class="check-time">{{$check_time??''}}</strong></div>