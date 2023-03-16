function Apu(el){
    var $el = $(el);
    this.maxIndex = $el.data('max-index');
    this.nextIndex = $el.data('next-index');
    this.template = $el.find('.template').html();
    $el.find('.template').remove();
    var self = this;
    this.init = function(){
        $el.on("click", ".btn-add-affiliate-item", function(e){
            e.preventDefault();
            var item = App.str.eval(self.template, {index:self.maxIndex});
            $el.find(".affiliate-list").append(item);
            self.maxIndex++;
            self.nextIndex++;
            $el.data('max-index', self.maxIndex);
            $el.data('next-index', self.nextIndex);
            
        });
        
        $el.on("click", ".btn-delete-affiliate-item", function(e){
            e.preventDefault();
            var index = $(this).data('index');
            var s = $(this).closest('.affiliate-item');
            if(s.length){
                s.hide(400, function(){
                    s.remove();
                })
            }else{
                $el.find('.affiliate-list affiliate-item[data-index="'+index+'"]').hide(300, function(){
                    $(this).remove();
                });
            }
            
        });

        
    }
}

App.apu = {
    list:[],
    init: function(){
        var $el = $('.affiliate-input');
        if($el.length){
            for (let i = 0; i < $el.length; i++) {
                const element = $el[i];
                const sp = new Apu(element);
                sp.init();
                this.list.push(sp);
            }
        }
    }
};

App.apu.init();