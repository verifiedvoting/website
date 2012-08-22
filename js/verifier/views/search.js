Search = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
   // this.collection.bind('reset', this.render); //do we need?
  },
  
  render: function(){
    var str = JST['search-view']();
    $(this.el).html(str);
    
    //jquery callbacks to change
    $('#state-select').change(this.change);
  },
  
  change: function(){//this being the ui dom element
    /*master.navigate({
      mode:'state',
      fips:$(this).val(),
      name:$(this).children().filter('option:selected').text()
    });*/
  }
  
});