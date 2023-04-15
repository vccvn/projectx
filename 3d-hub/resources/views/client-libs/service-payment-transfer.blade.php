
    <div class="banh-info  pb-3">
        <h4>Thông tin chuyển khoản</h4>
        @if (($methods = $helper->getPaymentMethodOptions()) && $methods->transfer && ($transfer = $methods->transfer) && ($cfg = crazy_arr($transfer->config)))
            
            <p>Số tài khoản: <strong>{{$cfg->account_number}}</strong></p>
            <p>Chủ tài khoản: <strong>{{$cfg->account_name}}</strong></p>
            <p>Ngân hàng: <strong>{{$cfg->bank_name}}</strong></p>
            @if ($cfg->sort_code)
                <p>Sort Code: <strong>{{$cfg->sort_code}}</strong></p>
            @endif
            @if ($cfg->iban)
                <p>IBAN: <strong>{{$cfg->iban}}</strong></p>
            @endif
            @if ($cfg->bic)
                <p>BIC / Swift: <strong>{{$cfg->bic}}</strong></p>
            @endif
        @else

            <P>Thông tin thanh toán chưa được cấu hình</P>
        @endif
        @if (isset($userService) && $userService && $package = $userService->package)
            
            <p>Số tiền: <strong>{{get_currency_format(
                $transaction_type == 'extension'?$package->maintenance_fee:$final_price)}}</strong>
            </p>
        
        @endif
        <p><strong>* Lưu ý:</strong> khách hàng tự chịu phí chuyển khoản</p>
    </div>
        <div class="guide">
            <h4>Hướng dẫn</h4>
            <div class="guide-step">
                <h4>Bước 1:</h4>
                <p>Chuyển khoản với nội dung: Thanh toán + Mã dịch vụ
                    @if ($userService)
                    <br>
                    Ví dụ: <strong> thanh toán {{$userService->id}}</strong>
                    @endif
                </p>
            </div>
            <div class="guide-step">
                <h4>Bước 2:</h4>
                <p>Scan hoặc chụp hình rõ nét biên lai</p>
            </div>
            <div class="guide-step">
                <h4>Bước 3:</h4>
                <p>Điền vào form bên trên thông tin đơn hàng kèm ảnh biên lai</p>
            </div>
            <div class="guide-step">
                <h4>Bước 4:</h4>
                <p>Nhấn "Xong" để hoàn tất quá trình thanh toán</p>
            </div>
        </div>