MachineList = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
    this.filters = o.filters;
    this.name = o.name;
    this.acc = o.acc;
  },

  
  render: function(){
    //generate a table based on these column name keys
    columns = { //pretty print column titles and their mysql equivs
      'Make' : 'make',
      'Model' : 'model',
      'Type of Equipment':'equip_type',
      'VVPAT' : 'vvpat',
      'Vendor' : 'vendor',
    };
    if(this.acc){
      columns['Accesible Use'] = 'pp_acc';
    }
    var title = '<b style="font-size:20px;">'+this.name+'</b><Br/>';
    var table = '';
    
    //scope hack, can't see same 'this' inside of underscore filter anon funct
    if(this.name =='Absentee Ballot Tabulation'){
      console.log(this.collection.models.length+' models');
    }

    var filtered = _.filter(this.collection.models,function(machine){
      if(this.filters.length>0){//only filter if we're handed filters
        for(i in this.filters){
          if(machine.attributes[this.filters[i]]==1){
            return true;
          }
        }
      } else {
        return true;
      }
      return false;
    },this);
    
    if(this.name =='Absentee Ballot Tabulation'){
      console.log(filtered.length+' post type filter');
    }
    
    if(filtered.length>0){
      table += '<table class="table table-striped table-bordered">';
      table += '<thead>';
      _(columns).each(function(val,key){
        table += '<th>'+key+'</th>';
      });
      table += '</thead><tbody>';
      
      filtered = this.unique(filtered);
      
      if(this.name =='Absentee Ballot Tabulation'){
        console.log(filtered.length+' post duplicates removal');
      }
      
      _(filtered).each(function(machine){
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
          } if(val=='pp_acc'){
            contents = machine.attributes[val]==1 ? 'Yes' : 'No';
          }
          table+='<Td>'+contents+'</td>';
        });
        table += '</tr>';
      });
      table += '</tbody></table>';
    } else {
      title += 'No information available<br/><Br/>';
    }
    $(this.el).html(title+table);
  },
  
  //returns set of rows with unique Type of Equipment
  unique : function(machines){
    var out = [];
    
    _(machines).each(function(machine){
      //test to see if in out, if not add it
      var test = _(out).find(function(guy){
        return guy.attributes['equip_type']==machine.attributes['equip_type'];
      });
      if(!test){
        out.push(machine);
      }
      
    });
    return out;
  }

});








