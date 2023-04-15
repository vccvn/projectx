@php
$cache_data_time = system_setting('cache_data_time', 0);
    if($cache_data_time){
        add_js_data('____crazy_cache', true);
    }else{
        add_js_data('____crazy_cache', false);
    }
@endphp

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    
    <script src="{{asset("static/app/js/app.min.js")}}"></script>

        <script>
            App.extend({
                laravel:{
                    urls: {!! 
                        json_encode([
                            'token' => route("client.token")
                        ]) 
                    !!},
                    cache: {{$cache_data_time?'true':'false'}}
                }
            })


        </script>
        
    @if ($data = get_js_data())
        <script>
            @foreach($data as $name => $value)
    
            var {{$name}} = @json($value);
    
            @endforeach

           
        </script>
    @endif

    @yield('jsinit')

    <script>

        window.csrfTokenInit = function () {
            App.csrf.init({
                urls: {!! 
                    json_encode([
                        'token' => route("client.token")
                    ]) 
                !!}
            });
        };
        window.subcribeInit = function () {
            App.subcribes.init({
                urls: {!! 
                    json_encode([
                        'subcribe' => route("client.ajax-subcribe")
                    ]) 
                !!}
            });
        };
        
        window.locationInit = function () {
                App.location.init({
                    urls: {!! 
                        json_encode([
                            'region_options' => route("client.location.regions.options"),
                            'district_options' => route("client.location.districts.options"),
                            'ward_options' => route("client.location.wards.options"),
                        ]) 
                    !!}
                });
            };
        window.apiInit = function () {
            App.api.init({
                urls: {!! 
                    json_encode([
                        'comment_list' => route("api.comments"),
                        'comment_create' => route("api.comments.create")
                    ]) 
                !!}
            });
        };

        window.contactInit = function () {
            App.contact.init({
                urls: {!! 
                    json_encode([
                        'send_contact_url' => route("client.contacts.ajax-send"),
                    ]) 
                !!}
            });
        };
    </script>
    
    @if ($data = get_js_src())
        @foreach ($data as $src)

        <script src="{{$src}}"></script>
        
        @endforeach
    @endif

    @if (get_web_type() == 'ecommerce')
        <script>
            window.productAppInit = function () {
                App.products.init({
                    urls: {!! 
                        json_encode([
                            'check_price' => route("client.products.check-price"),
                            'get_data' => route("client.products.data"),
                            'review' => route("client.products.ajax-review")
                        ]) 
                    !!}
                });
            };
            window.orderCartInit = function () {
                App.cart.init({
                    urls: {!! 
                        json_encode([
                            'check_price' => route("client.orders.check-price"),
                            'view_cart' => route("client.orders.cart"),
                            'checkout' => route("client.orders.checkout"),
                            'update_cart' => route("client.orders.update-cart"),
                            'update_cart_quantity' => route("client.orders.update-cart-quantity"),
                            'update_item' => route("client.orders.update-cart-item"),
                            'check_cart_data' => route("client.orders.check-cart-data"),
                            'add_cart_item' => route("client.orders.add-cart-item"),
                            'remove_cart_item' => route("client.orders.remove-cart-item"),
                            'region_options' => route("client.location.regions.options"),
                            'district_options' => route("client.location.districts.options"),
                            'ward_options' => route("client.location.wards.options"),
                        ]) 
                    !!}
                });
            };
            window.orderInit = function () {
                App.orders.init({
                    urls: {!! 
                        json_encode([
                            'cancel' => route("client.orders.cancel"),
                        ]) 
                    !!}
                });
            };
            
        </script>
    @endif
    <script src="{{asset("static/app/js/app.modules.min.js")}}"></script>

    @if ($jssdk = $options->settings->jssdk)
    {!! $jssdk->facebook !!}
    {!! $jssdk->twitter !!}
        
    @endif

    @yield('js')

    
    <script>
        App.task(function($){
            $('.crazy-register-form').submit(function(e){
                

                if($this.prop('submitted')) {
                    e.preventDefault();
                    return false;
                }

                $this.prop('submitted', true);
                var submit = $(this).find('[type="submit"]');
                submit.html("Đang xử lý");
                submit.prop("disabled", true);
            });
            
            App.queue(function(resolve, reject){
                if(App.Swal){
                    //@if ($popup_error = session('error')) 

                        App.Swal.error("{{$popup_error}}");
                    //@elseif ($popup_message = session('message'))

                        App.Swal.alert("{{$popup_message}}");
                    //@elseif ($popup_alert = session('alert'))

                        App.Swal.alert("{{$popup_alert}}");
                    //@elseif ($popup_success = session('success'))
                    
                        App.Swal.success("{{$popup_success}}");
                    //@endif

                    return resolve("Hoàn thành task");
                }
            }, 50, 1000);

            
        })
    </script>
    