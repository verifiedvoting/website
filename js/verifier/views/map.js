Map = Backbone.View.extend({
  
  initialize : function(o){
    _.bindAll(this,'render','displayMap'); //bind our callback functions to the real this
    this.collection.bind('reset',this.render);
    this.svg = o.svg;
    
    $('svg').mousemove(function(e){
      $('#tooltip').css('left', e.pageX+20).css('top', e.pageY)
    });
  },
  
  render : function(){  
    this.displayMap();
    this.hideTooltip();
  },
  
  //clicking the map causes both machines and areas to change
  click : function(element){
    var cousub = $(this).attr("data-cousub");
    var county = $(this).attr("data-county-fips");
    var state = $(this).attr("data-state-fips");
    var name = $(this).attr("data-name");
    var code = $(this).attr("data-code");
    
    
    if(county){
     // master.countyName = name;
      $('path.map-area').addClass('greyed');
      $(this).removeClass('greyed');
      
    } else {
     // master.stateName = name;
    }
    
    if(county==null) {
      $(".back").show();
      master.navigate({mode:'state',fips:state,name:name});
    }  else {
      master.navigate({mode:'county',fips:county,name:name});
    }
  
  },
  
  showTooltip : function(e){
    var name = $(this).attr("data-name");
    $('#tooltip').html(name).css('display','block');
  },
  
  hideTooltip : function(e){
    $('#tooltip').css('display','none');
  },
  
  displayBack : function(){

    var width = this.svg.attr("width");
    var height = this.svg.attr("height");
    
    d3.select("#ui").append("svg:rect")
      .attr("x",width-100)
      .attr("y",height-40)
      .attr("width",110)
      .attr("class","back")
      .attr("height",30)
      .attr("style","fill:#ddd;");
    
    d3.select("#ui").append("svg:text")
      .text("Back To States")
      .attr("class","button back")
      .attr("text-anchor","middle")
      .attr("x",width-50)
      .attr("y",height-20);
    
    $(".back").click(function(){master.navigate({mode:'country'});});
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

    var divs = this.collection.models[0].attributes; //there's only gonna be one big ole array
  
    $('.loading').remove();
    var warpY = 1.25;
    
    $('#data').children().remove();
    $('#ui').children().remove();
    
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

    scaleFactor *= .9; //shave off 5% total, we'll offset by the remaining difference in size later

    // our divs object looks like this:
    // divs.features[].geometry.coordinates[][][x,y]
    
    
    /* FUN TIME MAP MANIPULATION STUFF!
    
    var alaska = _(divs.features).find(function(guy){ return guy.properties.NAME=='Alaska'});
    for(b in alaska.geometry.coordinates){
      var dude = alaska.geometry.coordinates[b];
      for(c in dude){
        dude[c][0] *= .35;
        dude[c][1] *= .5;
        dude[c][0] -= 60;
        dude[c][1] -= 6;
      }
    }
    
    var hawaii = _(divs.features).find(function(guy){ return guy.properties.NAME=='Hawaii'});
    for(b in hawaii.geometry.coordinates){
      var dude = hawaii.geometry.coordinates[b];
      for(c in dude){
        dude[c][0] += 30;
        dude[c][1] += 10;
      }
    }
    
    var puerto = _(divs.features).find(function(guy){ return guy.properties.NAME=='Puerto Rico'});
    for(b in puerto.geometry.coordinates){
      var dude = puerto.geometry.coordinates[b];
      for(c in dude){
        dude[c][0] -= 7;
        dude[c][1] += 8;
      }
    }
    */
    
    
    //GIVE US THE JSON BACK
    var blob = JSON.stringify(divs);
    //$('#debug').html('<textarea cols="60" rows="5">' + blob + '</textarea>');

    var bounds = [0,200,-200,0];
    
    
    for(var a in divs.features) {
      //start a string of points for our path data
      var str = "";
      var leftX = 0;
      
      //console.log(divs.features[a]);

      var topY = 0;
      for(var b in divs.features[a].geometry.coordinates) {
        var dude = divs.features[a].geometry.coordinates[b];
        
        //BUILDING A PATH STRING str
        str +="M";//each poly within the path needs to start with a M move command
        for(var c in dude){
          if(dude[c][0] < bounds[0]){
            bounds[0] = dude[c][0];
          }
          if(dude[c][0] > bounds[2]){
            bounds[2] = dude[c][0];
          }
          if(dude[c][1] < bounds[1]){
            bounds[1] = dude[c][1];
          }
          if(dude[c][1] > bounds[3]){
            bounds[3] = dude[c][1];
          }
          //EACH DUDE IS A SINGLE POINT ON A POLY
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
     // .attr("title",divs.features[a].properties.NAME)
      .attr("class","map-area "+divs.features[a].properties.CODE)
      .attr("data-code",divs.features[a].properties.CODE)
      .attr("data-county-fips",divs.features[a].properties.COUNTY);
    } 
    
    
    //route clicks back to our map.click handler 
    if(master.mode=='country'){
      
    } else {
      this.displayBack();
    }

    $("path.map-area").mouseleave(this.hideTooltip);
    $("path.map-area").click(this.click);
    $("path.map-area").mouseover(this.showTooltip);
  }
  
});