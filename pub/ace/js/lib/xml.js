/*
 * 
 * Intended for data XML only (no support of attributes, namespaces and embedded text)
 * 
 * adds 3 function to any Object:
 * 1. toXmlString(rootTag) - rootTag is required // generate raw XML from Object
 * 2. toObject() // convert Element to standard Object
 * 3. toXmlDocument() // create XML Document from Object to use it for XSLTProcessor
 * 
 * Use this if you need edit XML before pass it to XSLTProcessor... toObject() -> edit -> toXmlDocument()
 * 
 */

Object.prototype.toXmlString = function(rootTag) {

	var helper = XmlHelper;

	var object = this;

	if (typeof rootTag == 'undefined') {
		if (getClass(object) == 'Document') {
			rootTag = object.firstChild.nodeName;
			object = object.firstChild;
		} else {
			throw 'rootTag is required paramater';
		}
	}

	if (getClass(object) == 'Array') {
		throw 'Array can\'t be a root element, Object expected';
	}

	// convert any other object to standard Object so that it is iterable in standard way
	object = object.toObject();

	// stringify
	var xml = helper.stringify(rootTag, object);
	// remove "\n" at the beginning
	xml = xml.substring(1);

	return xml;

};

Object.prototype.toObject = function() {

	var helper = XmlHelper;

	return helper.objectify(this);

};

Object.prototype.toXmlDocument = function(rootTag) {
	return (new DOMParser()).parseFromString(this.toXmlString(rootTag), "text/xml");
};

/*
 * 
 * Helper functions
 * 
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

	'stringify' : function(key, value) {

		var helper = XmlHelper;
		var valueClass = getClass(value);

		value = valueClass == 'Object' && value.isEmpty() ? '' : value;

		var func = 'stringify' + getClass(value);

		if (typeof (helper[func]) == 'function') {
			return xml = helper[func](key, value);
		} else {
			throw 'Error: function "' + func + '" not found within helper, can\'t stringify value';
		}

	},

	'stringifyObject' : function(objectTag, object) {

		var helper = XmlHelper;
		var xml = '';

		for ( var key in object) {
			if (object.hasOwnProperty(key)) {
				var value = object[key];
				xml += helper.stringify(key, value);
			}
		}

		xml = '\n' + helper.open(objectTag) + xml.replace(/\n/g, '\n\t') + '\n' + helper.close(objectTag);

		return xml;

	},

	'stringifyArray' : function(itemTag, array) {

		var helper = XmlHelper;
		var xml = '';

		for ( var key = 0; key < array.length; key++) {

			var value = array[key];

			if (getClass(value) == 'Array') {
				throw 'Array inside Array can\'t be converted to XML, wrap child Array into Object';
			}

			xml += helper.stringify(itemTag, value);

		}

		return xml;

	},

	'stringifynull' : function() {
		return '';
	},

	'stringifyFunction' : function() {
		return '';
	},

	'stringifyString' : function(key, value) {
		var helper = XmlHelper;
		return '\n' + helper.open(key) + helper.escape(value) + helper.close(key);
	},

	'stringifyNumber' : function(key, value) {
		return XmlHelper.stringifyString(key, value);
	},

	'objectify' : function(value) {

		var helper = XmlHelper;

		var func = 'objectify' + getClass(value);

		if (typeof (helper[func]) == 'function') {
			return helper[func](value);
		} else {
			if (typeof (helper[func]) == 'object' && typeof (helper[func].proceed) == 'function') {
				return helper[func].proceed(value);
			} else {
				throw 'Error: function "' + func + '" not found within helper, can\'t convert ' + getClass(value)
						+ ' to Object';
			}
		}
	},

	'objectifyObject' : function(object) {
		return object;
	},

	'objectifyArray' : function(array) {
		return array;
	},

	'objectifyDocument' : function(object) {
		return object.firstChild.toObject();
	},

	'objectifyElement' : {

		'proceed' : function(element) {

			var I = XmlHelper.objectifyElement;

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

			var helper = XmlHelper;

			if (node.childNodes.length == 1 && node.childNodes[0].nodeName == '#text') {
				var value = node.childNodes[0].nodeValue;
			} else {
				if (node.childNodes.length == 0) {
					var value = '';
				} else {
					var value = helper.objectify(node);
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

	},

};