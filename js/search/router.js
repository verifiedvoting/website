var Router = Backbone.Router.extend({
  routes:{
    "": "index",
    "/": "index",
    "q/:query":"query"
  },
  
  setCurrent: function(button_id){
    jq('#main_menu a').removeClass('current');
    jq(button_id).addClass('current');
  },
  
  index: function(){
  },
  
  query: function(query){
    v.search_query.setQuery(decodeURIComponent(query));
  }
  
});
