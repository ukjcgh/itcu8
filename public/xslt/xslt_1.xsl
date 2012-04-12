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
					<xsl:sort select="./*[local-name()=/data/sort/field]" order="{/data/sort/direction}"/>
                    <tr>
                        <xsl:variable name="item" select="." />
                        <xsl:for-each select="/data/fields/*">
							<xsl:variable name="field" select="name()" />
                            <td><xsl:value-of select="$item/*[local-name()=$field]"/></td>
                        </xsl:for-each>
                    </tr>
                    </xsl:for-each>

                </table>
            </body>
        </html>
    </xsl:template>
</xsl:transform>