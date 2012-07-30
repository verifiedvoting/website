OfficialCollection = Backbone.Collection.extend({

  model: Official, 
 
  url: '/api',
  
  fetch : function(options){
    options.data.mode = 'official';
    return Backbone.Collection.prototype.fetch.call(this, options);
  },
  
  parse: function(res,xhr){
  	if(res.error!=0){
  		if(debug.areas) console.log('Error: '+res.message);
  	} else {
      //console.log(res.data);
  	}
    return res.data;
	}
  
});