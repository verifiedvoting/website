$(function(){
  $('#search-form').submit(function(){
    var query = $('#navbar-search').val();
    if(!query) return false;
    window.location = 'http://'+window.location.host+'/search#q/'+query; 
    return false;
  });
});