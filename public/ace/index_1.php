<?php

require_once '../../ace/AceXMLElement.php';

function loadAreas() {
	$xml = simplexml_load_file('../../ace/area.xml', 'AceXMLElement');
	$areas = array();
	if ($xml->areas) {
		foreach ($xml->areas->children() as $area) {
			$areas[] = array('code' => (string)$area->code, 'default' => (int)$area->default, 'url' => (string)$area->url);
		}
	}
	return $areas;
}

$areas = loadAreas();

?>
<script src="/ace/js/jquery-1.7.2.min.js"></script>
<body>

<style type="text/css">
table {
		background-color: #000;
		border-spacing: 1px;
}
table td, table th {
	background-color: #fff;
	padding: 0 7px 0 7px;
}
a {
	color: rgb(40,40,198);
}
</style>

<script type="text/javascript">
	function edit_click(){
		$('#modal-shadow').show(); $('#modal-form').show();
	}
	function modal_close_click(){
		 $('#modal-shadow').hide(); $('#modal-form').hide();
		 return false;
	}
</script>

<b>Areas</b>
<table>
	<tr>
		<th>code</th> <th>default</th> <th>url</th> <th></th>
	</tr>
<?php foreach ($areas as $area){ ?>
	<tr>
		<td><?=$area['code']?></td>
		<td><?=$area['default']?'yes':''?></td>
		<td><?=$area['url']?></td>
		<td><a href="#" onclick="return edit_click(); return false">edit</a> / <a href="#">delete</a></td>
	</tr>
<?php } ?>
</table>
<a href="#">add</a>


<div id="modal-shadow" style="display:none;position:absolute; width: 100%; height: 100%; left:0; top: 0; background: #000; opacity:0.2"></div>
<div id="modal-form" style="display:none;position:absolute; width: 100%; height: 100%; left:0; top: 0;">
	<div style="overflow:auto; position:relative; border:1px solid black; background-color: #fff; width:600px; margin: 0 auto; top:20%; padding:0 10px 10px 10px">
		<div style="text-align:right"><a href="#" onclick="modal_close_click(); return false;">close</a></div>
		<table style="border-spacing: 0px;">
			<tr>
				<td>code</td>
				<td><input type="text"/></td>
			</tr>
			<tr>
				<td>default</td>
				<td>
					<select>
						<option>Yes</option>
						<option>No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>url</td>
				<td><input type="text"/></td>
			</tr>
			<tr>
				<td></td>
				<td><button>save</button></td>
			</tr>
		</table>
	</div>
</div>


</body>