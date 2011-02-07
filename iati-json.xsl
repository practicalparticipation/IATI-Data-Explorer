<xsl:stylesheet version="1.0" 
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:dyn="http://exslt.org/dynamic"
xmlns:math="http://exslt.org/math"
extension-element-prefixes="dyn math">
<xsl:output method="text" encoding="application/json"/> 

<xsl:key name="reporting-orgs" match="reporting-org|participating-org" use="@ref"/>
<xsl:key name="policy-marker" match="policy-marker" use="."/>
<xsl:key name="years" match="transaction/value/@value-date" use="substring(.,0,5)"/>
<xsl:key name="sector" match="sector" use="@code"/>
<xsl:template match="/">

<xsl:text>{
 "properties": {
   "participating-org" : {
     "valueType": "item",
     "label": "Participating Organisation",
     "pluralLabel": "Participating Organisations"
    },
   "reporting-org": {
     "valueType": "item",
     "label" : "Reporting organisation"	     
   },
   "components": {
      "valueType": "item",
      "label": "Project Components"
   },
   "parents": {
      "valueType": "item",
      "label": "Parent Project"
   },
   "siblings": {
      "valueType": "item",
      "label": "Related Components/Projects"
   },
   "policy-marker": {
      "valueType": "item",
      "label": "Policy markers"
   },
   "sector": {
      "valueType": "item",
      "label": "Sector"
   },
   "start-date": {
      "valueType": "date",
      "label": "Start Date"
   },
   "end-date": {
      "valueType": "date",
      "label": "End Date"
   },
   "type": {
      "valueType": "item",
      "label": "Type"
   },
   "recipient-country-code": {
      "valueType":"item",
      "label": "Country Code"
   },
   "total-committments": {
      "valueType":"currency",
      "label": "Total of budget committments"
   },
   "recipient-country": {
      "label": "Recieving country"
   },
   "activity-status": {
      "label": "Activity status"
   },
   "collaboration-type": {
      "label": "Collaboration type"
   },
   "default-aid-type": {
      "label": "Aid Type"
   },
   "default-flow-type": {
      "label": "Aid Flow Type"
   }
  },
"items": 
  [ {"id": "type-1", "label":"Project" }, {"id":"type-2","label":"Component" }, </xsl:text>

<xsl:for-each select="/iati-activities/iati-activity">
  <xsl:text>{</xsl:text> "type": "activity",
    "id": "<xsl:value-of select="iati-identifier"/>", <xsl:variable name="id" select="iati-identifier"/>
    "project-id": "<xsl:value-of select="substring(iati-identifier,6,6)"/>", <!--DFID Specific-->
    "uri": "<xsl:call-template name="urlPattern"> <xsl:with-param name="org" select="reporting-org/@ref"/><xsl:with-param name="id" select="iati-identifier"/>  </xsl:call-template>",
    "label": "<xsl:value-of select="title"/>",
    "type": "<xsl:value-of select="concat('type-',@hierarchy)"/>",
    "description": "<xsl:call-template name="fetchValue"> <xsl:with-param name="value" select="'description'"/> 
			<xsl:with-param name="parent" select="related-activity[@type=1]"/>  
			<xsl:with-param name="children" select="related-activity[@type=2]"/>  </xsl:call-template>",
    "start-date": "<xsl:value-of select="translate(activity-date[@type='start-actual'],'Z','')"/>",   <!--NB. Need to handle for when start actual doesn't exist....-->
    "end-date": "<xsl:value-of select="translate(activity-date[@type='end-actual'],'Z','')"/>",
    "activity-status": "<xsl:value-of select="activity-status"/>", <!--Codelist available-->
    "collaboration-type": "<xsl:value-of select="collaboration-type"/>", <!--Codelist available-->
    "default-flow-type": "<xsl:value-of select="default-flow-type"/>", <!--Codelist available-->
    "default-aid-type": [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="default-aid-type"/> </xsl:call-template> ], 
    "reporting-org": "<xsl:value-of select="reporting-org/@ref"/>",
    "participating-org": [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="participating-org/@ref"/> </xsl:call-template> ],
    "currency" : "<xsl:value-of select="@default-currency"/>",
    "total-committments": <xsl:value-of select="sum(transaction[transaction-type/@code='C']/value)"/>,
    "transaction-count": <xsl:value-of select="count(transaction[not(transaction-type/@code='C')])"/>,
    "policy-marker": [ <xsl:call-template name="joinPolicy"> <xsl:with-param name="valueList" select="policy-marker[@significance &gt; 0]"/> </xsl:call-template> ], 
    "sector": [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="sector/@code"/> </xsl:call-template> ], 
    "sector-amounts": [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="sector/@percentage"/> </xsl:call-template> ], 
    "components":  [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="related-activity[@type=2]/@ref"/> </xsl:call-template> ],
    "parents":  [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="related-activity[@type=1]/@ref"/> </xsl:call-template> ],
    "recipient-country": "<xsl:call-template name="fetchValue"> <xsl:with-param name="value" select="'recipient-country'"/>
                        <xsl:with-param name="parent" select="related-activity[@type=1]"/>
                        <xsl:with-param name="children" select="related-activity[@type=2]"/>  </xsl:call-template>",
    "recipient-country-code": "<xsl:call-template name="fetchValue"> <xsl:with-param name="value" select="'recipient-country/@code'"/>
                        <xsl:with-param name="parent" select="related-activity[@type=1]"/>
                        <xsl:with-param name="children" select="related-activity[@type=2]"/>  </xsl:call-template>",
    "latlng":  "<xsl:value-of select="geocoded-latlng"/>",
    "geotype":  "<xsl:value-of select="geocoded-type"/>",
    "timeline": <xsl:variable name="max" select="math:max(transaction[transaction-type/@code='C']/value)"/>"&amp;chbh=r,0.5,1.5&amp;chd=t:<xsl:for-each select="//transaction/value/@value-date[generate-id() = generate-id(key('years',substring(.,0,5))[1])]"><xsl:sort select="substring(.,0,5)"/><xsl:variable name="year" select="substring(.,0,5)"/><xsl:value-of select="dyn:evaluate(sum(//iati-activity[iati-identifier = $id]/transaction[transaction-type/@code='C']/value[substring(@value-date,0,5)=$year]))"/>,</xsl:for-each>0&amp;chds=0,<xsl:value-of select="$max"/>&amp;null=100&amp;chxt=x&amp;chxl=0:|<xsl:for-each select="//transaction/value/@value-date[generate-id() = generate-id(key('years',substring(.,0,5))[1])]"><xsl:sort select="substring(.,0,5)"/><xsl:value-of select="substring(.,3,2)"/>|</xsl:for-each>&amp;chdlp=t&amp;chdl=Budget of <xsl:value-of select="dyn:evaluate(sum(//iati-activity[iati-identifier = $id]/transaction[transaction-type/@code='C']/value))"/> committed"

  <xsl:text>},
  </xsl:text>
</xsl:for-each>

<!--Pull out each unique reporting or partner organisation and create data for them-->
<xsl:for-each select="//reporting-org[generate-id() = generate-id(key('reporting-orgs',@ref)[1])]|//participating-org[generate-id() = generate-id(key('reporting-orgs',@ref)[1])]">
  <xsl:text>{</xsl:text> "type": "organisation",
  "id": "<xsl:value-of select="@ref"/>",
  "label": "<xsl:value-of select="."/>"
  <xsl:if test="position() != last()"><xsl:text>},</xsl:text></xsl:if><xsl:if test="position() = last()"><xsl:text>}</xsl:text></xsl:if>
</xsl:for-each>

<!--Pull out each unique policy marker and create items for them-->
<xsl:for-each select="//policy-marker[generate-id() = generate-id(key('policy-marker',.)[1])]">
  <xsl:if test="position() = 1">,</xsl:if>
  <xsl:text>{</xsl:text> "type": "policy-marker",
  "id": "<xsl:value-of select="concat(@vocabulary,'-',@code)"/>",
  "label": "<xsl:value-of select="."/>",
  "vocabulary": "<xsl:value-of select="@vocabulary"/>"
  <xsl:if test="position() != last()"><xsl:text>},</xsl:text></xsl:if><xsl:if test="position() = last()"><xsl:text>}</xsl:text></xsl:if>
