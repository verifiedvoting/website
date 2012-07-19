AreaCollection = Backbone.Collection.extend({
  model: Area,
  
  mode : 'country', //either country or state

  fips : 0,

  url: '/api',
  
  
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
    	this.fetch({data:{mode:this.mode}});
    	return;
  	}

    if(opt.mode=="state"){
      this.mode = "state";
      this.fips = opt.fips;
      console.log('thing');
      this.fetch({data:{mode:this.mode,state:this.fips}});
  	}
	}
  
});