var ListView = Backbone.View.extend({
  
  className:'list',
    
  initialize: function(o) {
    _.bindAll(this,'render','addOne','addAll','filter');
    if(o.debug) this.debug = true;
    this.current_row = 0;
    this.template = o.template;
    this.row_view = o.row_view || RowView;
    this.form_view = o.form_view;
    this.no_results_html = o.no_results_html || '';
    this.collection.bind('reset',   this.render);
    this.collection.bind('add',   this.render);
    this.collection.bind('destroy',   this.render);
  },
  
  render: function() {
    if(this.collection.length > 0){
      $('.no-rows', this.el).hide();
    }
    if(this.collection.total_pages > 0){
      this.addAll();
    } else {
      this.$el.html(this.no_results_html);
    }
  },  
  
  // overwrite to filter list
  filter: function(){
    return true;
  },
  
  addOne: function(item){
    
    if(!this.filter(item)) return;
    var view = new this.row_view({
      model: item,
      template: this.template,
      form_view: this.form_view
    });
    view.render();
    if(this.current_row % 2) $(view.el).addClass('even-row');
    this.$el.append(view.el);
    this.current_row++;
  },
  
  addAll: function(){
    this.$el.empty();
    this.$el.append(JST[this.template+'_list_headers']());
    this.current_row = 0;
    this.collection.each(this.addOne);
  }
  
});