<?php
/**
 * Template Name: Verifier
 */


get_header(); ?>
 <div id="tooltip" style="display: none; left: 243px; right: auto; top: 246px; " class=""></div>

		<section id="primary">
			<div id="content" role="main">

    <script type="text/javascript" src="/wp-content/themes/verified_voting/verifier/d3.v2.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/underscore.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/backbone.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/jquery.svg.min.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/jquery.svgdom.min.js"></script>
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
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/views/search.js"></script>
    <script type="text/javascript" src="/wp-content/themes/verified_voting/js/verifier/master.js"></script>
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
    
    <script type="text/template" class="jst" id="search-view">
    <h3>Search Machines</h3>
    <form id="machine-search">
        <select id="state-select">
        <option value="0">All States</option>
        <option value="1">Alabama</option>
<option value="2">Alaska</option>
<option value="4">Arizona</option>
<option value="5">Arkansas</option>
<option value="6">California</option>
<option value="8">Colorado</option>
<option value="9">Connecticut</option>
<option value="10">Delaware</option>
<option value="12">Florida</option>
<option value="13">Georgia</option>
<option value="15">Hawaii</option>
<option value="16">Idaho</option>
<option value="17">Illinois</option>
<option value="18">Indiana</option>
<option value="19">Iowa</option>
<option value="20">Kansas</option>
<option value="21">Kentucky</option>
<option value="22">Louisiana</option>
<option value="23">Maine</option>
<option value="24">Maryland</option>
<option value="25">Massachusetts</option>
<option value="26">Michigan</option>
<option value="27">Minnesota</option>
<option value="28">Mississippi</option>
<option value="29">Missouri</option>
<option value="30">Montana</option>
<option value="31">Nebraska</option>
<option value="32">Nevada</option>
<option value="34">New Jersey</option>
<option value="35">New Mexico</option>
<option value="36">New York</option>
<option value="37">North Carolina</option>
<option value="38">North Dakota</option>
<option value="39">Ohio</option>
<option value="40">Oklahoma</option>
<option value="41">Oregon</option>
<option value="42">Pennsylvania</option>
<option value="44">Rhode Island</option>
<option value="45">South Carolina</option>
<option value="46">South Dakota</option>
<option value="47">Tennessee</option>
<option value="48">Texas</option>
<option value="49">Utah</option>
<option value="50">Vermont</option>
<option value="51">Virginia</option>
<option value="53">Washington</option>
<option value="54">West Virginia</option>
<option value="55">Wisconsin</option>
<option value="56">Wyoming</option>
</select> 
<input type="submit" value="Submit!">
    </form>
    </script>


  			<h2 id="map-title">Verifier</h2>
      <div style="width:994px;">
				<article>			

  		<div id="body" style="float:left;">
  		</div>

      <div class="sidebar-main">  	
        <div id="info" class="sidebar-nav well sidebar-box">
        </div>	
  		  <div id="search-nav" class="sidebar-nav well sidebar-box">
  		  </div>

      </div>
    
		</article>
</div>

<div style="clear:both;"></div><br/>
<div id="machines-paginator"><div>
  <div id="pp-list" style="display:block;width:990px;">
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
  <div id="map"></div>			</div><!-- #content --><br/>
	
		</section><!-- #primary -->

<?php get_footer(); ?>
