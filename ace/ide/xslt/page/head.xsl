<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/data">

		<title><xsl:value-of select="title" /></title>
		
		<xsl:for-each select="css/item">
			<link rel="stylesheet" href="/ace/css/{.}" />
		</xsl:for-each>

	</xsl:template>
</xsl:stylesheet>