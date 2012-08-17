//GLOBALS
var JST = {};

var debug = { //debug switches
  ajax : false,
  areas : false,
  machines : false
}; 


var c = {} //collections namespace
var v = {} //our views namespace
var master;


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

  //---BACKBONE BOOT
  // compile all available templates using _.template
  $('.jst').each(function(index,el){
    JST[el.id] = _.template($(el).text());
  });
  
  //---MACHINES LISTS
  c.machines = new MachineCollection();
  
  v.pollingMachines = new MachineList({
    collection: c.machines,
    el: document.getElementById("pp-list"),
    template: JST['list-view'],
    filters: ['pp_std','pp_acc'],
    name : 'Polling Place Equipment',
    acc : true
  });
  
  v.earlyMachines = new MachineList({
    collection: c.machines,
    el: document.getElementById("ev-list"),
    template: JST['list-view'],
    filters: ['ev_std','ev_acc'],
    name : 'Early Voting Equipment',
    acc: true
  });
  
  v.absenteeMachines = new MachineList({
    collection: c.machines,
    el: document.getElementById("abs-list"),
    template: JST['list-view'],
    filters: ['abs_ballots'],
    name : 'Absentee Ballot Tabulation'
  });
  
  v.provisionalMachines = new MachineList({
    collection: c.machines,
    el: document.getElementById("pro-list"),
    template: JST['list-view'],
    filters: ['prov_ballots'],
    name : 'Provisional Ballot Tabulation'
  });

  //---AREA AND MAP
  c.areas = new AreaCollection();
  
  v.map = new Map({
    collection : c.areas,
    svg : svg,
    test : "hello world"
  });
  
  //---OFFICIALS AND INFO
  c.officials = new OfficialCollection();
  
  v.info = new Info({
    collection : c.officials,
    el: document.getElementById("info"),
  });
  
  //---TITLE
  v.title = new Title({
    collection : c.areas,
    el:document.getElementById('map-title')
  });
  
  master = new Master(); //head controller for entire app
  
  master.navigate({mode:'country'});
  
});