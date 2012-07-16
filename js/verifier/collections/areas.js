AreaCollection = Backbone.Collection.extend({
  model: Area,
  
  mode : 'usa', //either usa or state

  fips : 0,

  url: '/api',
  
  parse: function(res,xhr){
  	if(res.error!=0){
  		if(debug.areas) console.log('Error: '+res.message);
  	} else {
      //console.log(res.data);
  	}
    return res.data;
	},
	
	navigate: function(opt){
  	if(opt.mode=='usa' || opt.mode =='state'){
    	this.mode = opt.mode;
    	this.fetch({data:{mode:this.mode}});
    	return;
  	}

    if(this.mode=='state'){
      this.fips = opt.fips;
      this.fetch({data:{mode:this.mode,state:this.fips}});
  	}
	}
  
});