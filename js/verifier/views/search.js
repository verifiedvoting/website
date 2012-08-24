Search = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
   // this.collection.bind('reset', this.render); //do we need?
  },
  
  render: function(){
    var str = JST['search-view']();
    $(this.el).html(str);
    
    $('#search-title').click(this.show);
    
    //jquery callbacks to change
    $('#state-select').change(this.change);
    $('#machine-search').submit(function(){
      //console.log($(this).serialize());
      $.get('/api', 'mode=machine&'+$(this).serialize(),function(data){
       data = JSON.parse(data);
        console.log(data);
        v.map.recolor(data.data);
      });
      return false;
    });
  },
  
  show : function(){
  master.navigate({mode:'country'});
    $('#search-fold').show();
    $('#search-title').removeClass('fake-link');
    $('#info').hide();
  },
  
  hide : function(){
    $('#search-fold').hide();
    $('#search-title').addClass('fake-link');
        $('#info').show();
  },
  
  
  change: function(){

  }
  
});