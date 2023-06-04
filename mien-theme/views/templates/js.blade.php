    <script src="{{theme_asset('js/jquery-3.6.3.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="{{theme_asset('js/sotope.pkgd.min.js')}}"></script>
    <script src="{{theme_asset('js/script.js')}}"></script>

    
    <script>

        // @if(session('disableBack'))
        
        window.navInit = function(){
            App.nav.init({
                disableBack: true,
                urls: {
                    next: "{{session('next')}}"
                }
            })
        }

        // @endif
        //





        window.customCartInit = function () {
            App.cart.init({
                decimal: 0,
                templates: {
                    item: '<div class="cart-item" data-item-id="{$id}">'+
                        '<div class="cart-inner">'+
                            '<div class="cart-top">'+
                                '<div class="thumb">'+
                                    '<a href="{$link}"><img src="{$image}" alt="{$name}"></a>'+
                                '</div>'+
                                '<div class="content">'+
                                    '<a href="{$link}">{$name}</a>'+
                                '</div>'+
                                '<div class="remove-btn">'+
                                    '<a href="#" class="{{parse_classname('remove-cart-item')}}" data-item-id="{$id}"><i class="icofont-close"></i></a>'+
                                '</div>'+
                            '</div>'+
                            '{$attributes}'+
                            '<div class="cart-bottom">'+
                                '<div class="sing-price">{$price}</div>'+
                                '<div class="cart-plus-minus">{$quantity}'+
                                    // '<div class="dec qtybutton">-</div>'+
                                    // '<div class="dec qtybutton">-</div>'+
                                    // '<input type="text" name="quantity[{$id}]" id="qty-{$id}" value="{$quantity}" data-item-id="{$id}" min="1" placeholder="1" class="cart-plus-minus-box {{parse_classname('product-order-quantity', 'quantity', 'item-quantity')}}">'+
                                    // '<div class="inc qtybutton">+</div>'+
                                    // '<div class="inc qtybutton">+</div>'+
                                '</div>'+
                                '<div class="total-price">{$total_price}</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>',
                   
                    attribute: '<div class="sing-price"><strong class="{{parse_classname('attribute-label')}}">{$label}</strong>: <span class="{{parse_classname('attribute-value')}}">{$value}</span></div>'
                },
                tasks: {
                    changeItemAttribute: function(item){
                        wisestyle_update_cart_attribute(item)
                    }
                }
            });
        };
        window.authInit = function(){
            

            App.auth.init({
                urls: {
                    check: "{{route('client.account.check')}}"
                },
                templates: {
                    account_section: "<i class=\"fa fa-user\"></i> {$name}",
                    link: "<a class=\"dropdown-item\" href=\"{$link}\">{$text}</a>"
                }
            });
            App.auth.check(function(res){
                if(res.status){
                    // gs-account-links
                   
                    function maplinks(links, func) {
                        var linkArr = [];
                        for(var key in links){
                            if(Object.hasOwnProperty.call(links, key)){
                                linkArr.push(func(links[key]));
                            }
                        }
                        return linkArr;
                    }
                    var a = maplinks(res.data.links, function(link){return '<li><a href="'+link.link+'">'+link.text+'</a></li>';}).join('')
                            
                    $('#account-menu-links').html(a);

                    var $btn = $('#account-menu-block .btn-account');
                    $btn.prepend('<span class="avatar-span"><img class="avatar" src="'+res.data.avatar+'" /></span>');
                    $btn.find('span.name-span').html(res.data.name);
                    $btn.removeClass('btn-colored-default');
                    $btn.addClass('btn-outline-default');
                    
                    


                }else{

                    // $('.gs-account-links').html(
                    //     '<a href="{{route('client.account.login')}}">Đăng nhập</a>'+
                    //     '<a href="{{route('client.account.register')}}">Đăng ký</a>'
                    // );
                }
            });
            
            

        };
    </script>