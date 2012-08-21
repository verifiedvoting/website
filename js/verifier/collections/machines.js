MachineCollection = Backbone.Collection.extend({
  model: Machine,
  
  url: '/api',
  
  initialize : function(o){
    _.bindAll(this,'parse');
    this.current_page = 0;
    this.total_pages = 0;
  },
  
  
  fetch : function(options){
    options.data.mode = 'machine-summary';
    return Backbone.Collection.prototype.fetch.call(this, options);
  },

  parse: function(res,xhr){
		if(res.error!=0){
			console.log('Error: '+res.message);
		} else {
		}
		return res.data;
  
  }

});
