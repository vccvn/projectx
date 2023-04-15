jQuery(document).ready(function () {
    

    let $static = $('.deep-select-group.static');
    if($static.length){
        $static.map(function (index, select) {
            if($(select).find('.option-item').length>10){
                $(select).find('.search-block').show();
                
            }else{
                $(select).find('.search-block').hide();
            }    
        });

        $static.children('.dropdown-menu').on('keyup mouseup', function (e) {
            var el = e.target;
            var tag = el.tagName.toLowerCase();
            if(tag=='input' && el.getAttribute('name') == 'search_options'){
                var text = el.value.toLocaleLowerCase();
                var cc = 0;
    
                $(this).find('.option-list>.option-item').each(function (ind, elem) {
                    if($(elem).data('text').toLocaleLowerCase().split(text).length>1){
                        $(elem).show();
                        cc++;
                    }else{
                        $(elem).hide();
                    }
                });
    
                var checkGroup = function(group, callback){
                    var s = false;
                    var dropdownHeader = $(group).children('.dropdown-header');
                    if(dropdownHeader.length){
                        if($(dropdownHeader[0]).html().toLocaleLowerCase().split(text).length>1){
                            s = true;
                            $(group).find('.option-group').show();
                            $(group).find('.option-item').show();
                            
                        }
                    }
                    if(!s){
                        $(group).children().each(function(ind, elm){
                            if($(elm).hasClass('option-item')){
                                if($(elm).data('text').toLocaleLowerCase().split(text).length>1){
                                    s = true;
                                    $(elm).show();
                                }else{
                                    $(elm).hide();
                                }
                                
                            }else if($(elm).hasClass('option-group')){
                                var a = callback(elm, callback);
                                if(a) s = a;
                            }
                        });
                        
                    }
                    if(s){
                        $(group).show();
                    }else{
                        $(group).hide();
                    }
                    return s;
                };
    
                $(this).find('.option-list>.option-group').each(function (index, elem) {
                    if(checkGroup(elem, checkGroup)) cc++;
                });
    
                if(!cc){
                    $(this).find('.message').show();
                }else{
                    $(this).find('.message').hide();
                }
    
            }
        });
        
    }
    $('.deep-select-group .dropdown-menu').on('click', function (e) {
        var el = e.target;
        var tag = el.tagName.toLowerCase();
        if(tag != 'a'){
            e.stopPropagation();
        }else{
            var $el = $(el);
            if($el.hasClass('dropdown-item')){
                var value = $el.data('value');
                let isl = 'input#'+$(this).data('ref');
                let old = $(isl).val();
                if(value != old){
                    var text = $el.data('text');
                    $(this).siblings('.btn.show-text-value').html(text);
                    $(this).siblings('.btn.show-text-value').val(value);
                    $(isl).val(value);
                    $(this).find('.option-item').removeClass('active');
                    $el.addClass('active');
                    var onc = $(this).parent().data('changed-callback');
                    if(onc){
                        var fn = new App.fn();
                        if(fn.check(onc)){
                            fn.call(onc,[value,el]);
                        }
                    }
                }
            }
        }
    });


});