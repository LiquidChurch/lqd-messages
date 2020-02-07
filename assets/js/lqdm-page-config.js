/**
 * Liquid Messages Admin Functionality
 *
 * Licensed under the GPLv2+ license.
 */

window.LqdMAdmin = window.LqdMAdmin || {};

( function (window, document, $, LqdMAdmin) {

    var self = this;

    var $sort_btn = $('.sort-btn'),
        $update_btn = $('.update-btn'),
        $reset_btn = $('.reset-btn'),
        $lqdm_config_page_wrap = $('.lqdm-config-wrap'),
        $lqdm_config_form = $('.lqdm-config-form');


    /**
     * post date sort button click event
     * for both all and individual
     */
    $sort_btn.click(function (e) {
        var that = this;
        if ($(that).hasClass('single')) {
            var parentForm = $(this).parents('form');
            $(parentForm[0]).find('input[type="number"]').each(function (i, v) {
                $(v).val(i + 1);
                self.updateInputClass(v);
            });
        }
        else {
            var parentForm = $(this).siblings('ul');
            $(parentForm[0]).find('form').each(function (i, v) {
                $(v).find('input[type="number"]').each(function (fi, fv) {
                    $(fv).val(fi + 1);
                    self.updateInputClass(fv);
                });
            });
        }
    });


    /**
     * all-update btn click event for
     * all message config form data submission at once
     */
    $update_btn.click(function (e) {
        var that = this;
        if (!$(that).hasClass('single')) {
            var parentUl = $(this).siblings('ul');
            var $parentForm, formData = [], submitValue = true;
            $(parentUl[0]).find('form').each(function (i, v) {
                var formValid = true;
                $parentForm = $(v);

                $parentForm.find('input[type="number"][required]').each(function (fi, fv) {
                    var inputStatus = null;
                    inputStatus = self.updateInputClass(fv);
                    if (inputStatus === false) {
                        formValid = false;
                    }
                });

                if (formValid === true) {
                    formData.push($parentForm.serialize());
                } else {
                    submitValue = false;
                }
            });

            if(submitValue === true) {
                self.blockUI();
                $.ajax({
                    url: window.ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'lqdm_config_all_series_update',
                        nonce: LqdMAdmin.ajax_nonce,
                        formData: formData,
                    },
                    dataType: 'json'
                }).done(function (response) {
                    $.each(response, function (i, v) {
                        $form = $lqdm_config_page_wrap.find('#series-' + i);
                        $.each(v, function (ci, cv) {
                            var $adjcntLabel = $lqdm_config_page_wrap.find('label[data-post-id="' + ci + '"]');

                            self.modifyLabel($adjcntLabel, cv);
                            self.setFormInputValue($form);
                        });
                    });
                }).always(function (response) {
                    self.unblockUI();
                });
            } else {
                alert(LqdMAdmin.required_message);
            }
        }
    });


    /**
     * reset button click event
     * for both all and individual
     */
    $reset_btn.click(function (e) {
        var that = this;
        if ($(that).hasClass('single')) {
            var parentForm = $(this).parents('form');
            $(parentForm)[0].reset();
            $(parentForm[0]).find('input[type="number"]').each(function (i, v) {
                self.clearInputClass(v);
            });
        }
        else {
            var parentForm = $(this).siblings('ul');
            $(parentForm[0]).find('form').each(function (i, v) {
                $(v)[0].reset();
                $(v).find('input[type="number"]').each(function (fi, fv) {
                    self.clearInputClass(fv);
                });
            });
        }
    });


    /**
     * binding validation classes to input
     * after keyup event
     */
    $lqdm_config_page_wrap.find('input[type="number"][required]').each(function (i, v) {
        $(v).keyup(function (e) {
            self.updateInputClass(this);
        });
    });


    /**
     * blockUI generalize function
     * @param $el
     */
    this.blockUI = function ($el) {
        if (typeof $el !== 'undefined') {
            $el.block({
                message: '<div class="vcenter">' +
                '<div><img width="40px" src="' + LqdMAdmin.path + 'assets/img/spinner.gif" /></div>' +
                '<div><h2>' + LqdMAdmin.blockui_message + '</h2></div>' +
                '</div>'
            });
        } else {
            $.blockUI({
                message: '<div class="vcenter">' +
                '<div><img width="40px" src="' + LqdMAdmin.path + 'assets/img/spinner.gif" /></div>' +
                '<div><h2>' + LqdMAdmin.blockui_message + '</h2></div>' +
                '</div>'
            });
        }
    };


    /**
     * unblockUI generalize function
     * @param $el
     */
    this.unblockUI = function ($el) {
        if (typeof $el !== 'undefined') {
            $el.unblock();
        } else {
            $.unblockUI();
        }
    };


    /**
     * individual message config form submit event
     */
    $lqdm_config_form.on('submit', function (e) {
        e.preventDefault();
        var that = $(this);

        self.blockUI(that);
        $.ajax({
            url: window.ajaxurl,
            method: 'POST',
            data: {
                action: 'lqdm_config_single_series_update',
                nonce: LqdMAdmin.ajax_nonce,
                formData: that.serialize(),
            },
            dataType: 'json'
        }).done(function (response) {
            $.each(response, function (i, v) {
                var $adjcntLabel = $lqdm_config_page_wrap.find('label[data-post-id="' + i + '"]');
                self.modifyLabel($adjcntLabel, v);
                self.setFormInputValue(that);
            });
        }).always(function (response) {
            self.unblockUI(that);
        });
    });


    /**
     * update input field class based on input values
     * for showing validation error
     * @param el - element
     */
    this.updateInputClass = function (el) {
        if ($(el).val() !== '') {
            $(el).addClass('success');
            $(el).removeClass('error');
            return true;
        } else {
            $(el).addClass('error');
            $(el).removeClass('success');
            return false;
        }
    };


    /**
     * clearing out validation classes from inputs
     * @param el - element
     */
    this.clearInputClass = function (el) {
        $(el).removeClass('error');
        $(el).removeClass('success');
    };


    /**
     * show label after successful post_meta update
     * @param $el
     * @param status
     */
    this.modifyLabel = function ($el, status) {
        if (status.status !== false) {
            $el.show();
            $el.removeClass('hidden');
            $el.addClass('success');
            $el.html(status.message);
            setTimeout(function () {
                $el.hide();
                $el.removeClass('success');
                $el.addClass('hidden');
                $el.html('');
            }, 20000);
        }
    };


    /**
     * set input value to post_meta updated value
     * after success
     * @param $el
     */
    this.setFormInputValue = function ($el) {
        $el.find('input[type="number"][required]').each(function (i, v) {
            $(v).attr('value', $(v).val());
        });
    };

}(window, document, jQuery, LqdMAdmin) );
