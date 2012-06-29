MultiSelect = Backbone.View.extend({

  tagName: 'ul',
  
  className: 'nav nav-list',
  
  initialize: function(o){
    _.bindAll(this,'render');
    
    $(o.parent_el).append(this.el);
    this.template = o.template || 'checkbox';

    this.collection.on('change',this.render);
  },
  
  render: function(){
    var view = this;
    this.$el.html('<li class="nav-header">'+this.collection.name+'</h3');
    this.collection.each(function(option){
      $('<li class="filter">')
      .html(JST[view.template]({
        name: option.get('name'),
        label: option.get('label'),
        checked: option.isSet()
      }))
      .click(function(){
        option.toggle();
        return false;
      })
      .appendTo(view.el);
    });
    return this;
  }
});