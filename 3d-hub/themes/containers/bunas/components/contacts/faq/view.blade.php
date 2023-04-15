
                            <!-- Single Item -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#{{$a = uniqid()}}">
                                            {{$data->title}}
                                        </a>
                                    </h4>
                                </div>
                                <div id="{{$a}}" class="panel-collapse collapse {{!$data->index?'in':''}}">
                                    <div class="panel-body">
                                        <p>
                                        {!! implode('</p><p>', nl2array($data->description)) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->