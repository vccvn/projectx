
    <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="{{asset('static/accounts/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('static/accounts/js/popper.min.js')}}"></script>
    <script src="{{asset('static/accounts/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('static/accounts/js/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('static/accounts/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('static/accounts/js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('static/accounts/js/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="{{asset('static/accounts/libraries/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    {{-- <script src="{{asset('assets/libraries/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script> --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script> --}}

    <script src="{{asset('static/app/js/app.min.js')}}"></script>
    <script>
        var csrf = $('meta[name="csrf-token"]').attr('content');
        App.request.setHeaders({
            'X-CSRF-TOKEN': csrf
        });
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });
    
        App.request.setEngine("ajax");
        window.apiInit = function(){
            App.api.init({
                urls: {
                    
                    
                }
            })
            
        };
    </script>
    <script src="{{asset('static/app/js/app.modules.min.js')}}"></script>

    <script src="{{asset('static/accounts/js/framework.js')}}"></script>
    <!-- Settings -->
    <script src="{{asset('static/accounts/js/settings.js')}}"></script>
    
    
    {{-- @if (isset($checkAuth))
        
    <script src="{{asset('assets/app/js/app.auth.js')}}"></script>
    
    @endif
     --}}
    <script src="{{asset('static/accounts/js/app.main.js')}}"></script>
    

    @yield('js')
    <script>
    // @if (($successSession = session('success')) || ($messageSession = session('message')))

        App.Swal.success(@json($successSession?$successSession:$messageSession));
        
    // @elseif ($errorSession = session('error'))

        App.Swal.error(@json($errorSession));

    // @elseif ($warningSession = session('warning'))

        App.Swal.warning(@json($warningSession));
        
    // @elseif ($errors->any() && $validateError = $errors->all())
    
        App.Swal.error("{!! $a = implode('<br />', $validateError) !!}");
        console.log("{{$a}}")

    // @endif
    </script>

