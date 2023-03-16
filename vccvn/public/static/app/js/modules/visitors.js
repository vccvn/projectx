//contact
App.extend({
    visitors: {
        urls: {},
        init_list: ["urls"],
        tasks: [],
        data:{},
        // kiểm tra giá sdan3 phẩm kèm thuộc tính
        /**
         * 
         * @param {*} data 
         */
        checkVisitor: function(data){
            var self = this;
            App.api.post(this.urls.check, data?data:this.data).then(function(rs){
                if(rs.status){
                    if(self.tasks.length){
                        self.tasks.map(function(fn){
                            if(typeof fn == "function"){
                                fn(rs.data);
                            }
                        })
                    }
                }
            })
        },
        addTask: function(fn){
            if(typeof fn == "function"){
                this.tasks.push(fn);
                return true;
            }
            return false;
        }

  
    }
    // end cart
});


if (typeof window.visitorInit == "function") {
    if (typeof window.visitorInit == "function") {
        window.visitorInit();
        setTimeout(function(){
            App.visitors.checkVisitor();
        }, 1000);
    }
}
