<?xml version="1.0" encoding="UTF-8"?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/data">
		<b>
			<xsl:value-of select="grid/title" />
		</b>
		<table>

			<tr>
				<xsl:for-each select="grid/columns/*">
					<th>
						<xsl:value-of select="name()" />
					</th>
				</xsl:for-each>
				<th></th>
			</tr>

			<xsl:for-each select="items/item">
				<tr>
					<xsl:variable name="item" select="." />
					<xsl:for-each select="//grid/columns/*">
						<xsl:variable name="fieldCode" select="name()" />
						<td>
							<xsl:value-of select="$item/*[name()=$fieldCode]" />
						</td>
					</xsl:for-each>
					<td>
						<a class="edit-link">edit</a>
						/
						<a class="delete-link">delete</a>
					</td>
				</tr>
			</xsl:for-each>

		</table>
		<a class="add-link">add</a>
	</xsl:template>
</xsl:transform>