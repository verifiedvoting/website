AreaCollection = Backbone.Collection.extend({
  model: Area,
  
  mode : 'country', //either country or state

  fips : 0,
  
  currentName : 'USA',

  url: '/api',
  
  fetch : function(options){
    return Backbone.Collection.prototype.fetch.call(this, options);
  },
  
  parse: function(res,xhr){
  	if(res.error!=0){
  		if(debug.areas) console.log('Error: '+res.message);
  	} else {
      //console.log(res.data);
  	}
    return JSON.parse(res.data);
	},
	
	//external calls
	navigate: function(opt){ 
  	if(opt.mode=='country'){
    	this.mode = opt.mode;
    	map.displayLoading();
    	this.fetch({data:{mode:this.mode}});
  	} else if(opt.mode=="state"){
      this.mode = "state";
      this.fips = opt.fips;
      map.displayLoading();
      this.fetch({data:{mode:this.mode,state:this.fips}});
  	}
	}
  
});