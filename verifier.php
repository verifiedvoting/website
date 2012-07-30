<?php
/**
 * Template Name: Verifier
 */


get_header(); ?>
  <style>
  
.cousub:hover {
stroke:#000;
fill:#FFF;
}

.box {
  width:100px;
  height:100px;
  float:left;
}


.button:hover {
stroke:#000;
fill:#12D;
}
#list {
font-size:14px;
padding-left:30px;
padding-bottom:10px;
}

#list table {
width:90%;
}

#content {
background:#fff;
}

path {
fill:rgb(100,100,100);
}

path.none {
  fill:rgb(160,160,160) ;
}

path.pbvs {
  fill:#0c810d ;
}

path.mpbv {
 fill:#23ff25;
}

path.mpbn {
    fill:#ffa500;
}

path.mpdx {
    fill:#ff00ff;
}

path.drev {
  fill:#FFFF00;
}

path.dren {
  fill:#FF0000;
}


path {
  stroke:black;
}



  </style>
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


  			<h1>Verifier</h1>
<div style="width:994px;">
				<article>			

  		<div id="body" >
        <div id="info" class="sidebar-nav well" style="float:right;width:190px;padding:10px;margin:10px;">
          
        </div>
      </div>
    
		</article>
</div>

<div style="clear:both;"></div><br/>
<div id="machines-paginator">paginator go here<div>
  <div id="list" style="display:block;width:990px;">
  Please select a county
  </div>
  
  <div style="margin:20px;color:#555;">Developer notes :<br/>California displays county subdivisions this was the boundry data I tested with, will remedy with count-level boundaries.<br/>Counties do not yet display meta information such as election administrator or breakdown of voters. Working on having these worksheets imported by early next week.</div>
  <div style="clear:both;"></div><Br>
  <div id="map"></div>
			</div><!-- #content --><br/>
	
		</section><!-- #primary -->

<?php get_footer(); ?>
