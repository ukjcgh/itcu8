<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <body>
                <table border="1">
					
                    <tr>
                        <xsl:for-each select="data/fields/*">
                        <th><xsl:value-of select="."/> (<xsl:value-of select="name()"/>)</th>
                        </xsl:for-each>
                    </tr>

                    <xsl:for-each select="data/item">
                    <tr>
                        <xsl:variable name="itemPos" select="position()" />
                        <xsl:for-each select="/data/fields/*">
							<xsl:variable name="valuePath" select="concat('data/item','[',$itemPos,']','/',name())" />
                            <td><xsl:value-of select="$valuePath"/></td>
                        </xsl:for-each>
                    </tr>
                    </xsl:for-each>

                </table>
            </body>
        </html>
    </xsl:template>
</xsl:transform>