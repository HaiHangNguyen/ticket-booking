define([
    'Magento_Ui/js/form/element/date',
    'moment',
    'mageUtils',
    'moment-timezone-with-data'
], function(Date, moment, utils) {
    'use strict';

    return Date.extend({
        defaults: {
            options: {
                showsDate: false,
                showsTime: true,
                timeOnly: true,
                timeFormat: 'hh:mm a'
            },
            inputDateFormat: 'hh:mm a',
        },
        initObservable: function () {
            return this._super().observe(['value']);
        },
        onShiftedValueChange: function (shiftedValue) {
            this.value(shiftedValue);
        },

        prepareDateTimeFormats: function () {
            if (this.options.showsTime) {
                this.pickerDateTimeFormat += this.options.timeFormat;
            }

            this.pickerDateTimeFormat = utils.convertToMomentFormat(this.pickerDateTimeFormat);

            if (this.options.dateFormat) {
                this.outputDateFormat = this.options.dateFormat;
            }

            this.inputDateFormat = utils.convertToMomentFormat(this.inputDateFormat);
            this.outputDateFormat = utils.convertToMomentFormat(this.outputDateFormat);

            this.validationParams.dateFormat = this.outputDateFormat;
        },

        onValueChange: function (value) {
            var shiftedValue;

            if (value) {
                if (this.options.showsTime) {
                    shiftedValue = moment.tz(value, 'UTC').tz(this.storeTimeZone);
                } else {
                    shiftedValue = moment(value, this.outputDateFormat);
                }

                if (!shiftedValue.isValid()) {
                    shiftedValue = moment(value, this.inputDateFormat);
                }
                shiftedValue = shiftedValue.format(this.pickerDateTimeFormat);
            } else {
                shiftedValue = '';
            }

            if (shiftedValue == "Invalid date") {
                this.shiftedValue(value);
            } else if (shiftedValue !== this.shiftedValue()) {
                this.shiftedValue(shiftedValue);
            }
        },
    });
});
