function SpecificationInput(selector){
    this.$el = $(selector);
    this.$list = this.$el.find('.crazy-specification-list');
    this.$add = this.$el.find('.crazy-specification-buttons .crazy-btn-add-specification');
    this.template = this.$el.find('.crazy-specification-template').html();
    this.total = parseInt(this.$el.find('.crazy-specification-template').data('max-index'))+1;
    this.specificationTemplate = this.$el.find('.specification-template').html();
    this.specificationItemData = {};
    var self = this;
    this.init = function(){
        this.$el.find('.crazy-specification-template').remove();
        this.$el.find('.specification-template').remove();
        this.$add.click(function(){
            var index = self.total;
            var item = App.str.eval(self.template, {index:index});
            self.$list.append(item);
            $('#crazy-specification-item-'+index).slideDown(400)

            self.total++;
        });
        this.$list.on('click', '.crazy-specification-item .crazy-btn-delete-specification', function(){
            $('#crazy-specification-item-'+$(this).data('index')).slideUp(400, function(){
                $(this).remove();
            });
        });
        this.$list.on('click', '.crazy-specification-item .crazy-btn-add-specification-key-value', function(){
            self.addItemSpecificationKeyValue($(this).data('index'));
        });


        this.$list.on('click', '.crazy-specification-item .crazy-btn-delete-specification-data', function(){
            self.deleteSpecificationItemData($(this).data('list-index'), $(this).data('item-index'));
        });
    };

    this.addItemSpecificationKeyValue = function(index){
        var $list = this.$list.find('#crazy-specification-item-'+index+' .specification-list');
        if($list.length){
            var itemCount = $list.data('max-index');
            if(typeof this.specificationItemData['item_'+index] == "undefined"){
                this.specificationItemData['item_'+index] = parseInt(itemCount);
            }
            var specificationData = {
                name: this.$el.data('name'),
                index: index,
                loop_index: this.specificationItemData['item_'+index]
            };
            $list.append(App.str.eval(this.specificationTemplate, specificationData));
            this.specificationItemData['item_'+index]++;
        }
    };

    this.deleteSpecificationItemData = function(listIndex, itemIndex){
        var item = this.$el.find('#'+this.$el.data('name')+'-'+listIndex+'-specification-list-'+itemIndex);
        // cl('#'+this.$el.data('name')+'-'+listIndex+'-specification-list-'+itemIndex);
        if(item.length){
            item.slideUp(400, function () { $(this).remove(); });
        }
    }
}



App.specificationInput = {
    list:{},
    add: function (selector){
        var $el = $(selector);
        if($el.length){
            let $select = new SpecificationInput($el[0]);
            $select.init();
            this.list[$el.data('id')] = $select;
        }
    },
    getTag:function(id){
        if(id){
            if(typeof this.list[id] != "undefined"){
                return this.list[id];
            }
        }
        return null;
    },
    getData:function(id){
        var tag = this.getTag(id);
        if(tag) return tag.getData();
        return [];
    }
};



$(function(){
    var $cs = $('.crazy-specification');
    if($cs.length){
        $cs.each(function(i, el){
            App.specificationInput.add(el);
        });
    }
});
