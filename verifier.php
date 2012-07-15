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


  </style>
		<section id="primary">
			<div id="content" role="main">

    <script type="text/javascript" src="/wp-content/themes/verified_voting/verifier/d3.v2.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/underscore.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/backbone.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/views/machine_list.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/models/machine.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/collections/machines.js"></script>
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
  <div id="list" style="display:block;width:990px;">
  Please select a county
  </div>
			</div><!-- #content -->
	
		</section><!-- #primary -->

<?php get_footer(); ?>
