<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác thực đơn hàng</title>
    <style>
    .confirm-block{
        /* margin: 0 auto; */
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
        <p>Mã đơn hàng: <strong>{{$payment->id}}</strong></p>
        <p>Bạn đã chọn phương thức thanh toán chuyển khoản, và dưới đây là hướng dẫn thanh toán đơn hàng</p>

    </div>

    <div class="banh-info  pb-3">
        <h3>Thông tin chuyển khoản</h3>
        <p>Số tài khoản: <strong>{{$paymentConfig->bank_account_number}}</strong></p>
        <p>Chủ tài khoản: <strong>{{$paymentConfig->bank_account_owner}}</strong></p>
        <p>Ngân hàng: <strong>{{$paymentConfig->bank_name}}</strong></p>
        <p>Chi nhánh: <strong>{{$paymentConfig->bank_branch}}</strong></p>
        <p>Số tiền: <strong>{{number_format($package->price, 0, ',', '.')}} VNĐ</strong></p>
        <p><strong>* Lưu ý:</strong> khách hàng tự chịu phí chuyển khoản</p>
        
    </div>

    

    <div class="guide">
        <h3>Hướng dẫn</h3>
        <div class="guide-step">
            <h3>Bước 1:</h3>
            <p>Chuyển khoản với nội dung: Số điện thoại + mã đơn hàng</p>
            <p>Ví dụ: {{$phone_number}} + {{$payment->id}}</p>
        </div>
        <div class="guide-step">
            <h3>Bước 2:</h3>
            <p>Scan hoặc chụp hình rõ nét biên lai</p>
        </div>
        <div class="guide-step">
            <h3>Bước 3:</h3>
            <p>Nhấp vào <a href="{{'#'}}">đây</a> để điền thông tin giao dịch</p>
        </div>
        <div class="guide-step">
            <h3>Bước 4:</h3>
            <p>Nhấn "Xong" để hoàn tất quá trình thanh toán</p>
        </div>
    </div>

    <div class="welcome">
        <h3>Thông tin Thanh toán 
        </h3>

        <div class="table-responsive">
            
            <table>
                <tbody>
                    <tr>
                        <td>Tên khách hàng</td>
                        <td>{{$name}}</td>
                    </tr>
                    <tr>
                        <td>Số diện thoại</td>
                        <td>{{$phone_number}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{$email}}</td>
                    </tr>
                    <tr>
                        <td>Mã thanh toán</td>
                        <td>{{$payment->id}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    
        <p>Chi tiết</p>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            Tên gói
                        </td>
                        <td>
                            {{$package->name}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Số lượng tài khoản
                        </td>
                        <td>
                            {{$package->user_limited}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Giá
                        </td>
                        <td>
                            {{number_format($package->price, 0, ',', '.')}} VNĐ
                        </td>
                    </tr>
                </tbody>
                
            </table>
        </div>
        
    
    </div>
    

</body>
</html>