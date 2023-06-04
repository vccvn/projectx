@extends($_layout.'master')
{{-- @section('title', $account->formConfig->title) --}}
@include($_lib.'register-meta')
@section('page.header.show', 'breadcrumb')

@section('content')
<section class="page-not-found section-b-space">
    @include($_template . 'page-header', [
        'title' => $page_title,
        // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
    ])

    <div class="container">

        <div class="ps-section__content">

            <form class="ps-form--checkout {{parse_classname('checkout-form', 'place-order-form')}}" method="post" action="{{$submit_url}}" >
                @csrf
            <div class="row">

                
                <div class="col-xl-5 col-lg-4 col-md-12 col-sm-12  ">
                    <h3 class="ps-form__heading">Đơn hàng</h3>

                    <div class="ps-block--shopping-total">
                        <div class="ps-block__header">
                            <p><strong>Sản phẩm</strong> <span><strong>Thành tiền</strong></span></p>
                        </div>
                        <div class="ps-block__content">
                            
                            <div class="order-table table-content table-responsive mb--30">
                                <table class="table">
                                    <tbody>
                                        @foreach ($order->details as $item)
                                                
                                        <tr class="{{parse_classname('cart-item', 'cart-item-'.$item->id)}}" id="cart-item-{{$item->id}}">
                                            <td class="wide-column">
                                                <div>{{$item->product_name}}</div>
                                                @if ($item->attributes && count($item->attributes))
                                                    <div>
                                                        @foreach ($item->attributes as $attr)
                                                        <div>{{$attr->label??$attr->name}}: {{$attr->text}}</div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div>Số lượng: {{$item->quantity}}</div>
                                            </td>
                                            <td class="cart-product-price"><strong class="{{parse_classname('item-total-price')}}">{{$item->getTotalFormat()}}</strong></td>
                                            
                                        </tr>
                                        
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <div class="ps-block__header">
                            <p>Tạm tính <span class="{{parse_classname('cart-sub-total-ammount')}}">{{$helper->getCurrencyFormat($order->sub_total)}}</span></p>
                        </div>
                        <div class="ps-block__header">
                            <p>Phí giao hàng <span class="{{parse_classname('cart-shipping-fee')}}">{{$helper->getCurrencyFormat($order->shipping_fee)}}</span></p>
                        </div>
                        <div class="ps-block__header">
                            <p>Thuế VAT <span class="{{parse_classname('cart-tax-ammount')}}">{{$helper->getCurrencyFormat($order->tax)}}</span></p>
                            
                        </div>
                        <div class="ps-block__content">
                            
                            <h3>Tổng thành tiền <span class="{{parse_classname('cart-total-ammount')}}">{{$helper->getCurrencyFormat($order->total_money)}}</span></h3>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 mb-md--40">
                    <h3 class="heading-secondary mb-5">Thanh toán</h3>
                    <div class=" bg-white" style="font-size: large">
                           
                        @include($_lib.'payments.form')

                        <button type="submit" class="button">Tiếp tục</button>
                    </div>
                </div>
            </div>
        </form>


        
        
        
        </div>
    </div>
</div>


    


<div class="row">
    <div class="col-lg-6 mb-md--40 mx-auto">
        <h2 class="heading-secondary mb--30"></h2>
        <div class="login-reg-box bg--white">
            
        </div>
    </div>

</div>




@endsection









