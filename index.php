    <html xml:lang="en" lang="en"
        xmlns="http://www.w3.org/1999/xhtml"
        xmlns:ex="http://simile.mit.edu/2006/11/exhibit#">
    <head>
        <title>IATI Data Explorer</title>

     <?php if($_GET['q']) { ?>
	<link href="./iatixslt.php?q=<?php echo $_GET['q']; ?>" type="application/json" rel="exhibit/data" />
	<script src="http://api.simile-widgets.org/exhibit/2.2.0/exhibit-api.js" type="text/javascript"></script>
 	<script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/time/time-extension.js"></script>
  	<script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/map/map-extension.js?gmapkey=ABQIAAAAGqZ7tXHiGjVqon77O4l7FhQKP9dOpuBHp3S4TzPBrgTbUZ6hlxT4jZNBL5hEXzfWUuEm_uydPT7vSw"></script>
	<script src="./exhibit-helpers.js" type="text/javascript"></script>
     <?php } ?>
	<link rel="stylesheet" type="text/css" href="style.css" title="Default Styles" />
    </head> 
 <body>

<div class="page">
 <h1><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>"><abbr title="International Aid Transparency Initiative">IATI</abbr> Data Explorer</a></h1>
 <form action="." method="get">
   Explore <abbr title="Department for International Development">DFID</abbr> funding to <select name="q">
	<?php include("functions/options.php"); ?>
   </select>
   <input type="submit" value="Explore"/><br/>
   <input type="checkbox" name="tags" value="1">Include Tag Cloud of sectors?
 </form>

