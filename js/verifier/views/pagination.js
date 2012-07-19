var PaginationView = Backbone.View.extend({
  events:{
    'click .prev-page' : 'previousPage',
    'click .next-page' : 'nextPage',
    'click .go-to-page': 'goToPage'
  },
  
  initialize: function(o){
    _.bindAll(this,'render','showLoader','hideLoader');

    this.show_pages = o.show_pages || 5;

    this.collection.bind('reset',   this.render);
    this.collection.bind('add',   this.render);
    this.collection.bind('destroy',   this.render);
  },

  render: function(){

    if(this.getTotalPages() < 2){
      this.$el.html("");
      this.$el.hide();      
    } else {
      this.$el.show();
      this.$el.html(JST.paginator(this.getData()));
      this.loader = $('.paginator-loader',this.$el); 
    }   
  },

  getData: function(){
    return {
      current_page:this.getCurrentPage(),
      total_pages:this.getTotalPages(),
      show_pages:this.getShowPages(),
      lower_bound: this.getLowerBound()
    }
  },
  
  getLowerBound: function(){
    var lower_bound;
    if(this.getCurrentPage() - Math.floor(this.getShowPages() / 2) < 1){
      lower_bound = 1;
    } else {
      lower_bound = this.getCurrentPage() - Math.floor(this.getShowPages() / 2);
      if(lower_bound + this.getShowPages() > this.getTotalPages()){
        lower_bound = Math.max(this.getTotalPages() - (this.getShowPages() - 1), 1);
      }
    }
    return lower_bound;    
  },
  
  getCurrentPage: function(){
    return this.collection.current_page;
  },

  getTotalPages: function(){
    return this.collection.total_pages;
  },
  
  getShowPages: function(){
    return this.show_pages;
  },
      
  previousPage: function(){
    this.showLoader();
    this.collection.previousPage();
  },
  
  nextPage: function(){
    this.showLoader();
    this.collection.nextPage();
  },
  
  goToPage: function(e){
    this.showLoader();
    var page_number = Number(e.target.innerHTML);
    this.collection.gotoPage(page_number);
  },
  
  showLoader: function(){
    this.loader.show();
  },

  hideLoader: function(){
    this.loader.hide();
  }
});