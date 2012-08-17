AreaCollection = Backbone.Collection.extend({
  model: Area,
  
  mode : 'country', //either country or state

  fips : 0,
  
  currentName : 'USA',
  
  state : '',
  
  stateFips : 0,
  
  county : '',
  
  countyFips : 0,

  url: '/api',
  
  fetch : function(options){
    return Backbone.Collection.prototype.fetch.call(this, options);
  },
  
  parse: function(res,xhr){
  	if(res.error!=0){
  		if(debug.areas) console.log('Error: '+res.message);
  	} else {
    	//thing
  	}
    return JSON.parse(res.data);
	}
  
});