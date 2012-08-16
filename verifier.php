<?php
/**
 * Template Name: Verifier
 */


get_header(); ?>
		<section id="primary">
			<div id="content" role="main">

    <script type="text/javascript" src="/wp-content/themes/verified_voting/verifier/d3.v2.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/underscore.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/backbone.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/models/machine.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/models/area.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/models/official.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/collections/machines.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/collections/areas.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/collections/officials.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/views/machine_list.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/views/map.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/views/title.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/views/info.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/vv.js"></script>
    
    <script type="text/template" class="jst" id="list-view">
      <td>
		    <%= machine['equip_type'] %>
      </td>
            <td>
		    <%= machine['make'] %>
      </td>
      <td>
		    <%= machine['model'] %>
      </td>
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


  			<h2 id="map-title">Verifier</h2>
<div style="width:994px;">
				<article>			

  		<div id="body" >
        <div id="info" class="sidebar-nav well" style="word-wrap:break-word;float:right;width:190px;padding:10px;margin:10px;">
          
        </div>
      </div>
    
		</article>
</div>

<div style="clear:both;"></div><br/>
<div id="machines-paginator"><div>
  <div id="pp-list" style="display:block;width:990px;">
    Please select a county
  </div>
  <div id="ev-list" style="display:block;width:990px;">
  </div>
  <div id="abs-list" style="display:block;width:990px;">
  </div>
  <div id="pro-list" style="display:block;width:990px;">
  </div>
  
  <div style="margin:20px;color:#555;"></div>
  <div id="debug"></div>
  <div style="clear:both;"></div><Br>
  <div id="map"></div>
			</div><!-- #content --><br/>
	
		</section><!-- #primary -->

<?php get_footer(); ?>
