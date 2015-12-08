var $f, $fTop;
(function ($) {
    $(window).scroll(function () {
        try{
            if (typeof  $f == 'undefined') {
                $f = $('.my-form');
            }
            if (typeof  $fTop == 'undefined') {
                $fTop = $f.offset().top;
            }
            var $sTop = $(this).scrollTop()
            $d = $sTop - $fTop;
            if ($sTop > $fTop) {
                if (!$f.hasClass('abPos')) {
                    $f.addClass('abPos');
                }
                $f.css('margin-top', $d);
            } else {
                if ($f.hasClass('abPos')) {
                    $f.removeClass($f);
                    $f.css('margin-top', 0);
                }
            }
        }catch(e){

        }

    })
    $(document).ready(function () {
        try{
            if (typeof  $f == 'undefined') {
                $f = $('.my-form');
            }
            if (typeof  $fTop == 'undefined') {
                $fTop = $f.offset().top;
            }
        }catch (e){

        }

        $(document).on('click', '.ckmark', function () {
            var cb = $('input[type=checkbox]', this);
            if (cb.is(':checked')) {
                cb.prop('checked', false);
                $('.cb', this).removeClass('checked');
            } else {
                cb.prop('checked', true);
                $('.cb', this).addClass('checked');
            }
        });
        //ajaxed tabs
        $('.xs-tabs a').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var url = $this.attr('data-url');
            var type = $this.attr('data-type');
            var keyword = $this.attr('data-keyword');
            $('.xs-tab-con').slideUp('fast');
            $('.xs-tabs a').removeClass('active');
            $this.addClass('active');
            $('.xs-tab-con-' + type).slideDown('fast');
            //
            if ($(this).hasClass('loaded')) {
                return;
            }
            var currentText = $this.text();
            $this.text('Loading...');
            var params = {
                url: url,
                type: type,
                keyword: keyword
            }
            $.ajax({
                url: TURL + '/parts/' + type + '.php',
                type: 'POST',
                data: params,
                success: function (data) {
                    $('.xs-tab-con').slideUp('fast');
                    $('.xs-tab-con-' + type).html(data);
                    $('.xs-tab-con-' + type).slideDown('fast');
                    $this.addClass('loaded');
                    $this.text(currentText);
                },
                error: function (error) {
                    $this.text(currentText);
                }
            })
        });
        $(document).on('click', '.img-con', function () {
            var $this = $(this);
            if ($('input:checkbox', $this).prop('checked') == true) {
                $('.overlay', $this).remove();
                $('input:checkbox', $this).prop('checked', false);
            } else {
                $('input:checkbox', $this).prop('checked', true);
                $this.append('<div class="overlay"></div>');
            }
        });
    })
})(jQuery)