<xsl:transform version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/data">
		<xsl:value-of disable-output-escaping="yes"
			select="'&lt;!doctype html&gt;'" />
		<html>
			<head>
				<title>
					<xsl:value-of select="title" />
				</title>
			</head>
			<body>
				<xsl:value-of select="body" disable-output-escaping="yes" />
			</body>
		</html>
	</xsl:template>
</xsl:transform>