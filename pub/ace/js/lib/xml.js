/*
 * Intended for data XML only (no attributes and namespaces)
 */

XmlHelper = {

	'open' : function(tag) {
		XmlHelper.checkTag(tag);
		return '<' + tag + '>';
	},

	'close' : function(tag) {
		XmlHelper.checkTag(tag);
		return '</' + tag + '>';
	},

	'escape' : function(value) {
		return (value + '').replace(/&/g, '&amp;').replace(/</g, '&lt;');
	},

	'checkTag' : function(tag) {
		tag = tag + '';
		if ((new RegExp('[^0-9A-z_]', 'g')).test(tag)) {
			throw 'Invalid symbol in tagName "' + tag + '"';
		}
		if (!isNaN(tag.charAt(0))) {
			throw 'First symbol in tagName "' + tag + '" can\'t be a digit';
		}
	},

	'indent' : function(n) {
		return (new Array(n + 1)).join('\t');
	},

};

Object.prototype.toXmlString = function(rootTag, level) {

	// helper
	var xml = XmlHelper;

	// initialize and validate variables
	var object = this;
	if (typeof rootTag == 'undefined') {
		if (getClass(object) == 'Document') {
			rootTag = object.firstChild.nodeName;
			object = object.firstChild;
		} else {
			throw 'rootTag is required paramater';
		}
	}
	level = typeof level == 'undefined' ? 1 : level;
	if (level == 1 && object instanceof Array) {
		throw 'Array can\'t be a root element, Object expected';
	}
	var xmlString = '';

	// convert any other object to standard Object so that it is iterable in standard way
	object = object.toObject();

	// CONVERSION
	switch (getClass(object)) {

	case 'Array':

		for ( var key = 0; key < object.length; key++) {
			switch (getClass(object[key])) {

			case 'NULL':
			case 'Function':
				break;

			case 'String':
			case 'Number':
				xmlString += '\n' + xml.indent(level - 1) + xml.open(rootTag) + xml.escape(object[key]) + xml.close(rootTag);
				break;

			case 'Object':
				xmlString += object[key].toXmlString(rootTag, level);
				break;

			case 'Array':
				throw 'Array inside Array can\'t be converted to XML, wrap child Array into Object';
				break;

			default:
				throw 'Unexpected value type in Array, can\'t convert it to XML';
				break;

			}
		}

		break;

	case 'Object':

		for ( var key in object) {
			if (object.hasOwnProperty(key)) {
				switch (getClass(object[key])) {

				case 'NULL':
				case 'Function':
					break;

				case 'String':
				case 'Number':
					xmlString += '\n' + xml.indent(level) + xml.open(key) + xml.escape(object[key]) + xml.close(key);
					break;

				case 'Object':
				case 'Array':
					xmlString += object[key].toXmlString(key, level + 1);
					break;

				default:
					throw 'Unexpected value type in Object, can\'t convert it to XML';
					break;

				}
			}
		}

		xmlString = xml.indent(level - 1) + xml.open(rootTag) + xmlString + '\n' + xml.indent(level - 1) + xml.close(rootTag);
		if (level > 1) {
			xmlString = '\n' + xmlString;
		}

		break;

	default:
		throw 'Unexpected object type';
		break;

	}

	return xmlString;

};

Object.prototype.toObject = function() {

	switch (getClass(this)) {

	case 'Object':
	case 'Array':
		var object = this;
		break;

	case 'Document':
		return this.firstChild.toObject();
		break;

	case 'Element':
		var object = {};
		var nodes = this.childNodes;

		if (nodes.length == 1 && nodes[0].nodeName == '#text') {
			throw 'Node Element:#text can\'t be converted to Object';
		} else {
			for ( var i = 0; i < nodes.length; i++) {

				// skip text between nodes
				if (nodes[i].nodeName == '#text') {
					continue;
				}

				// get key and value
				var key = nodes[i].nodeName;
				if (nodes[i].childNodes.length == 1 && nodes[i].childNodes[0].nodeName == '#text') {
					var value = nodes[i].childNodes[0].nodeValue;
				} else {
					if (nodes[i].childNodes.length == 0) {
						var value = '';
					} else {
						var value = nodes[i].toObject();
					}
				}

				// fill-in object
				if (object.hasOwnProperty(key)) {// if already isset, convert to Array
					if (getClass(object[key]) !== 'Array') {
						object[key] = [ object[key] ];
					}
					object[key].push(value);
				} else {
					object[key] = value;
				}

			}
		}
		break;

	default:
		throw getClass(this) + ' can\'t be converted to Object (not supported)';
		break;

	}

	return object;

}

Object.prototype.toXmlDocument = function(rootTag) {
	return (new DOMParser()).parseFromString(this.toXmlString(rootTag), "text/xml");
}