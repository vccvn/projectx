
                    <!-- Single Item -->
                    <div class="col-md-4 single-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="{{$data->avatar}}" alt="{{$data->name}}" alt="Thumb">
                            </div>
                            <div class="info">
                                <p>
                                    {{$data->description}}
                                </p>
                                <div class="bottom">
                                    <div class="left">
                                        <h4>{{$data->name}}</h4>
                                        <span>{{$data->job}}</span>
                                    </div>
                                    <div class="right">
                                        <a href="{{$data->link?$data->link:'#'}}"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->