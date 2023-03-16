<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác thực đơn hàng</title>
    <style>
    .confirm-block{
        margin: 0 auto;
        text-align: center;
    }
    .confirm-block a{
        padding: 10px 50px;
        font-size: 15px;
        background: #ff0000;
        color: #ffffff;
        border-radius: 5px;
        
    }
    table{
        width: 100%;
    }
    table td{
        border: 1px dotted silver;
        text-align: center;
    }
    table td img{
        max-width: 100px;
    }
    .table-responsive{
        max-width: 600px;
        width: 100%;
        margin: 0 auto;
    }
    </style>
</head>
<body>
    <h3>
        Xin chào {{$name}}
    </h3>
    <p>Đơn hàng của bạn đã được hoàn thành. Vui lòng kiểm tra lại đơn hàng và tải về những sản phẩm số bạn đã mua (nếu có) </p>
    <p>Thông tin đơn hàng:</p>
    
    <div class="table-responsive">
        <table>
            <tbody>
                <tr class="cart-subtotal">
                    <th>Mã đơn hàng</th>
                    <td>{{$order->id}}</td>
                </tr>
                <tr class="cart-subtotal">
                    <th>Tạm tính</th>
                    <td><span class="price-ammount {{parse_classname('cart-sub-total-ammount')}}">{{get_currency_format($order->sub_total)}}</span></td>
                </tr>
                <tr class="shipping">
                    <th>Thuế</th>
                    <td>
                        <span class="price-ammount {{parse_classname('cart-tax-ammount')}}">{{get_currency_format($order->tax)}}</span>
                    </td>
                </tr>
                <tr class="cart-total">
                    <th>Tổng tiền</th>
                    <td><span class="price-ammount {{parse_classname('cart-total-ammount')}}">{{get_currency_format($order->total_money)}}</span></td>
                </tr>
                
            </tbody>
        </table>
    
    </div>
    @if (isset($downloads) && count($downloads))
        
    <p>Chi tiết</p>
    <div class="table-auto-width">
        <table class="table">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Link tải</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($downloads as $item)
                        
                <tr class="{{parse_classname('cart-item', 'cart-item-'.$item->id)}}" id="cart-item-{{$item->id}}">
                    <td>
                        <a href="{{$item->getViewUrl()}}">
                            <img src="{{$item->getFeatureImage()}}" alt="{{$item->name}}">
                        </a>
                    </td>
                    <td class="wide-column">
                        {{$item->name}}
                    </td>
                    <td>
                        <a href="{{$item->download_url}}">{{$item->download_url}}</a>
                    </td>
                    
                </tr>
                
                @endforeach

            </tbody>
            
        </table>
    </div>


    @endif

    <br>
    <br>
    <hr>
    <br>
    <br>
    <p>
        Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi
    </p>
</body>
</html>