OfficialCollection = Backbone.Collection.extend({

  model: Official, 
 
  url: '/api',
  
  parse: function(res,xhr){
  	if(res.error!=0){
  		if(debug.areas) console.log('Error: '+res.message);
  	} else {
      //console.log(res.data);
  	}
    return res.data;
	}
  
});