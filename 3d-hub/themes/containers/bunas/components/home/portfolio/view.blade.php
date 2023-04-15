<?php
$projects = $helper->getProjects(['@sorttype' => $data->sorttype?$data->sorttype:1, '@limit' => $data->project_number(10)]);
?>

@if (count($projects))
    <!-- Star Portfolio
    ============================================= -->
    <div class="portfolio-area default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2>{{$data->title("Các dự án")}}</h2>
                        <p>
                            {{$data->description}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="portfolio-items-area text-center">
                <div class="row">
                    <div class="col-md-12 portfolio-content">
                        <div class="mix-item-menu">
                            <button class="active" data-filter="*">All</button>
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
                                                echo '<button data-filter=".'.$tag->slug.'">'.$tag->name.'</button>';
                                                $exist_tags[$tag->slug] = 1;
                                            }
                                        }
                                    }
                                    

                                    $thumb_projects .= '
                                        <div class="pf-item  '.$class_tags.'">
                                            <div class="item-effect">
                                                <img src="'.$item->getThumbnail().'" alt="'.$item->slug.'" />
                                                <div class="overlay">
                                                    <h4>'.$item->title.'</h4>
                                                    <div class="link">
                                                        <a href="'.$item->getImage().'" class="item popup-link"><i class="fa fa-expand"></i></a>
                                                        <a href="'.$item->getViewUrl().'"><i class="fas fa-link"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                }
                            ?>
                        </div>
                        <!-- End Mixitup Nav-->

                        <div class="row magnific-mix-gallery masonary text-light">
                            <div id="portfolio-grid" class="portfolio-items col-3">
                                {!! $thumb_projects !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Portfolio -->
@endif
