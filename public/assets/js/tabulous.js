/*!
 * strength.js
 * Further changes, comments: @aaronlumsden , reza piry ghadim   webkral.ir
 * Licensed under the MIT license
 */
;
(function ($, window, document, undefined) {

    var pluginName = "tabulous",
        defaults = {
            effect: 'scale'
        };

    // $('<style>body { background-color: red; color: white; }</style>').appendTo('head');

    function Plugin(element, options) {
        this.element = element;
        this.$elem = $(this.element);
        this.options = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {

        init: function () {


            //reza piry ghadim

            var phref = $(location).attr('href');
            var res = phref.split("/");
            var lastEl = res[res.length-1];


            //reza piry ghadim


            var links = this.$elem.find('a');

            if(lastEl == 1){
                var firstchild = this.$elem.find('li:first-child').find('a');
            }else if(lastEl == 2){
                var firstchild = this.$elem.find('li:nth-child(2)').find('a');
            }else if(lastEl == 3){
                var firstchild = this.$elem.find('li:nth-child(3)').find('a');
            }else if(lastEl == 4){
                var firstchild = this.$elem.find('li:nth-child(4)').find('a');
            }else{
                var firstchild = this.$elem.find('li:first-child').find('a');
            }

            var lastchild = this.$elem.find('li:last-child').after('<span class="tabulousclear"></span>');

            if (this.options.effect == 'scale') {
                tab_content = this.$elem.find('div').not(':first').not(':nth-child('+lastEl+')').addClass('hidescale').removeClass('setting-div');
            } else if (this.options.effect == 'slideLeft') {
                tab_content = this.$elem.find('div').not(':first').not(':nth-child('+lastEl+')').addClass('hideleft').removeClass('setting-div');
            } else if (this.options.effect == 'scaleUp') {
                tab_content = this.$elem.find('div').not(':first').not(':nth-child('+lastEl+')').addClass('hidescaleup').removeClass('setting-div');
            } else if (this.options.effect == 'flip') {
                tab_content = this.$elem.find('div').not(':first').not(':nth-child('+lastEl+')').addClass('hideflip').removeClass('setting-div');
            }

            var firstdiv = this.$elem.find('.tabs_container');

            if(lastEl == 1){
                var firstdivheight = firstdiv.find('div:first').height();
            }else if(lastEl == 2){
                var firstdivheight = firstdiv.find('div:nth-child(2)').height();
            }else if(lastEl == 3){
                var firstdivheight = firstdiv.find('div:nth-child(3)').height();
            }else if(lastEl == 4){
                var firstdivheight = firstdiv.find('div:nth-child(4)').height();
            }else{
                var firstdivheight = firstdiv.find('div:first').height();
            }


            var alldivs = this.$elem.find('div:first').find('div');
            // var alldivs = this.$elem.find('div:nth-child('+lastEl+')').find('div');

            alldivs.css({'position': 'absolute', 'top': '40px'});

            firstdiv.css('height', firstdivheight + 'px');

            firstchild.addClass('tabulous_active');

            links.bind('click', {myOptions: this.options}, function (e) {
                e.preventDefault();

                var $options = e.data.myOptions;
                var effect = $options.effect;

                var mythis = $(this);
                var thisform = mythis.parent().parent().parent();
                var thislink = mythis.attr('href');
                
                firstdiv.addClass('transition');

                links.removeClass('tabulous_active');
                mythis.addClass('tabulous_active');
                thisdivwidth = thisform.find('div' + thislink).height();

                if (effect == 'scale') {
                    alldivs.removeClass('showscale').removeClass('settingZIndex').removeClass('setting-div').addClass('make_transist').addClass('hidescale');
                    thisform.find('div' + thislink).addClass('make_transist').addClass('showscale').addClass('settingZIndex');
                } else if (effect == 'slideLeft') {
                    alldivs.removeClass('showleft').removeClass('settingZIndex').removeClass('setting-div').addClass('make_transist').addClass('hideleft');
                    thisform.find('div' + thislink).addClass('make_transist').addClass('showleft').addClass('settingZIndex');
                } else if (effect == 'scaleUp') {
                    alldivs.removeClass('showscaleup').removeClass('settingZIndex').removeClass('setting-div').addClass('make_transist').addClass('hidescaleup');
                    thisform.find('div' + thislink).addClass('make_transist').addClass('showscaleup').addClass('settingZIndex');
                } else if (effect == 'flip') {
                    alldivs.removeClass('showflip').removeClass('settingZIndex').removeClass('setting-div').addClass('make_transist').addClass('hideflip');
                    thisform.find('div' + thislink).addClass('make_transist').addClass('showflip').addClass('settingZIndex');
                }


                firstdiv.css('height', thisdivwidth + 'px');


            });


        },

        yourOtherFunction: function (el, options) {
            // some logic
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            new Plugin(this, options);
        });
    };

})(jQuery, window, document);


