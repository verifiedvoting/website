<?php
/**
 * Template Name: Solr Search
 * Description: Customized Solr Search Results
 */

$JS_PATH = get_template_directory_uri().'/js/';
$acf = new Acf();
get_header();
?>

<script type="text/javascript" src="<?php echo $JS_PATH; ?>/underscore.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/backbone.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/date.js"></script>

<script type="text/javascript">
  SELECT_FILTERS = <?php print(json_encode($acf->get_acf_fields(47))); ?>;
  
  var MULTISELECT_FILTERS = [  
    { 
      name: 'Issues',
      filters: _.map(<?php print(json_encode($acf->get_acf_fields(48))); ?>,function(filter){
        filter.value = '1';
        return filter;
      })
    },{
      name: 'Source',
      filters: _.map(<?php print(json_encode($acf->get_acf_fields(12))); ?>,function(filter){
        filter.value = '1';
        return filter;
      })
    } 
  ];
</script>

<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/collections/collection_set.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/collections/filter.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/collections/solr.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/views/list.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/views/pagination.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/views/row.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/views/search_query.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/views/select.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/views/multiselect.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/views/filter_list.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/router.js"></script>
<script type="text/javascript" src="<?php echo $JS_PATH; ?>/search/index.js"></script>


<!-- begin templates -->

<script id="search_query" class="jst" type="text/template">
  <input value="<%= query %>" name="keywords" placeholder="Search" id="search-input" class="search-query span4" type="text">
</script>

<script id="solr_row" class="jst" type="text/template">
  <div class="span9">
    <h3><a href="<%= item.get('permalink') %>"><%= item.get('title') %></a></h3>
    <div class="article-metadata">
      <span class="date">
        <%= item.getDate() %>
      </span>
      <span class="divider">,</span>
      <span class="name"><a href="<%= item.get('author_s') %>"><%= item.get('author') %></a></span>
    </div>
    <p><%= item.get('content') %></p>
    <div class="callout-options pull-right">
      <a class="read-more" href="<%= item.get('permalink') %>">read more &raquo;</a>
    </div>
  </div>
</script>

<script id="solr_list_headers" class="jst" type="text/template">
  <div class="row">
    <div class="span9">
    </div>
  </div>
</script>

<script id="paginator" class="jst" type="text/template">
  <div class="row pagination">
    <div class="span9">
      <ul >
        <% if(current_page > 1) { %>
          <li>
            <a class="prev-page">&larr;</a>
          </li>
        <% } else { %>
          <li class='disabled'>
            <a>&larr;</a>
          </li>
        <% } %>
        <% if(lower_bound > 1){ %>
          <li>
            <a class="go-to-page">1</a>
          </li>
          <li class='disabled'>
            <a>...</a>
          </li>
        <% } %>
        <% for(i = lower_bound; i < lower_bound+show_pages && i <= total_pages; i++){ %>
          <% if(current_page === i) { %>
            <li class='active'>
              <a class="current-page"><%= i %></a>
            </li>
          <% } else { %>
            <li>
              <a class="go-to-page"><%= i %></a>
            </li>
          <% } %>
        <% } %>
        <% if(lower_bound+show_pages <= total_pages){ %>
          <li class='disabled'>
            <a>...</a>
          </li>
          <li>
            <a class="go-to-page"><%= total_pages %></a>
          </li>
        <% } %>
        <% if(current_page < total_pages) { %>
          <li>
            <a class="next-page">&rarr;</a>
          </li>
        <% } else { %>
          <li class='disabled'>
            <a>&rarr;</a>
          </a>
        <% } %>
      </ul>
    </div>
  </div>
</script>

<script id="solr-row" type="text/template" class="jst">
  <strong>
    Page <%= current_page %> of <%= total_pages %>, showing results 1-10 of <%= total_results %>
  </strong>
</script>

<script id="checkbox" type="text/template" class="jst">
  <label class="checkbox"><input class="checkbox" type="checkbox" name="<%= name %>" <% if(checked){ %>checked="checked"<% } %> value="1"> <%= label %></label>
</script>

<!-- end templates -->

<style>
  #search-title{
    bottom: 13px;
    font-size: 43px;
    left: 13px;
    position: relative;
  }
  .pagination li{
    cursor: pointer;
  }
  .nav-pills .nav-header{
    line-height: 32px;
    margin-right: 4px;
  }
  #search-query{
    margin-bottom: 8px;
  }
  #search-input{
    background: #ffffff;
  }
  .nav li.filter:hover{
    background: #0088CC;
  }
  .nav label{
    margin-bottom: 0;
    padding-bottom: 2px;
    padding-top: 2px;    
  }
  #filter-list{
    text-transform: capitalize;
  }
</style>


<!-- begin search layout -->

<div class="row">

  <div class="span3">
    <h1 id="search-title">Search</h1>
  </div>
  
  <div class="row">  
    <div id="search-query" class="span9"></div>
  </div>

</div>
  
<div class="row">

  <div id="search-sidebar" class="span3">
    <div id="controls"></div>
  </div>
      
  <div id="search-main" class="span9">
  
    <ul id="filter-list" class="nav nav-pills">
    </ul>
    
    <div id="search-top-paginator"></div>
    <div id="search-results"></div>
    <div id="search-bottom-paginator"></div>
    
  </div>
</div>  

<!-- end search layout -->

<?php get_footer(); ?>