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
    // compile all available templates using _.template
  $('.jst').each(function(index,el){
    JST[el.id] = _.template($(el).text());
  });
  
  machines = new MachineCollection();
  pollingMachines = new MachineList({
    collection: machines,
    el: document.getElementById("pp-list"),
    template: JST['list-view'],
    filters: ['pp_std','pp_acc'],
    name : 'Polling Place Equipment'
  });
  
  earlyMachines = new MachineList({
    collection: machines,
    el: document.getElementById("ev-list"),
    template: JST['list-view'],
    filters: ['ev_std','ev_acc'],
    name : 'Early Voting Equipment'
  });
  
  areas = new AreaCollection();
  map = new Map({
    collection : areas,
    svg : svg,
    test : "hello world"
  });
  
  officials = new OfficialCollection();
  info = new Info({
    collection : officials,
    el: document.getElementById("info"),
  });
  
  areas.fetch({data:{mode:'country'}});
  
});