
                                    @if (count($methods = $helper->getPaymentMethodOptions(['id' => $order->payment_method_id])))
                                        <?php
                                        $defaultMethod = $order->paymentMethod->method;
                                        ?>
                                        @foreach ($methods as $method)
                                            @if ($method->method == 'vnpay' && $method->configData && is_countable($method->configData) && count($method->configData))
                                                <label class="payment-label {{parse_classname('payment-method-label')}}" for="payment-method-{{$method->value}}">{{$method->name}}</label>
                                                <div class="crazy-bank-select">
                                                @php
                                                    $opts = get_atm_bank_options($method->configData, asset('static/payments/banks'));
                                                    // dd($method->configData);

                                                    $select = html_input([
                                                        'type' => 'crazyselect',
                                                        'name' => $method->method.'_bank',
                                                        'data' => $opts,
                                                        'default' => old($method->method.'_bank'),
                                                        'id' => $method->method.'_bank',
                                                    ]);


                                                @endphp
                                                @include('client-libs.form.crazyselect', [
                                                    'input' => $select
                                                ])
                                                </div>
                                            @endif

                                        @endforeach
                                    @endif
