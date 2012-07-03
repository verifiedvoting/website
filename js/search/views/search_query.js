var SearchQueryView = Backbone.View.extend({

  events: {
    'focus #search-input':  'onFocus',
    'blur #search-input':  'onBlur',
    'keyup #search-input':  'onChange'
  },
  
  initialize: function(o) {
    this.template = o.template || 'search_query';
    this.default_text = o.default_text || 'Type to Search';
    this.render();
  },
  
  onFocus: function(){
    this.$input.val(this.getQuery());
  },

  onBlur: function(){
    this.setQuery( this.$input.val() );
    this.$input.val( this.getQuery() || this.default_text );
  },

  onChange: function(event){
    // update if keypress was return key, or input is more than two characters long
    if(event.which==13 || this.$input.val() == '*'|| (this.$input.val().length > 2)){
      this.setQuery( this.$input.val() );
    }
  },
      
  render: function() {
    $(this.el).html(JST[this.template](this.getData()));
    this.$input = $('#search-input');
    return this;
  },

  getQuery: function(){
    return this.query || '';
  },

  setQuery: function(new_query){
    this.query = new_query;
    this.collection.setQuery(new_query);
    this.$input.val( this.getQuery());
    router.navigate('/q/'+this.getQuery());
  },
    
  getData: function(){
    return {
      query: this.getQuery() || this.default_text
    }
  },
  
  focus: function(){
    $('#search-input').focus();
  }
});