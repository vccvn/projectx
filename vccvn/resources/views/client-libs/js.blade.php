@php
$cache_data_time = system_setting('cache_data_time', 0);
    if($cache_data_time){
        add_js_data('____crazy_cache', true);
    }else{
        add_js_data('____crazy_cache', false);
    }
@endphp

{!! $html->getAndCleanCss() !!}

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

        window.visitorInit = function () {
            App.visitors.init({
                urls: {!!
                    json_encode([
                        'check' => route("client.visitors.check"),
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
            App.config = App.config || {
                currency:{
                    thousands_sep:".",
                    currency_position:"left",
                    currency_type:"$",
                    decimal_poiter:",",
                    decimals:2,
                    allow_place_order:true
                }
                
            };
            
            App.config.currency = {!!
                    json_encode(get_ecommerce_setting()->all())
                !!}
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
                            'apply_coupon' => route("client.orders.apply-coupon"),
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



    @if (($pwa = get_option('settings')->pwa) && $pwa->active)

    <!-- Install button, hidden by default -->
    <div id="installContainer" class="hidden">
        <button id="butInstall" type="button">
          Install
        </button>
      </div>
  
      <!-- import the webpage's javascript file -->
      <script src="{{asset("static/app/js/pwa.js")}}"></script>
      
      <!-- include the Glitch button to show what the webpage is about and
            to make it easier for folks to view source and remix -->
      <div class="glitchButton" style="position:fixed;top:20px;right:20px;"></div>
      <script src="https://button.glitch.me/button.js"></script>
    @endif



    @yield('js')
    @php
        $messKeys = ['warning', 'success', 'error', 'info', 'alert'];
    @endphp
    <script>


    // @foreach ($messKeys as $key)
       //  @if ($_message = session($key.'_message'))
            
    App.Swal.{{$key}}({!!json_encode($_message)!!});
            
        // @endif

    // @endforeach

    </script>