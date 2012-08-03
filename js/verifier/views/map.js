Map = Backbone.View.extend({
  
  initialize : function(o){
    _.bindAll(this,'render','displayBack','displayMap'); //bind our callback functions to the real this
    this.collection.bind('reset',this.render, this.displayMap, this.displayBack);
    this.svg = o.svg;
  },
  
  render : function(){  
    this.displayMap();
  },
  
  //clicking the map causes both machines and areas to change
  click : function(element){
    var cousub = $(this).attr("data-cousub");
    var county = $(this).attr("data-county-fips");
    var state = $(this).attr("data-state-fips");
    var name = $(this).attr("data-name");
    var code = $(this).attr("data-code");
    
    areas.currentName = name+" ";
    
    
    if(county==null) {
      $(".back").show();
      areas.navigate({mode:'state',fips:state});
      machines.fetch({data:{state:state}});
      officials.fetch({data:{state:state}});
    }  else {
      machines.fetch({data:{county:county,state:state}});
      officials.fetch({data:{state:state,county:county}});
    }   
  },
  
  displayBack : function(){

    var width = this.svg.attr("width");
    var height = this.svg.attr("height");
    
    d3.select("#ui").append("svg:rect")
    .attr("x",width-85)
    .attr("y",height-40)
    .attr("width",70)
    .attr("class","back")
    .attr("height",30)
    .attr("style","fill:#eee;");
    
    d3.select("#ui").append("svg:text")
    .text("BACK")
    .attr("class","button back")
    .attr("text-anchor","middle")
    .attr("x",width-50)
    .attr("y",height-20);
    
    $(".back").click(function(){areas.navigate({mode:'country'});});
  },
  
  displayLoading : function(){
        
    d3.select("#ui").append("svg:text")
    .text("Loading...")
    .attr("class","loading")
    .attr("text-anchor","middle")
    .attr("style","font-weight:bold;font-size:16px;")
    .attr("x",width/2)
    .attr("y",height-20);
    
  },
  
  displayMap : function(){

    var width = this.svg.attr("width");
    var height = this.svg.attr("height");

    divs = this.collection.models[0].attributes; //there's only gonna be one big ole array
  
    $('.loading').remove();
    var warpY = 1.25;
    
    
    $('#data').children().remove();
    
    //console.log(divs);
    
    divs.bbox[1] *= warpY;
    divs.bbox[3] *= warpY;
        
    var globalX = divs.bbox[0]; //where our bbox is positioned
    var globalY = divs.bbox[1]; 
    var boxWidth  = divs.bbox[2]-divs.bbox[0]; //size of bbox
    var boxHeight  = divs.bbox[3]-divs.bbox[1];
    
    //we're assuming landscape canvas ALWAYS
    //if the state's taller than wide, we need to scale based on height instead
    var scaleFactor = width/boxWidth;
    
    if(scaleFactor*boxHeight > height){
      scaleFactor = height/boxHeight;
    }

    scaleFactor *= .95; //shave off 5% total, we'll offset by the remaining difference in size later

 

    // our divs object looks like this:
    // divs.features[].geometry.coordinates[][][x,y]
    for(a in divs.features) {
      //start a string of points for our path data
      var str = "";
      var leftX = 0;
      var topY = 0;
      for(b in divs.features[a].geometry.coordinates) {
        var dude = divs.features[a].geometry.coordinates[b];
        
        //BUILDING A PATH STRING str
        str +="M";//each poly within the path needs to start with a M move command
        for(c in dude){
          // offset the points, scale them to screen space, add 1/2 the difference between scaled BB and screen
          dude[c][0] = (dude[c][0]-globalX) * scaleFactor + 0.5*(width-scaleFactor*boxWidth);
          dude[c][1] *= warpY;
          dude[c][1] = height - ((dude[c][1]-globalY) * scaleFactor + 0.5*(height-scaleFactor*boxHeight));
          
          if(b==0 && c==0){
            leftX = dude[c][0];
            topY = dude[c][1];
          }
          if(c>0){
            str+="L";//L for 'line to' each next point
          }
          str += dude[c][0]+" "+dude[c][1]+" ";
        }
      }
      str += " Z";//Z for close shape, so we can fill the polys
      
      var pol = d3.select("#data").append("svg:path").attr("d",str);
      pol.attr("data-cousub",divs.features[a].properties.COUSUB)
      .attr("data-state-fips",divs.features[a].properties.STATE)
      .attr("data-name",divs.features[a].properties.NAME)
      .attr("title",divs.features[a].properties.NAME)
      .attr("class","cousub "+divs.features[a].properties.CODE)
      .attr("data-code",divs.features[a].properties.CODE)
      .attr("data-county-fips",divs.features[a].properties.COUNTY);
      
      //random color for us to see
      if(divs.features[a].properties.NAME == 'California' ){
        pol.attr("fill","rgb(70,200,35)").attr("stroke","rgb(255,255,255)");
      } else {
        var mag = parseInt(5*(Math.sin( Math.PI*2.7*(leftX/width))+1)/2)/5.0;
        //pol.attr("stroke","rgb(255,255,255)");
        var rand = parseInt(3*Math.random()+9)/12.0;
        //pol.attr("fill","rgb("+parseInt(mag*80*Math.random()+90*rand)+","+parseInt(Math.random()*90+50+50*rand)+"," +parseInt(170+rand*70)+ ")");
      }
    }
    //route clicks back to our map.click handler 
    if(areas.mode=='country'){
    } else {
      this.displayBack();
    }
    $("path.cousub").click(this.click);
    
  }
  
});