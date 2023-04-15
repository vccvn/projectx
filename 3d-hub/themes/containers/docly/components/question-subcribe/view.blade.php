<article class="help_text" id="help">
    <div class="row question_box">
        <div class="col-lg-6">
            <div class="question_text">
                <h4>{{$data->question_title}}</h4>
                <p>
                    {!!
                        $data->question_description
                    !!}
                </p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="question_text question_text_two">
                <h4>{{$data->subcribe_title}}</h4>
                <p>
                    {!!
                        $data->subcribe_description
                    !!}
                </p>
                <form method="post" action="{{route('client.subcribe')}}" class="{{parse_classname('subcribe-form')}} signup_form">
                    <div class="input-group">
                        <input type="text" class="form-control memail" placeholder="Email">
                        <div class="input-group-append">
                            <button type="submit">Đăng ký</button>
                        </div>
                    </div>
                    <p class="mchimp-errmessage" style="display: none;"></p>
                    <p class="mchimp-sucmessage" style="display: none;"></p>
                </form>
                <p>Bạn có thể bỏ theo dõi bất cứ lúc nào. Đọc chính sách bảo mật của chúng tôi tại <a href="{{$data->policy_link}}">đây</a></p>
            </div>
        </div>
    </div>
</article>