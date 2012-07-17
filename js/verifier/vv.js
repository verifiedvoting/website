//GLOBALS
var JST = {};

var debug = { //debug switches
  ajax : false,
  areas : false,
  machines : false
}; 

var c = {} //collections namespace
var v = {} //our views namespace

var width = 740;
var height = 500;

$(function(){
  
});


$(function(){
  //PUT A SVG ON THE DOM, pass this ref to the map later
  var svg = d3.select("#body").append("svg:svg")
    .attr("width", width)
    .attr("height", height)
    .attr("style","float:right;");
       
  svg.append("svg:rect")
    .attr("x",1)
    .attr("y",1)
    .attr("width",width-2)
    .attr("height",height-2)
    .attr("style","fill:#fff;");
    
  svg.append("svg:g").attr("id","data"); 
  svg.append("svg:g").attr("id","ui");
      

  //BACKBONE BOOT
  machines = new MachineCollection();
  machineList = new MachineList({
    collection: machines,
    el: document.getElementById("list"),
    template: JST['list-view']
  });
  
  areas = new AreaCollection();
  map = new Map({
    collection : areas,
    svg : svg,
    test : "hello world"
  });
  
  console.log('calling areas.fetch, expect reset callback on map');
  areas.fetch({data:{mode:'country'}});
  
});