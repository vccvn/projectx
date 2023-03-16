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

    .welcome, .bank-info, .guide{
        margin: 15px auto;
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
    <div class="welcome">
        <p>Chúc mừng bạn đã đặt hàng thành công!</p>
        <p>Mã đơn hàng: <strong>{{$order->id}}</strong></p>
        <p>Bạn đã chọn phương thức thanh toán chuyển khoản, và dưới đây là hướng dẫn thanh toán đơn hàng</p>

    </div>

    <div class="banh-info  pb-3">
        <h3>Thông tin chuyển khoản</h3>
        <p>Số tài khoản: <strong>{{$payment->bank_account_number}}</strong></p>
        <p>Chủ tài khoản: <strong>{{$payment->bank_account_owner}}</strong></p>
        <p>Ngân hàng: <strong>{{$payment->bank_name}}</strong></p>
        <p>Chi nhánh: <strong>{{$payment->bank_branch}}</strong></p>
        <p>Số tiền: <strong>{{get_currency_format($order->total_money)}}</strong></p>
        <p><strong>* Lưu ý:</strong> khách hàng tự chịu phí chuyển khoản</p>
        
    </div>

    

    <div class="guide">
        <h3>Hướng dẫn</h3>
        <div class="guide-step">
            <h3>Bước 1:</h3>
            <p>Chuyển khoản với nội dung: Số điện thoại + mã đơn hàng</p>
            <p>Ví dụ: {{$phone_number}} + {{$order->id}}</p>
        </div>
        <div class="guide-step">
            <h3>Bước 2:</h3>
            <p>Scan hoặc chụp hình rõ nét biên lai</p>
        </div>
        <div class="guide-step">
            <h3>Bước 3:</h3>
            <p>Nhấp vào <a href="{{route('client.payments.check-order', ['order_id' => $order->id, 'contact' => $email])}}">đây</a> để điền thông tin giao dịch</p>
        </div>
        <div class="guide-step">
            <h3>Bước 4:</h3>
            <p>Nhấn "Xong" để hoàn tất quá trình thanh toán</p>
        </div>
    </div>

    <div class="welcome">
        <h3>Thông tin Thanh toán 
            @if (!$order->ship_to_different_address)
                &amp;
                Giao hàng
            @endif
        </h3>

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

        @if ($order->ship_to_different_address)
        <p><strong>Thông tin giao hàng</strong></p>
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

        <br>
        <p>Hóa đơn:</p>
        <table>
            <tbody>
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
    
        <p>Chi tiết</p>
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
                    <td class="cart-product-price"><strong class="{{parse_classname('item-total-price')}}">
                        {{$item->getTotalFormat()}}</strong>
                    </td>
                    
                </tr>
                
                @endforeach
    
            </tbody>
            
        </table>
    
    </div>
    

</body>
</html>