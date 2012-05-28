<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/data">
		<b>
			<xsl:value-of select="config/title" />
		</b>
		<table class="form">
			<xsl:for-each select="config/fields/*">
				<xsl:variable name="fieldCode" select="name()" />
				<tr>
					<td>
						<xsl:value-of select="$fieldCode" />
					</td>
					<td>
						<input type="text" value="{/data/item/*[name()=$fieldCode]}" name="{$fieldCode}" />
					</td>
				</tr>
			</xsl:for-each>
			<tr>
				<td></td>
				<td>
					<button class="form-save-button">save</button>
				</td>
			</tr>
		</table>
	</xsl:template>
</xsl:stylesheet>