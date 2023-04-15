


        <section id="contact" class="contact-us-section bg-light ptb-100">
            <div class="contact-us-wrap">
                <div class="container">
                    <div class="headingOne text-center">
                        {{-- <h6 class="sub">{{$data->sub_title('Reach Us Quickly')}}</h6> --}}
                        <h2>{{$data->title('Contact Us')}}</h2>
                    </div>
                    
                    <div class="contact-us-content">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="footer-address mb-20">
                                    <ul>
                                        <li class="icolor-1"><i class="fa fa-map-marker"></i> <span>{{$siteinfo->address}}</span>
                                        </li>
                                        <li class="icolor-3"><i class="fa fa-phone"></i>
                                            <span>Điện thoại: <a href="tel:{{$phone = $siteinfo->phone_number('094.578.6960')}}">{{$phone}}</a></span></li>

                                        <li class="icolor-2"><i class="fa fa-envelope"></i> <span>Email : <a
                                                href="mailto:{{$email = $siteinfo->email('doanln.chinhlatoi@gmail.com')}}">{{$email = $siteinfo->email('doanln.chinhlatoi@gmail.com')}}</a></span>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <form id="contactForm1" method="POST" action="{{route('client.contacts.send')}}" data-ajax-url="{{route('client.contacts.ajax-send')}}" class="{{parse_classname('contact-form1')}}">
                                    @csrf
                                    <input type="hidden" name="response_type" value="text">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input id="name" name="name" type="text" class="form-control" required="" placeholder="Your name / Họ và tên">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input id="email1" name="email" type="email" class="form-control" required="" placeholder="Your email / Địa chỉ e-mail">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input id="phone" name="phone_number" type="tel" class="form-control" placeholder="Your phone / Số điện thoại">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <textarea id="message1" name="message" class="form-control" rows="4" placeholder="Message / Nội dung"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="biz-btn-solid">{{$data->button_text('Send message')}}</button>
                                    </div>
                                </form>
                                <p class="form-message"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>