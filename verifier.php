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
    <h3 id="search-title" class="fake-link">Search Equipment</h3>
    <div id="search-fold" style="display:none;">
    <form id="machine-search">
    <select id="state-select" name="state_fips">
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
    
    
<select id="search-equipment" name="equip_type" multiple="true">
  <option value="">All Equipment</option>."\n"  <option value="Accessible Ballot Marking Device">Accessible Ballot Marking Device</option>
  <option value="Optical Scan">Optical Scan</option>
  <option value="DRE-Touchscreen">DRE-Touchscreen</option>
  <option value="Hand Counted Paper Ballots">Hand Counted Paper Ballots</option>
  <option value="DRE-Push Button">DRE-Push Button</option>
  <option value="Digital Scan">Digital Scan</option>
  <option value="DRE-Dial">DRE-Dial</option>
  <option value="Telephone-based Accessible System">Telephone-based Accessible System</option>
  <option value="Punch Card Voting System">Punch Card Voting System</option>
  <option value="Accessible Ballot Generator">Accessible Ballot Generator</option>
</select>

<select id="search-vendor" multiple="true"  name="vendor">
  <option value="">All Vendors</option>
  <option value="Election Systems & Software">Election Systems & Software</option>
  <option value="Dominion Voting Systems">Dominion Voting Systems</option>
  <option value="Harp Enterprises">Harp Enterprises</option>
  <option value="Hart InterCivic">Hart InterCivic</option>
  <option value="Sequoia Voting Systems">Sequoia Voting Systems</option>
  <option value="LHS Associates">LHS Associates</option>
  <option value="IVS">IVS</option>
  <option value="Danaher Controls">Danaher Controls</option>
  <option value="Benton">Benton</option>
  <option value="MicroVote">MicroVote</option>
  <option value="Governmental Business Systems">Governmental Business Systems</option>
  <option value="Election Services Online">Election Services Online</option>
  <option value="Henry Adkins & Son Inc">Henry Adkins & Son Inc</option>
  <option value="Elkins Swyers">Elkins Swyers</option>
  <option value="Populex">Populex</option>
  <option value="Avante">Avante</option>
  <option value="AES">AES</option>
  <option value="LHS Associates Inc.">LHS Associates Inc.</option>
  <option value="Atlantic Election Services">Atlantic Election Services</option>
  <option value="ESO">ESO</option>
  <option value="Unilect">Unilect</option>
  <option value="Spooner Hull">Spooner Hull</option>
  <option value="PrintElect">PrintElect</option>
  <option value="Election Systems and Software">Election Systems and Software</option>
  <option value="Unisyn Voting Solutions">Unisyn Voting Solutions</option>
</select>

<select id="search-make"  multiple="true"  name="make">
  <option value="">All Makes</option>
  <option value="Election Systems & Software">Election Systems & Software</option>
  <option value="Premier Election Solutions (Diebold)">Premier Election Solutions (Diebold)</option>
  <option value="Sequoia Voting Systems">Sequoia Voting Systems</option>
  <option value="Danaher Controls">Danaher Controls</option>
  <option value="Hart InterCivic">Hart InterCivic</option>
  <option value="DFM">DFM</option>
  <option value="MTS">MTS</option>
  <option value="IVS">IVS</option>
  <option value="Votomatic">Votomatic</option>
  <option value="MicroVote">MicroVote</option>
  <option value="Chatsworth Data Corporation">Chatsworth Data Corporation</option>
  <option value="Advanced Voting Solutions">Advanced Voting Solutions</option>
  <option value="Populex">Populex</option>
  <option value="Unisyn">Unisyn</option>
  <option value="Avante">Avante</option>
  <option value="Dominion Voting Systems">Dominion Voting Systems</option>
  <option value="EnableMart">EnableMart</option>
  <option value="Kodak">Kodak</option>
  <option value="N">N</option>
  <option value="Unilect">Unilect</option>
  <option value="Peripheral Dynamics Inc.">Peripheral Dynamics Inc.</option>
  <option value="Vote-PAD">Vote-PAD</option>
  <option value="Election Systems and Software">Election Systems and Software</option>
  <option value="Unisyn Voting Solutions">Unisyn Voting Solutions</option>
</select>


