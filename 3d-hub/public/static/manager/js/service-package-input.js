function Spi(el){
    var $el = $(el);
    this.maxIndex = $el.data('max-index');
    this.nextIndex = $el.data('next-index');
    this.template = $el.find('.template').html();
    $el.find('.template').remove();
    var self = this;
    this.init = function(){
        $el.on("click", ".btn-add-package-item", function(e){
            e.preventDefault();
            var item = App.str.eval(self.template, {index:self.maxIndex});
            $el.find(".package-list").append(item);
            self.maxIndex++;
            self.nextIndex++;
            $el.data('max-index', self.maxIndex);
            $el.data('next-index', self.nextIndex);
            
        });
        
        $el.on("click", ".btn-delete-package-item", function(e){
            e.preventDefault();
            var index = $(this).data('index');
            var s = $(this).closest('.package-item');
            if(s.length){
                s.hide(400, function(){
                    s.remove();
                })
            }else{
                $el.find('.package-list package-item[data-index="'+index+'"]').hide(300, function(){
                    $(this).remove();
                });
            }
            
        });

        
    }
}

App.spi = {
    list:[],
    init: function(){
        var $el = $('.package-input');
        if($el.length){
            for (let i = 0; i < $el.length; i++) {
                const element = $el[i];
                const sp = new Spi(element);
                sp.init();
                this.list.push(sp);
            }
        }
    }
};

App.spi.init();