function PropInput(selector){
    this.$el = $(selector);
    this.$list = this.$el.find('.crazy-prop-list');
    this.$add = this.$el.find('.crazy-prop-buttons .crazy-btn-add-prop');
    this.template = this.$el.find('.crazy-prop-template').html();
    this.total = parseInt(this.$el.find('.crazy-prop-template').data('max-index'))+1;
    this.propTemplate = this.$el.find('.prop-template').html();
    this.propItemData = {};
    var self = this;
    this.init = function(){
        this.$el.find('.crazy-prop-template').remove();
        this.$el.find('.prop-template').remove();
        this.$add.click(function(){
            var index = self.total;
            var item = App.str.eval(self.template, {index:index});
            self.$list.append(item);
            $('#crazy-prop-item-'+index).slideDown(400)

            self.total++;
        });
        this.$list.on('click', '.crazy-prop-item .crazy-btn-delete-prop', function(){
            $('#crazy-prop-item-'+$(this).data('index')).slideUp(400, function(){
                $(this).remove();
            });
        });
        this.$list.on('click', '.crazy-prop-item .crazy-btn-add-prop-key-value', function(){
            self.addItemPropKeyValue($(this).data('index'));
        });


        this.$list.on('click', '.crazy-prop-item .crazy-btn-delete-prop-data', function(){
            self.deletePropItemData($(this).data('list-index'), $(this).data('item-index'));
        });
    };

    this.addItemPropKeyValue = function(index){
        var $list = this.$list.find('#crazy-prop-item-'+index+' .prop-list');
        if($list.length){
            var itemCount = $list.data('max-index');
            if(typeof this.propItemData['item_'+index] == "undefined"){
                this.propItemData['item_'+index] = parseInt(itemCount);
            }
            var propData = {
                name: this.$el.data('name'),
                index: index,
                loop_index: this.propItemData['item_'+index]
            };
            $list.append(App.str.eval(this.propTemplate, propData));
            this.propItemData['item_'+index]++;
        }
    };

    this.deletePropItemData = function(listIndex, itemIndex){
        var item = this.$el.find('#'+this.$el.data('name')+'-'+listIndex+'-prop-list-'+itemIndex);
        // cl('#'+this.$el.data('name')+'-'+listIndex+'-prop-list-'+itemIndex);
        if(item.length){
            item.slideUp(400, function () { $(this).remove(); });
        }
    }
}



App.propInput = {
    list:{},
    add: function (selector){
        var $el = $(selector);
        if($el.length){
            let $select = new PropInput($el[0]);
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
    var $cs = $('.crazy-prop');
    if($cs.length){
        $cs.each(function(i, el){
            App.propInput.add(el);
        });
    }
});
