Info = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
  },
  
  render: function(){
    var str = '';
    _(this.collection.models).each(function(official){
      row = official.attributes;
      str += row['title']+' - '+row['first_name'] +" "+ row['last_name']+"<br/>";
    });
    $(this.el).html(str);
  }
  
});