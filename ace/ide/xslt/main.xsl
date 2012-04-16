<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/data">
    	<xsl:value-of disable-output-escaping="yes" select="'&lt;!doctype html&gt;'"/>
        <html>
        	<head>
        		<title>title</title>
        	</head>
            <body>
            	<xsl:value-of select="body"/>
            </body>
        </html>
    </xsl:template>
</xsl:transform>