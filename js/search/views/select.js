Select = Backbone.View.extend({
  
  className: 'nav nav-list',
  
  events: {
    'change': 'toggleFilter'
  },
  
  initialize: function(o){
    _.bindAll(this,'render');    
    $(o.parent_el).append(this.el);
    this.template = o.template || 'checkbox';

    this.collection.on('change',this.render);
  },
  
  render: function(){
    var view = this;
    this.$el.empty();
    var field = $('<select>')
                .attr({field_name:this.collection.field_name})
                .append('<option>'+this.collection.name+'</option>');
    this.collection.each(function(option){
      var $opt = $('<option>')
      .attr({name: option.get('name')})
      .data('cid',option.cid)
      .html(option.get('label'))
      if(option.isSet()){
        $opt.attr('selected','selected')
      }
      $opt.appendTo(field);
    });
    this.$el.append(field);
    return this;
  },
  
  toggleFilter: function(){
    var view = this;
    $("select option",this.el).each(function(){
      var cid = $(this).data('cid');
      if(!cid) return;
      var filter = view.collection.getByCid(cid);
      if($(this).attr('selected')) filter.setOn();
      else filter.setOff();
    });
  }
});