<select id="search-model" multiple="true" name="model">
  <option value="">All Models</option>
  <option value="1500">1500</option>
  <option value="AccuVote ES 2000">AccuVote ES 2000</option>
  <option value="AccuVote TS R6">AccuVote TS R6</option>
  <option value="AccuVote TSX">AccuVote TSX</option>
  <option value="AccuVote-ES 2000">AccuVote-ES 2000</option>
  <option value="AccuVote-ES-2000">AccuVote-ES-2000</option>
  <option value="AccuVote-OS">AccuVote-OS</option>
  <option value="AccuVote-OS central count">AccuVote-OS central count</option>
  <option value="AccuVote-OS High Speed">AccuVote-OS High Speed</option>
  <option value="AccuVote-OSX">AccuVote-OSX</option>
  <option value="AccuVote-PCS">AccuVote-PCS</option>
  <option value="AccuVote-TS">AccuVote-TS</option>
  <option value="AccuVote-TSX">AccuVote-TSX</option>
  <option value="ACP2200">ACP2200</option>
  <option value="Alternate Format Ballot">Alternate Format Ballot</option>
  <option value="AutoMARK">AutoMARK</option>
  <option value="AVC Advantage">AVC Advantage</option>
  <option value="AVC Edge">AVC Edge</option>
  <option value="AVC Edge II">AVC Edge II</option>
  <option value="AVC Edge II Plus">AVC Edge II Plus</option>
  <option value="AVC Edge Plus">AVC Edge Plus</option>
  <option value="Ballot Now">Ballot Now</option>
  <option value="Ballot Now /Kodak Scanner i260">Ballot Now /Kodak Scanner i260</option>
  <option value="Ballot Now /Kodak Scanner i610">Ballot Now /Kodak Scanner i610</option>
  <option value="Ballot Now /Kodak Scanner i660">Ballot Now /Kodak Scanner i660</option>
  <option value="Ballot Now/Kodak Scanner i830">Ballot Now/Kodak Scanner i830</option>
  <option value="BallotNow">BallotNow</option>
  <option value="Digital Ballot Marking Device">Digital Ballot Marking Device</option>
  <option value="DRS 960">DRS 960</option>
  <option value="DS200">DS200</option>
  <option value="eScan">eScan</option>
  <option value="eScan AT">eScan AT</option>
  <option value="eSlate">eSlate</option>
  <option value="ETNET 290">ETNET 290</option>
  <option value="i260">i260</option>
  <option value="ImageCast BMD">ImageCast BMD</option>
  <option value="ImageCast ICP">ImageCast ICP</option>
  <option value="Infinity">Infinity</option>
  <option value="InkaVote">InkaVote</option>
  <option value="InkaVote Plus">InkaVote Plus</option>
  <option value="Inspire">Inspire</option>
  <option value="iVotronic">iVotronic</option>
  <option value="Kodak ">Kodak </option>
  <option value="Mark A Vote">Mark A Vote</option>
  <option value="Model 100">Model 100</option>
  <option value="Model 150">Model 150</option>
  <option value="Model 400">Model 400</option>
  <option value="Model 550">Model 550</option>
  <option value="Model 650">Model 650</option>
  <option value="MTS">MTS</option>
  <option value="MV-464">MV-464</option>
  <option value="NCS">NCS</option>
  <option value="NCS OpScan 5">NCS OpScan 5</option>
  <option value="NCS OpScan 6">NCS OpScan 6</option>
  <option value="OMR 9002">OMR 9002</option>
  <option value="OMR-9002">OMR-9002</option>
  <option value="OMR2000">OMR2000</option>
  <option value="OMR9002">OMR9002</option>
  <option value="OpenElect">OpenElect</option>
  <option value="OpenElect Voting Interface">OpenElect Voting Interface</option>
  <option value="Opscan 5">Opscan 5</option>
  <option value="OpScan 6">OpScan 6</option>
  <option value="Optech">Optech</option>
  <option value="OpTech 2">OpTech 2</option>
  <option value="Optech 400C">Optech 400C</option>
  <option value="Optech III-P Eagle">Optech III-P Eagle</option>
  <option value="Optech Insight">Optech Insight</option>
  <option value="Patriot">Patriot</option>
  <option value="Patriot Marksense Scanner">Patriot Marksense Scanner</option>
  <option value="PCS">PCS</option>
  <option value="Shouptronic 1242">Shouptronic 1242</option>
  <option value="Teamwork Model 25">Teamwork Model 25</option>
  <option value="VMR 138">VMR 138</option>
  <option value="Vote-PAD Ballot Marking System">Vote-PAD Ballot Marking System</option>
  <option value="Vote-Trakker">Vote-Trakker</option>
  <option value="WinScan">WinScan</option>
  <option value="WinVote">WinVote</option>
</select>
<input type="submit" value="Search">
</form>
    </div>
</script>


  			<h2 id="map-title">Verifier</h2>
      <div style="width:994px;">
				<article>			

  		<div id="body" style="float:left;">
  		</div>

      <div class="sidebar-main">  	
        <div id="info" class="sidebar-nav well sidebar-box" style="display:none;">
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
