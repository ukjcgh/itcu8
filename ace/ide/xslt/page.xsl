<?xml version="1.0" encoding="UTF-8"?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/data">
		<xsl:value-of disable-output-escaping="yes"
			select="'&lt;!DOCTYPE html&gt;'" />
		<html>
			<head>
				<xsl:value-of select="headHTML" disable-output-escaping="yes" />
			</head>
			<body>
				<xsl:value-of select="bodyHTML" disable-output-escaping="yes" />
			</body>
		</html>
	</xsl:template>
</xsl:transform>