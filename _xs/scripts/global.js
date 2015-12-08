(function ($) {    $(document).ready(function () {        function resetSubmitBtn($btn, $this) {            $btn.prop('disabled', false);            $btn.removeClass('xs-loading');            $('span', $btn).text('SIGN UP');        }        function newLetterPopUp() {            var $cookieName = 'showNlp';            var $cookie = $.cookie($cookieName);            if ($cookie == 1) {                return;            } else {                $.cookie($cookieName, 1, {expires: 7});            }            var $overlay = $('.xs-newsletter');            $overlay.fadeIn('fast');            $('body').addClass('no-overflow');            $overlay.addClass('scroll-div');        }        function clearFieldErr() {            $('.fer').slideUp('fast', function () {                $(this).remove();            });        }        function profileUploader() {            try {                var uploader = new ss.SimpleUpload({                    button: $('#profilePic'), // file upload button                    url: TURL + '/_xs/scripts/ajax-uploader/file_upload.php',  /// server side handler                    name: 'uploadfile', // upload parameter name                    progressUrl: TURL + '/_xs/scripts/ajax-uploader/uploadProgress.php', // enables cross-browser progress support (more info below)                    responseType: 'json',                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],                    maxSize: 1024, // kilobytes                    hoverClass: 'ui-state-hover',                    focusClass: 'ui-state-focus',                    disabledClass: 'ui-state-disabled',                    onSubmit: function (filename, extension) {                        // $('.dimmable').append(loader).dimmer('show');                    },                    onComplete: function (filename, response) {                        if (response.success == true) {                            $('#profilePic img').attr('src', SURL + '/wp-content/' + response.url);                            $('#picId').val(response.id)                            //  $('.dimmable').dimmer('hide');                        }                        // do something with response...                    }                });            } catch (Exception) {            }        }        function cvUploader() {            try {                var btn = $('.select-cv')                var uploader = new ss.SimpleUpload({                    button: btn, // file upload button                    url: TURL + '/_xs/scripts/ajax-uploader/file_upload.php', // server side handler                    name: 'uploadfile', // upload parameter name                    progressUrl: TURL + '/_xs/scripts/ajax-uploader/uploadProgress.php', // enables cross-browser progress support (more info below)                    data: {'uploadType': 'cv'},                    responseType: 'json',                    allowedExtensions: ['jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf', 'txt'],                    maxSize: 1024, // kilobytes                    hoverClass: 'ui-state-hover',                    focusClass: 'ui-state-focus',                    disabledClass: 'ui-state-disabled',                    onSubmit: function (filename, extension) {                        btn.addClass('loading');                        $('.cv_file').html('<i class="red minus circle icon"></i> ' + filename);                        isUploading = true;                    },                    onComplete: function (filename, response) {                        if (response.status == true) {                            $('#cv_id').val(response.id);                            btn.html('<i class="plus icon"></i>Change File');                            $('.cv_file').html('<i class="green checkmark icon"></i> ' + filename + ' ( uploaded )');                        } else {                            isUploading = false;                        }                        btn.removeClass('loading');                        // do something with response...                    }                });            } catch (Exception) {            }        }        function certUploader() {            try {                var btn = $('.select-cert')                var uploader = new ss.SimpleUpload({                    button: btn, // file upload button                    url: TURL + '/_xs/scripts/ajax-uploader/file_upload.php', // server side handler                    name: 'uploadfile', // upload parameter name                    progressUrl: TURL + '/_xs/scripts/ajax-uploader/uploadProgress.php', // enables cross-browser progress support (more info below)                    data: {'uploadType': 'cv'},                    responseType: 'json',                    allowedExtensions: ['jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf', 'txt'],                    maxSize: 1024, // kilobytes                    hoverClass: 'ui-state-hover',                    focusClass: 'ui-state-focus',                    disabledClass: 'ui-state-disabled',                    onSubmit: function (filename, extension) {                        btn.addClass('loading');                        $('.cert_file').html('<i class="red minus circle icon"></i> ' + filename);                        isUploading = true;                    },                    onComplete: function (filename, response) {                        if (response.status == true) {                            $('#cert_id').val(response.id);                            btn.html('<i class="plus icon"></i>Change File');                            $('.cert_file').html('<i class="green checkmark icon"></i> ' + filename + ' ( uploaded )');                        } else {                            isUploading = false;                        }                        btn.removeClass('loading');                        // do something with response...                    }                });            } catch (Exception) {            }        }        $('.xs-checkbox').click(function () {            var $this = $(this);            var inp = $('input[type="checkbox"]', this);            if (!inp.is(':checked')) {                $this.addClass('checked');                inp.prop('checked', true);            } else {                $this.removeClass('checked');                inp.prop('checked', false);            }        });        $('.close-btn').click(function () {            $('.xs-newsletter').fadeOut('fast');            $('body').removeClass('no-overflow');            $(this).removeClass('scroll-div');        });        ///        var isUploading = false;        newLetterPopUp();        profileUploader();        cvUploader();        certUploader();        /// AJAX FORM        $('form.xs-ajax').submit(function (e) {            var $this = $(this);            if ($('.form-status').length == 0) {                $(this).append('<div class="form-status"></div>');            } else {                $('.form-status').html('');            }            var $btn = $('button[type=submit]', this)            $btn.prop('disabled', true);            $('span', $btn).text('Loading..');            clearFieldErr();            e.preventDefault();            $btn.addClass('xs-loading');            $.ajax({                type: 'POST',                dataType: 'JSON',                data: $(this).serialize(),                success: function (data) {                    try {                        if (data.status == false) {                            $('.form-status').append('<div class="xs-error">' + data.errors + '</div>');                            resetSubmitBtn($btn, $this);                        } else {                            $('.msg').html('<div class="xs-success">' + data.errors + '</div>');                            if (typeof data.redirect != 'undefined' || data.redirect != '') {                                window.location = data.redirect;                            }                        }                    } catch (e) {                        $('.form-status', $this).html('<div class="xs-error">ERROR : Invalid JSON data</div>');                        resetSubmitBtn($btn, $this);                    }                },                error: function () {                }            });        })    })})(jQuery);