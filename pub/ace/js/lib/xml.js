/*
 * 
 * Intended for data XML only (no support of attributes and namespaces)
 * adds 3 function to any Object:
 * 1. toXmlString(rootTag) - rootTag is required // generate raw XML from Object
 * 2. toObject() // convert Element to standard Object
 * 3. toXmlDocument() // create XML Document from Object to use it for XSLTProcessor
 * 
 * Use this if you need edit XML before pass it to XSLTProcessor... toObject() -> edit -> toXmlDocument()
 * 
 */

Object.prototype.toXmlString = function(rootTag) {

	var object = this;

	if (typeof rootTag == 'undefined') {
		if (getClass(object) == 'Document') {
			rootTag = object.firstChild.nodeName;
			object = object.firstChild;
		} else {
			throw 'rootTag is required paramater';
		}
	}

	if (object instanceof Array) {
		throw 'Array can\'t be a root element, Object expected';
	}

	// convert any other object to standard Object so that it is iterable in standard way
	object = object.toObject();

	return XmlHelper.stringifyObject(object, rootTag);

};

Object.prototype.toObject = function() {

	switch (getClass(this)) {

	case 'Object':
	case 'Array':
		var object = this;
		break;

	case 'Document':
		var object = this.firstChild.toObject();
		break;

	case 'Element':
		var object = XmlHelper.elementToObject.proceed(this);
		break;

	default:
		throw getClass(this) + ' can\'t be converted to Object (not supported)';
		break;

	}

	return object;

};

Object.prototype.toXmlDocument = function(rootTag) {
	return (new DOMParser()).parseFromString(this.toXmlString(rootTag), "text/xml");
};

/*
 * helper functions
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

	'stringifyArray' : function(array, itemTag) {

		var xml = XmlHelper;
		var xmlString = '';

		for ( var key = 0; key < array.length; key++) {

			var value = array[key];
			value = getClass(value) == 'Object' && value.isEmpty() ? '' : value;

			switch (getClass(value)) {

			case 'NULL':
			case 'Function':
				break;

			case 'String':
			case 'Number':
				xmlString += '\n' + xml.open(itemTag) + xml.escape(value) + xml.close(itemTag);
				break;

			case 'Object':
				xmlString += '\n' + xml.stringifyObject(value, itemTag);
				break;

			case 'Array':
				throw 'Array inside Array can\'t be converted to XML, wrap child Array into Object';
				break;

			default:
				throw 'Unexpected value type in Array, can\'t convert it to XML';
				break;

			}
		}

		return xmlString;

	},

	'stringifyObject' : function(object, objectTag) {

		var xml = XmlHelper;
		var xmlString = '';

		for ( var key in object) {
			if (object.hasOwnProperty(key)) {

				var value = object[key];
				value = getClass(value) == 'Object' && value.isEmpty() ? '' : value;

				switch (getClass(value)) {

				case 'NULL':
				case 'Function':
					break;

				case 'String':
				case 'Number':
					xmlString += '\n' + xml.open(key) + xml.escape(value) + xml.close(key);
					break;

				case 'Object':
					xmlString += '\n' + xml.stringifyObject(value, key);
					break;
				case 'Array':
					xmlString += xml.stringifyArray(value, key);
					break;

				default:
					throw 'Unexpected value type in Object, can\'t convert it to XML';
					break;

				}

			}
		}

		// wrap in rootTag
		xmlString = xml.open(objectTag) + xmlString.replace(/\n/g, '\n\t') + '\n' + xml.close(objectTag);

		return xmlString;

	},

	'elementToObject' : {

		'proceed' : function(element) {

			var I = XmlHelper.elementToObject;

			var object = {};
			var nodes = element.childNodes;

			if (nodes.length == 1 && nodes[0].nodeName == '#text') {
				throw 'Node Element:#text can\'t be converted to Object';
			} else {
				for ( var i = 0; i < nodes.length; i++) {

					var node = nodes.item(i);
					var key = I.nodeKey(node);

					// skip text between nodes
					if (key == '#text') {
						continue;
					}

					var value = I.nodeValue(node);

					I.addToObject(object, key, value);

				}
			}

			return object;

		},

		'nodeKey' : function(node) {
			return node.nodeName;
		},

		'nodeValue' : function(node) {
			if (node.childNodes.length == 1 && node.childNodes[0].nodeName == '#text') {
				var value = node.childNodes[0].nodeValue;
			} else {
				if (node.childNodes.length == 0) {
					var value = '';
				} else {
					var value = XmlHelper.elementToObject.proceed(node);
				}
			}
			return value;
		},

		'addToObject' : function(object, key, value) {
			if (object.hasOwnProperty(key)) {// if already isset
				// convert to Array
				if (getClass(object[key]) !== 'Array') {
					object[key] = [ object[key] ];
				}
				object[key].push(value);
			} else {
				object[key] = value;
			}
		}

	}

};