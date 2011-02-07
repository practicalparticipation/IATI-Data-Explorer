<xsl:stylesheet version="1.0" 
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:dyn="http://exslt.org/dynamic"
xmlns:math="http://exslt.org/math"
extension-element-prefixes="dyn math">
<xsl:output method="text" encoding="application/json"/> 

<xsl:key name="org" match="provider-org|receiver-org" use="@ref"/>
<xsl:key name="years" match="transaction/value/@value-date" use="substring(.,0,5)"/>
<xsl:template match="/">

<xsl:text>{
 "properties": {
   "policy-marker": {
      "valueType": "item",
      "label": "Policy markers"
   },
   "sector": {
      "valueType": "item",
      "label": "Sector"
   },
   "date": {
      "valueType": "date",
      "label": "Transaction Date"
   },
   "provider-org" : {
      "valueType":"item",
      "label":"Providing Organisation"
   },
   "receiver-org" : {
      "valueType":"item",
      "label":"Receiving Organisation"
   },
   "value" : {
	"valueType":"currency",
	"label":"Transaction Value"
   },
   "description" : {
	"label":"Description"
   }

  },
"items": 
  [ </xsl:text>

<xsl:for-each select="/iati-activities/iati-activity[@hierarchy='1']">
 <xsl:text>{</xsl:text> "type": "project",
    "id": "<xsl:value-of select="iati-identifier"/>", <xsl:variable name="id" select="iati-identifier"/>
    "uri": "<xsl:call-template name="projectURL"> <xsl:with-param name="id" select="iati-identifier"/>  </xsl:call-template>",
    "label": "<xsl:value-of select="title"/>",
    "type": "project",
    "description": "<xsl:value-of select="description"/>",
    "recipient-country": "<xsl:call-template name="fetchValue"> <xsl:with-param name="value" select="'recipient-country'"/>
                        <xsl:with-param name="parent" select="related-activity[@type=1]"/>
                        <xsl:with-param name="children" select="related-activity[@type=2]"/>  </xsl:call-template>",
    "recipient-country-code": "<xsl:call-template name="fetchValue"> <xsl:with-param name="value" select="'recipient-country/@code'"/>
                        <xsl:with-param name="parent" select="related-activity[@type=1]"/>
                        <xsl:with-param name="children" select="related-activity[@type=2]"/>  </xsl:call-template>",
    "start-date": "<xsl:value-of select="translate(activity-date[@type='start-actual'],'Z','')"/>",   <!--NB. Need to handle for when start actual doesn't exist....-->
    "end-date": "<xsl:value-of select="translate(activity-date[@type='end-actual'],'Z','')"/>",
    "activity-status": "<xsl:value-of select="activity-status"/>", <!--Codelist available-->
    "total-committments": <xsl:value-of select="sum(//transaction[transaction-type/@code='C']/value)"/>,
    "timeline": <xsl:variable name="max" select="math:max(//transaction[transaction-type/@code='C']/value)"/>"&amp;chbh=r,0.5,1.5&amp;chd=t:<xsl:for-each select="//transaction/value/@value-date[generate-id() = generate-id(key('years',substring(.,0,5))[1])]"><xsl:sort select="substring(.,0,5)"/><xsl:variable name="year" select="substring(.,0,5)"/><xsl:value-of select="dyn:evaluate(sum(//iati-activity/transaction[transaction-type/@code='C']/value[substring(@value-date,0,5)=$year]))"/>,</xsl:for-each>0&amp;chds=0,<xsl:value-of select="$max"/>&amp;null=100&amp;chxt=x&amp;chxl=0:|<xsl:for-each select="//transaction/value/@value-date[generate-id() = generate-id(key('years',substring(.,0,5))[1])]"><xsl:sort select="substring(.,0,5)"/><xsl:value-of select="substring(.,3,2)"/>|</xsl:for-each>&amp;chdlp=t&amp;chdl=Budget of <xsl:value-of select="dyn:evaluate(sum(//iati-activity/transaction[transaction-type/@code='C']/value))"/> committed"

  <xsl:text>},</xsl:text>
</xsl:for-each>

<xsl:for-each select="/iati-activities/iati-activity/transaction[not(transaction-type/@code='C')]">
  <xsl:text>{</xsl:text> "type": "transaction",
    "id": "<xsl:value-of select="translate(value/@value-date,'Z','')"/>-<xsl:value-of select="value"/>",
    "uri": "<xsl:call-template name="projectURL"> <xsl:with-param name="id" select="../iati-identifier"/>  </xsl:call-template>",
    "label": "<xsl:value-of select="translate(value/@value-date,'Z','')"/> - <xsl:value-of select="description"/>",
    "transaction-type": "<xsl:value-of select="transaction-type"/>",
    "value": "<xsl:value-of select="value"/>",
    "description": "<xsl:value-of select="description"/><xsl:value-of select="transaction-date"/>",
    "date": "<xsl:value-of select="translate(value/@value-date,'Z','')"/>",
    "date-text": "<xsl:value-of select="translate(translate(value/@value-date,'Z',''),'-','_')"/>",
    "provider-org" : "<xsl:value-of select="provider-org/@ref"/>",
    "receiver-org" : "<xsl:value-of select="receiver-org/@ref"/>",
    "currency" : "<xsl:value-of select="value/@currency"/>"

  <xsl:text>},
  </xsl:text>
</xsl:for-each>


<!--Pull out each unique organisation and create data for them-->
<xsl:for-each select="//provider-org[generate-id() = generate-id(key('org',@ref)[1])]|//receiver-org[generate-id() = generate-id(key('org',@ref)[1])]">
  <xsl:text>{</xsl:text> "type": "organisation",
  "id": "<xsl:value-of select="@ref"/>",
  "label": "<xsl:value-of select="."/>"
  <xsl:if test="position() != last()"><xsl:text>},</xsl:text></xsl:if><xsl:if test="position() = last()"><xsl:text>}</xsl:text></xsl:if>
</xsl:for-each>

  <xsl:text>]}</xsl:text>
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

 <xsl:template name="projectURL"><!--Designed to be extended to provide authoritive URLs for different IATI Providing organisations-->
   <xsl:param name="id" select="''"/>
       <xsl:value-of select="concat('http://projects.dfid.gov.uk/project.aspx?Project=',substring($id,6,6),'#',substring($id,13,3))" />
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
