

    <!-- Star Contact Area
    ============================================= -->
    <div class="contact-area default-padding">
        <div class="container">
            <div class="row">

                <!-- Start Faq -->
                <div class="col-md-6 faq-area">
                    <div class="heading">
                        <h2>{{$data->faq_title("Các câu hỏi thường gặp")}}</h2>
                    </div>
                    <div class="acd-items acd-arrow">
                        <div class="panel-group symb" id="accordion">


                            {!! $html->contact_faq->components !!}
                        </div>
                    </div>
                </div>
                <!-- End Faq -->

                <!-- Start Contact Info -->
                <div class="col-md-6 contact-forms">
                    <div class="contact-box">
                        <div class="icon">
                            <i class="ti-email"></i>
                        </div>
                        <h2>{{$data->title("Nếu bạn có ý tưởng hay thắc mắc gì ")}}</h2>
                        <p>
                            {{$data->description}}
                        </p>
                        <form method="POST" action="{{route('client.contacts.send')}}" data-ajax-url="{{route('client.contacts.ajax-send')}}" class="{{parse_classname('contact-form')}} contact-form1">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group">
                                        <input class="form-control inp" id="name" name="name" placeholder="Tên" type="text" required>
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control inp" id="email" name="email" placeholder="Email*" type="email">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control inp" id="phone_number" name="phone_number" placeholder="Số điễn thoại (Tùy chọn)" type="text">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group comments">
                                        <textarea class="form-control inp" id="comments" name="message" placeholder="Hãy nói về dự án của bạn...  *"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <button type="submit" name="submit" id="submit">
                                        Gửi <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Alert Message -->
                            <div class="col-md-12 alert-notification">
                                <div id="message" class="alert-msg"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Contact Info -->

            </div>
        </div>
    </div>
    <!-- End Contact Area -->