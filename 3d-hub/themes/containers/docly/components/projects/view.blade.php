
<?php
$projects = $helper->getProjects(['@sorttype' => $data->sorttype?$data->sorttype:1, '@limit' => $data->project_number(10)]);
?>

@if (count($projects))
    

    

        <!--start our project section-->
        <div id="project" class="biz-projects ptb-100">
            <div class="biz-project-wrap">
                <div class="container">
                    <div class="headingOne text-center">
                        <h6 class="sub mb-2">{{$data->sub_title}}</h6>
                        <h2>{{$data->title}}</h2>
                    </div>
                    <div class="row">
                        
                    </div>
                    <div class="button-group filters-button-group text-center">
                        <a class="biz-button is-checked" data-filter="*">Tất cả</a>
                        <?php
                            
                            $exist_tags = [];

                            $thumb_projects = '';
                            $detail_projects = '';

                            // tag trong phần detail
                            
                            foreach ($projects as $item){
                                $item->applyMeta();
                                $project_tags = '';
                                $tags = $item->tags;
                                $class_tags = '';
                                if($tags){
                                    foreach($tags as $tag){
                                        $project_tags .= '<a href="#">'.$tag->name.'</a>, ';
                                        $class_tags .= $tag->slug . ' ';
                                        if(!isset($exist_tags[$tag->slug])){
                                            echo '<a class="biz-button" data-filter=".'.$tag->slug.'">'.$tag->name.'</a>';
                                            $exist_tags[$tag->slug] = 1;
                                        }
                                    }
                                }
                                

                                $thumb_projects .= '
                                

                                <div class="project-item '.$class_tags.'">
                                    <a class="details-popup" href="#'.$item->slug.'">
                                        <div class="project-item-overlay">
                                            <img src="'.$item->getThumbnail().'" class="img-responsive"
                                                alt="'.$item->slug.'">
                                            <div class="overlay-text">
                                                <span>'.$item->title.'</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                ';

                                $detail_projects .= '
                                

                                <div id="'.$item->slug.'" class="biz-project-popup-area biz-animation-popup mfp-hide">
                                    
                                    <div class="biz-project-popup">
                                        <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                                        <div class="row">    
                                            <div class="col-md-7">
                                                <div class="owl-carousel owl-theme white-indicator client-testimonial">';
                                                            if(count($item->gallery)){
                                                                foreach($item->gallery as $gallery){
                                                                    $detail_projects .= '
                                                    <div class="item">
                                                        <img class="img-responsive biz-lazyload" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==" data-src="'.$gallery->getUrl().'" alt="'.htmlentities($item->title).'">
                                                    </div>
                                                    
                                                    ';
                                                                }
                                                            }else{
                                                                $detail_projects .= '
                                                    <div class="item">
                                                        <img class="img-responsive biz-lazyload" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==" data-src="'.$item->getFeatureImage().'" alt="'.htmlentities($item->title).'">
                                                    </div>
                                                    
                                                    ';
                                                            }
                                                            $detail_projects .= '
                                                </div>

                                            </div>
                                            <div class="col-md-5">
                                                <div class="biz-project-popup-text">
                                                    <h3>'.$item->title.'</h3>
                                                    <hr>
                                                    <p>'.nl2br($item->description).'</p>
                                                </div>
                                                <div class="project-meta">
                                                    <span>Danh mục: '. trim($project_tags, ', ') .'</span>
                                                    '.(($client = $item->getClient()) ? '<span>Khách hàng: <a href="#">'.$client->name.'</a></span>': '').'
                                                    '.($item->website ? '<span>Website: <a href="'. ($item->link?$item->link:'#') .'">'.$item->website.'</a></span>':'' ).'
                                                    
                                                </div>
                                                <a class="mfp-close as-button" href="#project">BACK</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                ';
                            }
                        ?>
                        
                        

                    </div>

                    <div class="row grid">

                        {!! $thumb_projects !!}
                        <!-- end of grid -->
                    </div>

                </div>
            </div>
        </div>
        <!--end our project section-->

        <!--start our projects details popup-->
        {!! $detail_projects !!}
        
        <!--end our projects details popup-->


        @endif
