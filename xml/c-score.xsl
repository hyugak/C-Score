<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" />

<xsl:template match="/">
	[
		<xsl:apply-templates select="mulka/export/classes/class"/>
	]
</xsl:template>

<xsl:template match="class">
	<xsl:if test="position() &gt; 1">,</xsl:if>

	{
		"class" : "<xsl:value-of select="name" />"
		, "result-list" : [
			<xsl:for-each select="result-list/competitor">
				<xsl:variable name="competitor-id"><xsl:value-of select="@object-id" /></xsl:variable>
				<xsl:if test="position() &gt; 1">,</xsl:if>
				{
					"rank" : "<xsl:value-of select="@rank" />"
					, "club" : \"<xsl:apply-templates select="/mulka/export/competitors/competitor[@object-id=$competitor-id]/club"/>"
				}
			</xsl:for-each>
		]
	}

</xsl:template>

</xsl:stylesheet>