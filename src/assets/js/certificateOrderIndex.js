(function ($, window, document, undefined) {
    var pluginName = "certificateOrderIndex",
        defaults = {};

    function Plugin(element, options) {
        this.element = $(element);
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.filters = {};
        this.init();
    }

    Plugin.prototype = {
        init: function () {
            var _this = this;
            $('[data-toggle=\"popover\"]').popover();

            $('.icheck input').iCheck({
                labelHover: false,
                cursor: true,
                handle: 'checkbox',
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            // init Isotope
            var grid = $('.certificate-order').isotope({
                itemSelector: '.info-box',
                layout: 'vertical',
                isInitLayout: false,
                getSortData: {
                    name: '.ca-name',
                    price: '.ca-price parseFloat',
                    fc: '[data-featuresCount]'
                }
            });
            grid.isotope();
            var filterDisplay = $('#filter-display');

            $('.ca-header').on('click', '.ca-sort-link', function (e) {
                e.preventDefault();
                var sortValue = $(this).attr('data-sort-value');
                var $elem = $(this);
                var asc = $elem.hasClass('ca-asc');

                $elem.toggleClass('ca-asc').find('i').toggleClass('fa-sort-asc');
                $elem.toggleClass('ca-desc').find('i').toggleClass('fa-sort-desc');

                // make an array of values
                // sortValue = sortValue.split(',');
                grid.isotope({sortBy: sortValue, sortAscending: asc});
            });

            $('.filter').on('click ifClicked', 'li, input', function (event) {
                if (event.currentTarget.tagName === 'INPUT') {
                    event.stopPropagation();
                    $(event.currentTarget).closest('li').click();

                    return false;
                }
                var target = $(event.currentTarget);
                target.toggleClass('active');
                target.find('input').iCheck('toggle');
                var isChecked = target.hasClass('active');
                var group = target.parents('.filter').attr('data-filter-group');
                var filterGroup = _this.filters[group];
                var filter = target.attr('data-filter');
                if (!filterGroup) {
                    filterGroup = _this.filters[group] = [];
                }

                // add/remove filter
                if (isChecked) {
                    // add filter
                    filterGroup.push(filter);
                } else {
                    // remove filter
                    var index = filterGroup.indexOf(filter);
                    filterGroup.splice(index, 1);
                }

                var comboFilter = _this.getComboFilter();
                grid.isotope({filter: comboFilter});
                filterDisplay.text(comboFilter);
            });
        },
        getComboFilter: function () {
            var _this = this, combo = [];
            for (var prop in _this.filters) {
                var group = _this.filters[prop];
                if (!group.length) {
                    // no filters in group, carry on
                    continue;
                }
                // add first group
                if (!combo.length) {
                    combo = group.slice(0);
                    continue;
                }
                // add additional groups
                var nextCombo = [];
                // split group into combo: [ A, B ] & [ 1, 2 ] => [ A1, A2, B1, B2 ]
                for (var i = 0; i < combo.length; i++) {
                    for (var j = 0; j < group.length; j++) {
                        var item = combo[i] + group[j];
                        nextCombo.push(item);
                    }
                }
                combo = nextCombo;
            }
            var comboFilter = combo.join(', ');
            return comboFilter;
        }
    };

    $.fn[pluginName] = function (options) {
        this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
            }
        });
        return this;
    };
})(jQuery, window, document);
