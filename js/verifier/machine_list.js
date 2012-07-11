MachineList = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
    this.template = JST['list'];
  },
  
  render: function(){
    $(this.el).html(this.collection+' ');
  }
  
  

});