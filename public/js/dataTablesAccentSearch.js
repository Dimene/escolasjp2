(function ($) {
    'use strict';

    if (!$ || !$.fn.dataTable || $.fn.dataTable.__accentInsensitiveSearchInstalled) {
        return;
    }

    const DataTable = $.fn.dataTable;
    const normalizeText = function (value) {
        return String(value == null ? '' : value)
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();
    };

    const normalizeSearch = function (value, isRegex) {
        if (!isRegex) {
            return normalizeText(value);
        }

        let normalizedPattern = '';
        let literal = '';
        const flushLiteral = function () {
            normalizedPattern += normalizeText(literal);
            literal = '';
        };

        for (let index = 0; index < value.length; index++) {
            const character = value[index];

            if (character === '\\') {
                flushLiteral();
                normalizedPattern += character;
                if (index + 1 < value.length) {
                    normalizedPattern += value[++index];
                }
            } else if ('^$.*+?()[]{}|'.includes(character)) {
                flushLiteral();
                normalizedPattern += character;
            } else {
                literal += character;
            }
        }

        flushLiteral();
        return normalizedPattern;
    };

    Object.keys(DataTable.ext.type.search).forEach(function (type) {
        const formatter = DataTable.ext.type.search[type];
        DataTable.ext.type.search[type] = function (value) {
            const formatted = formatter(value);
            return typeof formatted === 'string' ? normalizeText(formatted) : formatted;
        };
    });

    DataTable.Api.register('search()', function (input, regex, smart) {
        const context = this.context;

        if (input === undefined) {
            return context.length ? context[0].oPreviousSearch.sSearch : undefined;
        }

        const normalizedInput = normalizeSearch(String(input), regex === true);
        return this.iterator('table', function (settings) {
            if (!settings.oFeatures.bFilter) {
                return;
            }

            DataTable.ext.internal._fnFilterComplete(settings, $.extend({}, settings.oPreviousSearch, {
                sSearch: normalizedInput,
                bRegex: regex == null ? false : regex,
                bSmart: smart == null ? true : smart,
                bCaseInsensitive: true
            }), 1);
        });
    });

    DataTable.Api.register(['columns().search()', 'column().search()'], function (input, regex, smart) {
        if (input === undefined) {
            return this.iterator('column', function (settings, column) {
                return settings.aoPreSearchCols[column].sSearch;
            });
        }

        const normalizedInput = normalizeSearch(String(input), regex === true);
        return this.iterator('column', function (settings, column) {
            if (!settings.oFeatures.bFilter) {
                return;
            }

            $.extend(settings.aoPreSearchCols[column], {
                sSearch: normalizedInput,
                bRegex: regex == null ? false : regex,
                bSmart: smart == null ? true : smart,
                bCaseInsensitive: true
            });

            DataTable.ext.internal._fnFilterComplete(settings, settings.oPreviousSearch, 1);
        });
    });

    const bindSearchInput = function (settings, refreshCache) {
        const api = new DataTable.Api(settings);
        const $input = $(settings.nTableWrapper).find('div.dataTables_filter input');

        $input
            .off('.DT')
            .off('.accentInsensitive')
            .on('input.accentInsensitive keyup.accentInsensitive search.accentInsensitive paste.accentInsensitive cut.accentInsensitive', function () {
                const normalizedSearch = normalizeText(this.value);
                if (api.search() !== normalizedSearch) {
                    api.search(normalizedSearch).draw();
                }
            });

        if (refreshCache) {
            api.rows().invalidate();
            api.search(api.search()).draw(false);
        } else if (api.search()) {
            api.search(api.search()).draw(false);
        }
    };

    $(document).on('init.dt.accentInsensitive', function (event, settings) {
        if (settings && settings.oInstance && settings.oInstance.api) {
            bindSearchInput(settings, false);
        }
    });

    for (let index = 0; index < DataTable.settings.length; index++) {
        bindSearchInput(DataTable.settings[index], true);
    }

    DataTable.__accentInsensitiveSearchInstalled = true;
})(window.jQuery);
