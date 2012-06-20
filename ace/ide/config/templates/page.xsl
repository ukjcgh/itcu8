<?xml version="1.0" encoding="UTF-8"?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/data">
		<xsl:value-of disable-output-escaping="yes" select="concat('&lt;!DOCTYPE ', doctype, '&gt;')" />
		<html>
			<xsl:copy-of select="head" />
			<body></body>
		</html>
	</xsl:template>
</xsl:transform>