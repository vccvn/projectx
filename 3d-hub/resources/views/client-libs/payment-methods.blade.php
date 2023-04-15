
                                <div class="checkout-payment {{parse_classname('payment-methods')}}">
                                    @if (count($methods = $helper->getPaymentMethodOptions()))
                                        <?php 
                                        $defaultMethod = old('payment_method');
                                        ?>
                                        @foreach ($methods as $method)
                                            <div class="payment-group {{parse_classname('payment-method-option')}}">
                                                <div class="form-group">
                                                    <div class="ps-radio">
                                                        <input type="radio" class="{{parse_classname('payment-method-value')}}" value="{{$method->value}}" name="payment_method" id="payment-method-{{$method->value}}" @if($method->value == $defaultMethod || (!$defaultMethod && !$loop->index)) checked @endif>
                                                        <label class="payment-label {{parse_classname('payment-method-label')}}" for="payment-method-{{$method->value}}">{{$method->name}}</label>
                                                    </div>
                                                    <div class="{{parse_classname('payment-method-description', 'payment-method-description-'.$method->value)}} {{$method->value == $defaultMethod ? 'show' : ''}}" data-method="{{$method->value}}" id="payment-description-{{$method->value}}">
                                                        <p>{{$method->description}}</p>
                                                        @if ($method->method == 'atm' && $method->configData && is_countable($method->configData) && count($method->configData))
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
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                        @endforeach
                                    @endif
                                </div>
                                @if ($err = $errors->first('payment_method'))
                                    <div class="crazy-error">
                                        {{$err}}
                                    </div>
                                @endif