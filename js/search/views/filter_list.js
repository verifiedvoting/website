var FilterListView = Backbone.View.extend({
  
  className:'nav nav-pills',
    
  initialize: function(o) {
    _.bindAll(this,'render');
    this.collection.on('change reset',this.render);
  },
  
  render: function() {
    var view = this;
    this.$el.empty();
    
    var filters = this.collection.getFilters();
    if(_.isEmpty(filters)) return this;
    
    this.$el.append('<li class="nav-header"><strong>Filters:</strong></li>');
    _.each(filters,function(filter){
      if(!filter.isSet()) return;
      var value;
      if(filter.getValue() === '1') value = filter.getName();
      else value = filter.getValue();
      $('<li>')
      .html('<a href="#">'+value.replace(/_/g,' ')+'</a>')
      .click(function(){
        filter.setOff();
        return false;
      })
      .appendTo(view.el);
    });
    
    return this;
  }
});
