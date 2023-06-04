@extends($_layout.'master')
@include($_lib.'register-meta')

@section('content')
    <section class="section-b-space min-80vh">
        <div class="ps-order-tracking pt-60">
            <div class="container">
                @if ($order && $order->details && count($order->details))
                    <div class="order-detail">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="tab-pane fade dashboard-profile dashboard active show" id="profile">
                                    <div class="box-head">
                                        <h3>Hóa đơn</h3>
                                    </div>
                                    <ul class="dash-profile">
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Mã đơn hàng</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ $order->code }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Trạng thái</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ $order->getStatusLabel() }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Thanh toán</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ $order->getPaymentMethodText() }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Tạm tính</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ get_currency_format($order->sub_total) }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Phí giao hàng</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ get_currency_format($order->shipping_fee) }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Thuế</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ get_currency_format($order->tax) }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Giảm giá khuyến mại</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ get_currency_format($order->promo_total) }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Tổng tiền</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ get_currency_format($order->total_money) }}</h6>
                                            </div>
                                        </li>
                                    </ul>
                                    @if ($order->isPaymentMethod('transfer') && $order->isPaymentPending() && !$order->is('canceled'))
                                        <a href="{{ route('client.payments.check-order', ['order_code' => $order->code, 'contact' => $order->billing->email]) }}" class="btn btn-theme btn-colored-default btn-def-size" style="margin-top: 3%;">Thanh toán</a>
                                    @endif
                                    @if ($order->canCancel())
                                        <a class="btn btn-theme btn-colored-default {{ parse_classname('btn-cancel-order') }}" data-id="{{ $order->id }}" data-order-code="{{ $order->code }}" style="margin-top: 3%;">Hủy</a>
                                    @endif
                                    <div class="box-head mt-lg-5 mt-3">
                                        <h3>Giao hàng</h3>
                                    </div>

                                    <ul class="dash-profile">
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Họ và tên</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ $order->shipping->name }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Số điện thoại</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ $order->shipping->phone_number }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Email</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ $order->shipping->email }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="left">
                                                <h6 class="font-light">Địa chỉ giao hàng</h6>
                                            </div>
                                            <div class="right">
                                                <h6>{{ $order->shipping->getFullAddressText() }}</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="cart-table table-content table-responsive">
                                    <table class="table ps-table ps-table--vendor detail-table">
                                        <thead>
                                        <tr>
                                            <th>Ảnh</th>
                                            <th>Sản phẩm</th>
                                            <th class="product-price">Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th class="product-price">Thành tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($order->details as $item)
                                            <tr class="{{ parse_classname('cart-item', 'cart-item-' . $item->id) }}" id="cart-item-{{ $item->id }}">
                                                <td class="image-column">
                                                    <a href="{{ $item->link }}">

                                                        <img src="{{ $item->image }}" alt="{{ $item->product_name }}">
                                                    </a>
                                                </td>
                                                <td class="wide-column">
                                                    <a href="{{ $item->link }}">{{ $item->product_name }}</a>
                                                    @if ($item->attributes && count($item->attributes))
                                                        @foreach ($item->attributes as $attr)
                                                            <p>{{ $attr->label ?? $attr->name }}: {{ $attr->text }}</p>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="product-price"><strong>{{ $item->getPriceFormat() }}</strong></td>
                                                <td class="product-quantity">
                                                    <div class="quantity">
                                                        @if ($item->product_type == 'digital' && $order->is('completed'))
                                                            @if ($download = $helper->getMetadata('product', $item->product_id, 'download_url'))
                                                                <a href="{{ $download }}">Tải về máy</a>
                                                            @endif
                                                        @else

                                                            {{ $item->quantity }}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="product-price"><strong class="{{ parse_classname('item-total-price') }}">{{ $item->getTotalFormat() }}</strong></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        Không có sản phẩm nào trong giỏ hàng
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection