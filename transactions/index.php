    <html xml:lang="en" lang="en"
        xmlns="http://www.w3.org/1999/xhtml"
        xmlns:ex="http://simile.mit.edu/2006/11/exhibit#">
    <head>
        <title>IATI</title>

     <?php if($_GET['q']) { ?>
	<link href="./transactions.php?q=<?php echo $_GET['q']; ?>" type="application/json" rel="exhibit/data" />
	<script src="http://api.simile-widgets.org/exhibit/2.2.0/exhibit-api.js" type="text/javascript"></script>
 	<script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/time/time-extension.js"></script>
	<script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/chart/chart-extension.js" type="text/javascript"></script> 
	<script src="../exhibit-helpers.js" type="text/javascript"></script>
     <?php } ?>
	<link rel="stylesheet" type="text/css" href="../style.css" title="Default Styles" />
    </head> 
 <body>

<div class="page">
 <h1><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>"><abbr title="International Aid Transparency Initiative">IATI</abbr> Transaction Explorer</a> (Experimental)</h1>
 <p> 
 This interface allows you to explore transactions recorded in IATI data against any DFID project. This only displays full transactions, not budgetary committments at present. This is designed to be used alongside the <a href="../">IATI Data Explorer</a>. This exhibit is under active development.
 </p>

 <form action="." method="get">
   Explore <abbr title="Department for International Development">DFID</abbr> project <input type="text" name="q" value="<?php echo $_GET['q']; ?>" size="30"/>
   <input type="submit" value="Explore"/><br/>
 </form>


<?php if($_GET['q']) { ?>
 <div class="exhibit">
   <div ex:role="collection" id="transactions" ex:itemTypes="transaction"></div>
   <div ex:role="collection" id="projects" ex:itemTypes="project"></div>
    <div ex:role="lens" ex:itemTypes="project" style="display:none;" class="exhibit-lens exhibit-ui-protection"
        ex:formats="date { template: 'MMMM yyyy'; show: date }">
        <div class="lens-inner">
        <h2 ex:content="concat('Project Details: ',.label)" class="name"></h2>
        <div class="iati-image">
                <img ex:src-subcontent="https://chart.googleapis.com/chart?cht=map:fixed=-40,-180,80,180&chs=200x100&chld={{.recipient-country-code}}&chco=676767|4444FF&chm=f{{.recipient-country}},000000,0,0,10"/>
                <img ex:src-subcontent="https://chart.googleapis.com/chart?cht=bvg&chco=4D89F9&chs=200x100&{{.timeline}}"/>
        </div>
        <div class="iati-key-info">
                <span ex:content=".recipient-country"></span>
                <span ex:content=".start-date"></span> - <span ex:content=".end-date"></span><br/>
                <span ex:if-exists=".activity-status"><span class="field-title">Status:</span> <span ex:content=".activity-status"></span></span>
        </div>
        <div ex:content=".description" class="description"></div>
        <div class="commitments"><span class="field-title">Total funding committed:</span>
            <span ex:content=".currency"></span> <span ex:content=".total-committments"></span>
        </div>
     </div>
   </div>


    <table width="100%">
        <tr valign="top">
            <td width="250" rowspan="2">
		<b>Search</b><br/>
		<div ex:	role="facet" ex:facetClass="TextSearch" id="textSearch" ex:label="Search" ex:collectionID="transactions"></div>
                    <div ex:role="facet" ex:expression=".transaction-type" ex:collectionID="transactions"></div>
                    <div ex:role="facet" ex:expression=".value" ex:collectionID="transactions" ex:facetClass="Slider" ex:horizontal="true" ex:precision="100" ex:histogram="true" ex:label="Transaction value"></div>
                    <div ex:role="facet" ex:expression=".description" ex:collectionID="transactions"></div>
                    <div ex:role="facet" ex:expression=".receiver-org" ex:collectionID="transactions"></div>
                    <div ex:role="facet" ex:expression=".receiver-org" ex:collectionID="transactions"></div>
            </td>
	    <td height="1" ex:role="viewPanel">
		<div ex:role="view" ex:viewClass="Thumbnail" ex:collectionID="projects" ex:label="Projects"></div>
	    </td>
	</tr>
	<tr>
	
            <td ex:role="viewPanel" valign="top">

		<div ex:role="view" ex:viewClass="Tabular" ex:columns=".date,.description,.provider-org,.receiver-org,.value" ex:collectionID="transactions"  ex:formats="date { template: 'MMMM yyyy'; show: date }"></div>

		<div ex:role="view" ex:viewClass="Thumbnail" ex:collectionID="transactions" ex:label="Detail View"></div>


 <div ex:role="view"
     ex:viewClass="Timeline"
     ex:start=".date"
     ex:topBandUnit="month"
     ex:colorCoder="finance-colors"
     ex:colorKey=".value"
     ex:topBandIntervalPixels="500"
     ex:bottomBandIntervalPixels="1000"
     ex:bubbleWidth="400"
     ex:bubbleHeight="250"
     ex:densityFactor="1"
     ex:collectionID="transactions"> 
</div>

        <div ex:role="view"
	    ex:orders=".date"
            ex:viewClass="BarChartView"
            ex:label="Bar Graph"
            ex:x=".value"
            ex:xLabel="Value"
            ex:y=".date-text"
            ex:yLabel="Date"
	    ex:collectionID="transactions"
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