</xsl:for-each>

<!--Pull out each unique policy marker and create items for them-->
<xsl:for-each select="//sector[generate-id() = generate-id(key('sector',@code)[1])]">
  <xsl:if test="position() = 1">,</xsl:if>
  <xsl:text>{</xsl:text> "type": "sector",
  "id": "<xsl:value-of select="@code"/>",
  "label": "<xsl:value-of select="."/>"
  <xsl:if test="position() != last()"><xsl:text>},</xsl:text></xsl:if><xsl:if test="position() = last()"><xsl:text>}</xsl:text></xsl:if>
</xsl:for-each>


  <xsl:text>]}</xsl:text>
</xsl:template>


 <xsl:template name="missingCountry">
   <xsl:param name="childProject" select="''"/>
    <xsl:if test="//iati-activities/iati-activity[iati-identifier]/recipient-country">"recipient-country": "<xsl:value-of select="//iati-activities/iati-activity[iati-identifier]/recipient-country"/>",
   "recipient-country-code": "<xsl:value-of select="//iati-activities/iati-activity[iati-identifier]/recipient-country/@code"/>",</xsl:if>
    <xsl:if test="not(//iati-activities/iati-activity[iati-identifier]/recipient-country)">
   "recipient-country":"Not given", "recipient-country-code":"0",</xsl:if>
 </xsl:template>


 <xsl:template name="fetchValue"> <!-- Fetch value uses the dyn:evaluate function to look for values from related projects (parent or child) where they are missing. -->
   <xsl:param name="value" select="''"/>
   <xsl:param name="parent" select="''"/>
   <xsl:param name="children" select="''"/>
   <xsl:if test="$value">
	 <xsl:value-of select="translate(dyn:evaluate($value),'&quot;','-')"/>
   </xsl:if>
   <xsl:if test="not(dyn:evaluate($value))"><!--Not found the value we want. Check for a child or parent...-->
     <xsl:variable name="variable" select="$value"/>
     <xsl:if test="$parent">
	 <xsl:variable name="identifier" select="$parent/@ref"/>
	 <xsl:value-of select="normalize-space(translate(dyn:evaluate(concat('//iati-activities/iati-activity[iati-identifier = $identifier]/',$value)),'&quot;','-'))"/>
     </xsl:if>
     <xsl:if test="$children">
	 <xsl:variable name="identifier" select="$children/@ref"/>
	 <xsl:value-of select="normalize-space(translate(dyn:evaluate(concat('//iati-activities/iati-activity[iati-identifier = $identifier]/',$value)),'&quot;','-'))"/>
    </xsl:if>
   </xsl:if>
 </xsl:template>

 <xsl:template name="urlPattern"><!--Designed to be extended to provide authoritive URLs for different IATI Providing organisations-->
   <xsl:param name="org" select="''"/>
   <xsl:param name="id" select="''"/>
   <xsl:choose>
     <xsl:when test="$org = 'GB-1'">
       <xsl:value-of select="concat('http://projects.dfid.gov.uk/project.aspx?Project=',substring($id,6,6))"/>
     </xsl:when>
     <xsl:otherwise>
       <xsl:value-of select="concat('#',$id)" />
     </xsl:otherwise>
   </xsl:choose>
 </xsl:template>

 <xsl:template name="join" >
    <xsl:param name="valueList" select="''"/>
    <xsl:for-each select="$valueList">
      <xsl:choose>
        <xsl:when test="position() = 1">
          <xsl:value-of select="concat('&quot;',.,'&quot;')"/>
        </xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="concat(',','&quot;',.,'&quot;') "/>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:for-each>
  </xsl:template>

 <xsl:template name="joinPolicy" > <!--Customised function to include policy marker vocabularies alongside markers themselves -->
    <xsl:param name="valueList" select="''"/>
    <xsl:for-each select="$valueList">
      <xsl:choose>
        <xsl:when test="position() = 1">
          <xsl:value-of select="concat('&quot;',@vocabulary,'-',@code,'&quot;')"/>
        </xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="concat(',','&quot;',@vocabulary,'-',@code,'&quot;') "/>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:for-each>
  </xsl:template>




</xsl:stylesheet>
