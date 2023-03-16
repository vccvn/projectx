<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông báo</title>
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
        Xin chào {{$user->name}}
    </h3>
    <p>Chúc mừng bạn đã Thanh toán thành công! Vui lòng chờ đợi trong khi yêu cầu của bạn đang được xử lý</p>
    <p>Thông tin giao dịch:</p>
    <div class="table-responsive">
        <table>
            <tbody>
                <tr class="cart-subtotal">
                    <th>Mã giao dịch</th>
                    <td>{{$payment->id}}</td>
                </tr>
                <tr class="cart-total">
                    <th>Tổng tiền</th>
                    <td><span class="price-ammount ">{{number_format($payment->amount, 0, ',', '.')}}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>