/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'mage/template',
    'underscore',
    'jquery/ui',
    'mage/validation'
], function ($, mageTemplate, _) {
    'use strict';

    $.widget('mage.directoryFieldUpdater', {
        options: {
            template: '<option value="<%- data.value %>" <% if (data.isSelected) { %>selected="selected"<% } %>>' +
            '<%- data.title %>' +
            '</option>',
            htmlIdPrefix: '',
            defaultCity: '',
            defaultDistrict: '',
            defaultWard: ''
        },
        fieldList: {
            city: 'city',
            cityId: 'city_id',
            district: 'district',
            districtId: 'district_id',
            ward: 'ward',
            wardId: 'ward_id',
            countryId: 'country_id'
        },

        /**
         * @private
         */
        _create: function () {
            var self = this;
            this.optiopTmpl = mageTemplate(this.options.template);
            this._initFields();
            this._updateField('country', 'VN');

            this.cityIdField.on('change', function () {
                self._updateField('city', $(this).val());
                try {
                    self.cityField.val(self.options['dataJson']['VN'][$(this).val()]['full_name']);
                } catch (e) {
                }
            });

            this.districtIdField.on('change', function () {
                try {
                    self.districtField.val(self.options['dataJson']['VN'][self.cityIdField.val()]['districts'][$(this).val()]['full_name']);
                    self._updateField('district', $(this).val());
                } catch (e) {
                }
            });

            this.wardIdField.on('change', function () {
                try {
                    self.wardField.val(self.options['dataJson']['VN'][self.cityIdField.val()]['districts'][self.districtIdField.val()]['wards'][$(this).val()]['full_name']);
                } catch (e) {
                }
            });

            this.cityIdField.val(this.options['defaultCity']).trigger('change');
            this.districtIdField.val(this.options['defaultDistrict']).trigger('change');
            this.wardIdField.val(this.options['defaultWard']).trigger('change');

            return this;
        },

        /**
         * Init fields
         *
         * @private
         */
        _initFields: function () {
            this.cityField = $('#' + this.options.htmlIdPrefix + this.fieldList.city);
            this.cityIdField = $('#' + this.options.htmlIdPrefix + this.fieldList.cityId);
            this.districtField = $('#' + this.options.htmlIdPrefix + this.fieldList.district);
            this.districtIdField = $('#' + this.options.htmlIdPrefix + this.fieldList.districtId);
            this.wardField = $('#' + this.options.htmlIdPrefix + this.fieldList.ward);
            this.wardIdField = $('#' + this.options.htmlIdPrefix + this.fieldList.wardId);
            $('#' + this.options.htmlIdPrefix + this.fieldList.countryId).prop('disabled', true);
        },

        /**
         * Update dropdown list based on field
         *
         * @param field
         * @param fieldValue
         * @private
         */
        _updateField: function (field, fieldValue) {
            switch (field) {
                case 'country':
                    var citiesSort = this._sort(this.options['dataJson'][fieldValue]);
                    citiesSort.unshift(citiesSort[22]);
                    citiesSort.splice(23, 1);
                    citiesSort.unshift(citiesSort[14]);
                    citiesSort.splice(15, 1);
                    citiesSort.unshift(citiesSort[58]);
                    citiesSort.splice(59, 1);
                    citiesSort.unshift(citiesSort[20]);
                    citiesSort.splice(21, 1);
                    citiesSort.unshift(citiesSort[25]);
                    citiesSort.splice(26, 1);
                    _.each(citiesSort, $.proxy(function (value) {
                        this._renderSelectOption(this.cityIdField, value);
                    }, this));
                    break;
                case 'city':
                    this._removeSelectOptions(this.districtIdField);
                    this._removeSelectOptions(this.wardIdField);
                    this.districtIdField.val('').show();
                    this.districtField.val('').hide();

                    if (this.options['dataJson']['VN'][fieldValue]) {
                        var districtSort = this._sort(this.options['dataJson']['VN'][fieldValue]['districts']);
                        if (fieldValue == 1) {
                            districtSort.sort(function (a, b) {
                                if (parseInt(a.name) != NaN && parseInt(b.name) != NaN) {
                                    return parseInt(a.name) - parseInt(b.name);
                                }

                                return -1;
                            })
                        }
                        _.each(districtSort, $.proxy(function (value) {
                            this._renderSelectOption(this.districtIdField, value);
                        }, this));
                        this.districtField.val(districtSort[0].full_name);
                        this._updateField("district",districtSort[0].id);
                    }

                    break;
                case 'district':
                    if (this.options['dataJson']['VN'][this.cityIdField.val()]) {
                        this._removeSelectOptions(this.wardIdField);

                        _.each(this._sort(this.options['dataJson']['VN'][this.cityIdField.val()]['districts'][fieldValue]['wards']), $.proxy(function (value) {
                            this._renderSelectOption(this.wardIdField, value);
                        }, this));

                        this.wardIdField.val('').show();
                        this.wardField.val('').hide();
                    } else {
                        this._removeSelectOptions(this.wardIdField);
                        this.wardIdField.val('').hide();
                        this.wardField.val('').show();
                    }

                    break;
            }
        },

        /**
         * Sort object
         *
         * @param options
         * @returns {Array}
         * @private
         */
        _sort: function (options) {
            return _.sortBy(Object.values(options), 'name');
        },

        /**
         * Remove options from dropdown list
         *
         * @param {Object} selectElement - jQuery object for dropdown list
         * @private
         */
        _removeSelectOptions: function (selectElement) {
            selectElement.find('option').each(function (index) {
                if (index) {
                    $(this).remove();
                }
            });
            $(selectElement).html('');
        },

        /**
         * Render dropdown list
         *
         * @param {Object} selectElement - jQuery object for dropdown list
         * @param {Object} value - directory object
         * @private
         */
        _renderSelectOption: function (selectElement, value) {
            selectElement.append($.proxy(function () {
                var name = value['default_name'].replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, '\\$&'),
                    tmplData,
                    tmpl;

                if (value.code && $(name).is('span')) {
                    value.name = $(name).text();
                }

                tmplData = {
                    value: value['id'],
                    title: value['default_name'],
                    isSelected: false
                };

                if (selectElement.val() === value['id']) {
                    tmplData.isSelected = true;
                }

                tmpl = this.optiopTmpl({
                    data: tmplData
                });

                return $(tmpl);
            }, this));
        }
    });

    return $.mage.directoryFieldUpdater;
});