<?php if($_GET['q']) { ?>
 <div class="exhibit">
  <div ex:role="exhibit-collection" ex:itemTypes="type-1, type-2"></div>
    <div ex:role="lens" ex:itemTypes="type-1, type-2" style="display:none;" class="exhibit-lens exhibit-ui-protection" 
	ex:formats="date { template: 'MMMM yyyy'; show: date }"> 
	<div class="lens-inner">
	<h2 ex:content=".label" class="name"></h2>
	<div class="iati-image">
		<img ex:src-subcontent="https://chart.googleapis.com/chart?cht=map:fixed=-40,-180,80,180&chs=200x100&chld={{.recipient-country-code}}&chco=676767|4444FF&chm=f{{.recipient-country}},000000,0,0,10"/><br/>
		<img ex:src-subcontent="https://chart.googleapis.com/chart?cht=bvg&chco=4D89F9&chs=200x100&{{.timeline}}"/>
	</div>
	<div class="iati-key-info">
		<span ex:content=".recipient-country"></span> 
		<span ex:content=".start-date"></span> - <span ex:content=".end-date"></span>
		<span ex:if-exists=".activity-status"><span class="field-title">Status:</span> <span ex:content=".activity-status"></span></span>
	</div>
	<div ex:content=".description" class="description"></div>
	<div class="commitments"><span class="field-title">Total funding committed:</span>
            <span ex:content=".currency"></span> <span ex:content=".total-committments"></span>
	</div>
	<div class="iati-aidtype">
	    <span ex:content=".default-flow-type"></span> - 
	    <span ex:content=".default-aid-type"></span> -
	    <span ex:content=".collaboration-type"></span>
	</div>
      <div class="iati-linkages">
	<div class="iati-sector">
		<span class="field-title">Sector/purpose focus:</span> <span ex:content=".sector"></span>
	</div>

	<div class="iati-rio">
		<span class="field-title">Policy markers:</span> <span ex:content=".policy-marker"></span>
	</div>
	<div class="iati-participating">
		<span class="field-title">Participating Organisations:</span> <span ex:content=".participating-org"></span>
	</div>
      </div>
  
      <div class="iati-further">
	 <div ex:if="count(.parents) &gt; 0"> 
		<span><span class="field-title">Parent Project:</span> 
			<span ex:content=".parents"></span>
		</span>
	 </div>
	 <div ex:if="count(.components) &gt; 0"> 
		<span><span class="field-title">Components:</span> 
			<span ex:content=".components" class="exhibit-item"></span>
		</span>
	 </div>
      </div>
  	<div class="iati-links">
 	   <span ex:if=".transaction-count &gt; 0"><a ex:href-subcontent="transactions/?q={{.project-id}}" target="blank">View details of <span ex:content=".transaction-count"></span> transactions for this project</a> - </span>
	      <a ex:href-content=".uri" target="blank">View details on funders website</a>
  	</div>
     </div>
    </div>

    <div ex:role="lens" ex:itemTypes="policy-marker" style="display:none;">
	<span ex:content=".label" class="name"></span>
	Policy markers highlight the key policy thematic issues this project or component addresses or relates to. 
	<div ex:if="contains(.vocabulary, 'DAC')">
		<div class="break">This policy marker comes from the OECD Development Assistance Committee (DAC) 
		<a href="http://www.oecd.org/dac/stats/rioconventions" target="_blank">Rio Convention Markers</a>.
		More data on aid activities worldwide targetting this marker is available form the OECD 'Creditor Reporting System' (CRS).
		</div>
	</div>
	You can use the facet browser to filter to view only projects and components that have a focus on this policy marker.

    </div>

    <div ex:role="lens" ex:itemTypes="sector" style="display:none;">
	<span ex:content="concat('Sector funded: ',.label)" class="name"></span>
	Sector codes are taken from the <a href="http://www.oecd.org/dac/" target="_blank">OECD Development Assistance Committee (DAC) classifications</a>. 
	Check the DAC website for tools allowing you to explore the sectors that different DAC members have funded.

    </div>


    <div ex:role="lens" ex:itemTypes="organisation" style="display:none;">
	<span ex:content=".label" class="name"></span>
	<div class="break">
		<span ex:content=".label"></span> was a participant in this project, in the funding, implementation or in extending the project.
	</div>
	<div class="break">
		<a ex:href-subcontent="http://google.com/search?q={{.label}}" target="_blank">Search the web</a> for more information about this organisation.
	</div>
    </div>

    <table width="100%">
        <tr valign="top">
            <td width="25%" rowspan="2">
		<b>Search</b><br/>
		<div ex:role="facet" ex:facetClass="TextSearch" id="textSearch" ex:label="Search"></div>
		<div ex:role="facet" ex:expression=".total-committments" ex:facetClass="Slider" ex:horizontal="true" ex:precision="100" ex:histogram="true"></div>
                    <div ex:role="facet" ex:expression=".activity-status" ex:height="60"></div>
                    <div ex:role="facet" ex:expression=".default-aid-type" ex:height="80"></div>
                    <div ex:role="facet" ex:expression=".policy-marker"></div>
                    <div ex:role="facet" ex:expression=".sector"></div>
                    <div ex:role="facet" ex:expression=".participating-org"></div>
                    <div ex:role="facet" ex:expression=".recipient-country" ex:height="60"></div>
                    <div ex:role="facet" ex:expression=".type" ex:height="60"></div>
            </td>
	    <td height="1">
	     <?php if($_GET['tags']) { ?>
		<div ex:role="facet" ex:facetClass="Cloud" ex:expression=".sector"></div>
	     <?php } ?>
	    </td>


	</tr>
	<tr>
            <td ex:role="viewPanel" valign="top">

		<div ex:role="view" ex:viewClass="Thumbnail"></div>

		<div ex:role="view" ex:viewClass="Tabular" ex:columns=".label,.description,.total-committments,.start-date,.end-date"></div>

 <div ex:role="view"
     ex:viewClass="Timeline"
     ex:start=".start-date"
     ex:end=".end-date"
     ex:topBandUnit="year"
     ex:colorCoder="finance-colors"
     ex:colorKey=".default-aid-type"
     ex:topBandIntervalPixels="500"
     ex:bottomBandIntervalPixels="1000"
     ex:bubbleWidth="400"
     ex:bubbleHeight="250"
     ex:densityFactor="1"> 
</div>

		  <div ex:role="view"
                        ex:viewClass="Map"
                        ex:label="Location"
                        ex:latlng=".latlng"
                        ex:center="25.2, -32.3"
                        ex:zoom="2"
                        ex:bubbleWidth="300"
                        ex:colorKey=".activity-status"
                        > 
                    </div> 

	<div ex:role="coder" ex:coderClass="ColorGradient" id="finance-colors" ex:gradientPoints="0, #00DEFD; 10000000,#A70800; ></div>
            </td>
        </tr>
    </table>
 </div>
 <?php } else { ?>
	<h2>Wecome to the IATI Explorer</h2>
	
	<div class="intro">
	The IATI Explorer uses the <a href="http://simile-widgets.org/exhibit/" title="Simile Exhibit">browser-based Exhibit tool</a> to provide a view onto <a href="http://iatiregistry.org/">International Aid Transparency Initiative</a> data from the <a href="http://projects.dfid.gov.uk">UK Department for International Development</a>. 
	Find out more about IATI and <a href="http://aidinfolabs.org/aidinfolabs/archives/4">this demonstrator</a> on the <a href="http://aidinfolabs.org/">AidInfo Labs website</a>.
	<p>


	<div style="background: url('images/facets.png') no-repeat; width:170px; height:176px;" class="intro-image"> 
		<div class="intro-text">Drill-down into data with the facet browser</div>
	</div>
	<div style="background: url('images/details.png') no-repeat; width:412px; height:176px;" class="intro-image"> 
		<div class="intro-text">View a detailed summary of each funded project - including quick visualisations of budgeted spend over time</div>
	</div>
	<div style="background: url('images/timeline.png') no-repeat; width:210px; height:176px;" class="intro-image"> 
		<div class="intro-text">Explore projects over time on the timeline</div>
	</div>
	<div style="background: url('images/tags.png') no-repeat; width:290px; height:145px;" class="intro-image"> 
		<div class="intro-text">Turn on the tag cloud to explore the focus of funding</div>
	</div>
	<div style="background: url('images/export.png') no-repeat; width:290px; height:145px;" class="intro-image"> 
		<div class="intro-text">Use the export tool to copy filtered data direct into your spreadsheet</div>
	</div>

	<br clear="all"/>
	<h3>Using the explorer</h3>
	<p>
	<ul>
	 	<li>Select a country or region from the drop-down list above to load details of all the projects DFID have funded in this area / to this organisation. 
		<li>Wait for the Exhibit interface to load (this can take between 10 seconds and a couple of minutes on older computers or for larger datasets)
		<li>Use the faceted browsing boxes on the left to drill down into the data
		<li>Use the 'Thumbnail', 'Table', 'Timeline' and 'Location' tabs to access different interfaces for exploring the data
		<li>Click any links in thumbnail view to see pop-up contextual information 
		<li>You can sort the data by clicking on the current 'sorted by...' value and choosing from the list presented
		<li>You can export your filtered data at any point by hovering over the main display area till the clipboard (<img src="http://api.simile-widgets.org/exhibit/2.2.0/images/liveclipboard-icon.png"/>) icon appears. Choose 'Tab Separated Vaulues' to get data you can paste direct into Excel.
	</ul>
	The DFID Data includes two sorts of entries: projects and components. Both are displayed by default, although you can opt to view just one or the other using a facet at the bottom of the left-hand list. 
	Projects tend not to have budgetary figures attached, so in the majority of cases exploring components only provides more granular information. The relationship between projects and components is shown in thumbnail view.
	</p>
	<hr>
	<p>	
	<b>Notes</b>: The interface you see when you select a country from the list above is generated in your browser. It can take a short while for the IATI data to be transferred to your computer and for the interface to be built, depending on the number of aid projects to be displayed. Exhibit works best in a recent browser such as Firefox or Google Chrome. It does not work well in IE6.
Only countries with aid projects listed as of February 2011 are currently displayed in the drop-down list above. 
	</p>
	<hr>
	<p>
	<b>Credits and code</b>: Thanks to the <a href="http://simile-widgets.org/wiki/Exhibit/">Exhibit</a> team and contributors for producing the framework on which this tool is based. 
Implementation is by <A href="http://www.twitter.com/timdavies">Tim Davies</a> for <A href="http://www.devinit.org/">Development Initiatives</a>. 
Conversion of the DFID IATI XML is carried out using an <a href="iati-json.xsl">XML Style Sheet</a> (with <A href="http://www.exslt.org/">Exslt extensions</a>) and processing in PHP. 
Graphics are provided using the <A href="http://code.google.com/apis/chart/index.html">Google Chart API</a>. Sourcecode <a href="https://github.com/practicalparticipation/IATI-Data-Explorer">available on github</a>.
	</p>
	<p>
	<small>Last updated <?php echo date("d M Y", getlastmod() ); ?></small>

	</div>
 <?php } ?>

</div>
    </body>
    </html>
