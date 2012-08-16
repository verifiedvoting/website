Title = Backbone.View.extend({

  initialize : function(o){
    _.bindAll(this,'render'); //bind our callback functions to the real this
    this.collection.bind('reset',this.render);
  },
  
  render : function(){
    var subtitle = '';
    if(areas.mode=='country'){
    
    } else {
      subtitle = ' - <span class="cousub" data-state-fips="'+areas.stateFips+'">'+areas.state+"</span>";
      if(areas.mode=='county'){
        subtitle += " - "+areas.county+" County";
      }
    }
    
    $(this.el).html("Verifier"+subtitle);
    
    //$("span.cousub").click(map.click);
    //$("span.cousub").click(function(){console.log('hi');});
  }

});