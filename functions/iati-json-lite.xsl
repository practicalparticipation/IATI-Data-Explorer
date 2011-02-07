<xsl:stylesheet version="1.0" 
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:dyn="http://exslt.org/dynamic"
xmlns:math="http://exslt.org/math"
extension-element-prefixes="dyn math">
<xsl:output method="text" encoding="application/json"/> 

<xsl:template match="/">

<xsl:text>{
 "properties": {
   "participating-org" : {
     "label": "Participating Organisation",
     "pluralLabel": "Participating Organisations"
    },
   "reporting-org": {
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
      "label": "Policy markers"
   },
   "sector": {
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

<xsl:for-each select="/iati-activities/iati-activity[not(activity-status='Post-completion')]">
  <xsl:text>{</xsl:text> "type": "activity",
    "id": "<xsl:value-of select="iati-identifier"/>", <xsl:variable name="id" select="iati-identifier"/>
    "uri": "<xsl:call-template name="urlPattern"> <xsl:with-param name="org" select="reporting-org/@ref"/><xsl:with-param name="id" select="iati-identifier"/>  </xsl:call-template>",
    "label": "<xsl:value-of select="title"/>",
    "type": "<xsl:value-of select="concat('type-',@hierarchy)"/>",
    "description": "<xsl:value-of select="description"/>",
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
    "policy-marker": [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="policy-marker[@significance &gt; 0]"/> </xsl:call-template> ], 
    "sector": [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="sector/@code"/> </xsl:call-template> ], 
    "sector-amounts": [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="sector/@percentage"/> </xsl:call-template> ], 
    "components":  [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="related-activity[@type=2]/@ref"/> </xsl:call-template> ],
    "parents":  [ <xsl:call-template name="join"> <xsl:with-param name="valueList" select="related-activity[@type=1]/@ref"/> </xsl:call-template> ],
    "recipient-country": "<xsl:value-of select="recipient-country"/>",
    "recipient-country-code": "<xsl:value-of select="recipient-country-code"/>",
    "latlng":  "<xsl:value-of select="geocoded-latlng"/>",
    "geotype":  "<xsl:value-of select="geocoded-type"/>",
    "timeline": ""
  <xsl:text>},
  </xsl:text>
</xsl:for-each>

  <xsl:text>]}</xsl:text>
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

</xsl:stylesheet>
