var RowView = Backbone.View.extend({
  className: "row",
  
  initialize: function(o) {
    this.template = o.template;
    this.model.bind('change', this.render);
    this.model.bind('destroy', this.remove);
  },
  
  render: function() {
    $(this.el).html(JST[this.template+'_row'](this.getRowData()));
    return this;
  },

  getRowData: function(){
    return {
      item: this.model
    }
  }
});
