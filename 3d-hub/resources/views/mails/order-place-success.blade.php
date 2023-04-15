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
        Xin chào {{$order->name}}
    </h3>
    <p>Chúc mừng bạn đã đặt hàng thành công! Vui lòng chờ đợi trong khi đơn hàng của bạn đang được xử lý</p>
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
    @if ($order->ship_to_different_address)
    
    <p><strong>Thông tin đặt hàng</strong></p>
    <div class="table-responsive">
        <table>
            <tbody>
                <tr>
                    <td>Tên khách hàng</td>
                    <td>{{$order->billing->name}}</td>
                </tr>
                <tr>
                    <td>Số diện thoại</td>
                    <td>{{$order->billing->phone_number}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{$order->billing->email}}</td>
                </tr>
                <tr>
                    <td>Địa chỉ giao hàng</td>
                    <td>{{$order->billing->getFullAddressText()}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>
    <br>

    <p><strong>Thông tin giao hàng và thanh toán</strong></p>
    <div class="table-responsive">
        
        <table>
            <tbody>
                <tr>
                    <td>Tên Người nhận</td>
                    <td>{{$order->shipping->name}}</td>
                </tr>
                <tr>
                    <td>Số diện thoại</td>
                    <td>{{$order->shipping->phone_number}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{$order->shipping->email}}</td>
                </tr>
                <tr>
                    <td>Địa chỉ giao hàng</td>
                    <td>{{$order->shipping->getFullAddressText()}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @else
    <p><strong>Thông tin giao hàng và thanh toán</strong></p>
    <div class="table-responsive">
        
        <table>
            <tbody>
                <tr>
                    <td>Tên Người nhận</td>
                    <td>{{$order->shipping->name}}</td>
                </tr>
                <tr>
                    <td>Số diện thoại</td>
                    <td>{{$order->shipping->phone_number}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{$order->shipping->email}}</td>
                </tr>
                <tr>
                    <td>Địa chỉ giao hàng</td>
                    <td>{{$order->shipping->getFullAddressText()}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @endif
    
    <p>Chi tiết</p>
    <div class="table-auto-width">
        <table class="table">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Thuộc tính</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->details as $item)
                        
                <tr class="{{parse_classname('cart-item', 'cart-item-'.$item->id)}}" id="cart-item-{{$item->id}}">
                    <td>
                        <a href="{{$item->link}}">
                            <img src="{{$item->image}}" alt="{{$item->product_name}}">
                        </a>
                    </td>
                    <td class="wide-column">
                        {{$item->product_name}}
                    </td>
                    <td>
                        @if ($item->attributes && count($item->attributes))
                            @foreach ($item->attributes as $attr)
                                <div>{{$attr->label??$attr->name}}: {{$attr->text}}</div>
                            @endforeach
                            
                        @endif
                    </td>
                    <td>
                        {{$item->quantity}}
                    </td>
                    <td class="cart-product-price"><strong class="{{parse_classname('item-total-price')}}">{{$item->getTotalFormat()}}</strong></td>
                    
                </tr>
                
                @endforeach

            </tbody>
            
        </table>
    </div>

</body>
</html>