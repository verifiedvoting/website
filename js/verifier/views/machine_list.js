MachineList = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
  },
  
  render: function(){
    //generate a table based on these column name keys
    columns = { //pretty print column titles and their mysql equivs
      'Make' : 'make',
      'Model' : 'model',
      'Type of Equipment':'equip_type',
      'VVPAT' : 'vvpat',
            'Vendor' : 'vendor',
      'Firmware Version' : 'firmware_version',
    };
    var table = '<b style="font-size:20px;">'+areas.currentName+' 2012</b><Br/>';
    table += '<table class="table table-striped table-bordered">';
    table += '<thead>';
    _(columns).each(function(val,key){
      table += '<th>'+key+'</th>';
    });
    table += '</thead><tbody>';
    _(this.collection.models).each(function(machine){
      table += '<tr>';
      _(columns).each(function(val){
        var contents = machine.attributes[val];
        contents = contents ? contents : 'n/a';
        if(val=='vvpat'){
          if(machine.attributes['equip_type'].indexOf('DRE') > -1){
            contents = machine.attributes[val] ? 'Yes' : 'No';
          } else {
            contents = "N/A";
          }
        }
        table+='<Td>'+contents+'</td>';
      });
      table += '</tr>';
    });
    table += '</tbody></table>';
    $(this.el).html(table);
  }
  

});
