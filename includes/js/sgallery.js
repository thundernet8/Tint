/*
 *  Project: S Gallery 
 *  Description: Responsive jQuery Gallery Plugin with CSS3 Animations inspired by http://store.sony.com/webapp/wcs/stores/servlet/ProductDisplay?catalogId=10551&storeId=10151&langId=-1&productId=8198552921666556433#gallery
 *  Author: Sara Soueidan
 *  License: Creative-Commons Attribution Non-Commercial

 Customized: added number of image, for added captions in the HTML, these are hidden while image resizes
 */

;(function ( $, window, document, undefined ) {

    var pluginName = "sGallery",
        defaults = {
            fullScreenEnabled: false
        };

    function Plugin( element, options ) {
        this.element = element;
        this.galleryContainer = $(this.element);
        this.bigItemsList = this.galleryContainer.children('ul:eq(1)');
        this.bigItem = this.bigItemsList.children('li');
        this.options = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.current = "";
        this.slideshow = false;
        this.count = this.bigItem.length;
        this.initialHeight = 'auto';
        this.isFullScreen = false;
        this.$controls = $('.controls');
        this.$control = $('.control');
        this.$grid = $('.grid');
        this.$fsButton = $('.fs-toggle');
        this.$document = $(document);
        this.$window = $(window);
        this.init();
    }

    Plugin.prototype = {

        init: function() {
            var that = this,
                smallItems = this.galleryContainer.find('ul:eq(0)'),
                smallItem = smallItems.children('li'),
                options = this.options;
                

            this.setDelays(smallItems);
            this.bindListHandler(smallItems);
            this.handleQuit();
            this.controlSlideShow(this.count);
            if(options.fullScreenEnabled){
                this.controlFullScreen();
            }
            this.changeHeight();
            this.handleTouch();
        },

        handleTouch: function(){
            var that = this;
            //prevent image from being dragged without affecting its pointer events huhu!
            this.bigItem.on('dragstart', function(event) { event.preventDefault(); });

            var scrollLeftOnSwipe = Hammer(this.element).on("swipeleft", function(event) {
                if(that.slideshow){
                    that.controlLeftRight('next');
                }
            });
            var scrollRightOnSwipe = Hammer(this.element).on("swiperight", function(event) {
                if(that.slideshow){
                    that.controlLeftRight('previous');
                }
            });
            
        },

        changeHeight: function(speed){
            var that = this,
                speed = speed || 0 ,
                currentImg = this.bigItemsList.children('li:eq(' + that.current + ')');

            this.initialHeight = this.galleryContainer.outerHeight(),
            this.minHeight = currentImg.height()
                                +  parseInt(this.bigItem.css('top'))
                                + this.$controls.height() * 2;
            this.adaptHeight(speed);

            //update above values and adapt height again on window resize
            this.$window.load(function(){

                that.$window.resize(function(){

                    that.initialHeight = that.galleryContainer.outerHeight();

                    that.minHeight = that.bigItem.height()
                                    +  parseInt(that.bigItem.css('top'))
                                    + that.$controls.height() * 2;
                    that.adaptHeight(speed);
                   
                });
                that.$window.trigger('resize');
            });
           
            
        },

        adaptHeight: function(speed){

            var that = this,
                height = this.bigItem.outerHeight();
            if(that.slideshow && that.initialHeight < that.minHeight){
                $(that.element).animate({'height': that.minHeight + 'px'}, speed);
            }
            else if(that.slideshow && that.initialHeight > that.minHeight){
                $(this.element).animate({'height': that.minHeight + 'px'}, speed);
            }
        },

        setDelays: function(smallItems){
            smallItems.children('li').each(function(index){
                $(this).css('animation-delay', 0.075 * index + 's');
            });
        },

        bindListHandler: function(smallItems){
            var that = this;

            smallItems.on('click', 'li', function(e){
                e.preventDefault();
                var $this = $(this);
                that.current = $this.index();
                that.fadeAllOut();
                that.showControls();
                that.slideshow = true;
                startImg = that.bigItemsList.children('li:eq(' + that.current + ')');
                //to show index of img in list
                var index = that.current + 1;
                // startImg.find('.img-index').html(index + ' sur ' + that.count);

                $this.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e) {
                    startImg.addClass('fadeInScaleUp').removeClass('fadeOut');
                    that.bigItemsList.css('pointer-events', 'auto');
                    that.changeHeight(600);
                });   
            });
        },

        fadeAllOut: function(){
            this.galleryContainer.children('ul:eq(0)')
                     .children('li')
                     .removeClass('scaleUpFadeIn')
                     .removeClass('showLastSecond')
                     .addClass('scaleDownFadeOut');
            $('.gpagination').animate({'opacity':0});
        },

        fadeAllIn: function(){
            var that = this;
            var dropZone = this.galleryContainer.children('ul:eq(0)').children('li:eq(' + that.current + ')');
            this.galleryContainer.children('ul:eq(0)')
                     .children('li')
                     .not(dropZone)
                     .removeClass('scaleDownFadeOut')
                     .addClass('scaleUpFadeIn');
            $('.gpagination').animate({'opacity':1});            
            dropZone.removeClass('scaleDownFadeOut').addClass('showLastSecond');
        },

        showControls:function(){
            this.$controls.addClass('showControls')
                          .removeClass('hideControls');
        },

        hideControls: function(){
            this.$controls.addClass('hideControls')
                          .removeClass('showControls');
        },

        controlSlideShow: function(count){

            var that = this, key;

            this.$document.on('keydown', function(e){

                var e = e || window.event;
                key = e.keyCode;

                if(key == 37 && that.slideshow){
                    that.current--;
                    if(that.current < 0) { 
                        that.current = count - 1; 
                    }
                    that.moveToNextImage();
                }
                else if(key == 39 && that.slideshow){
                    that.current++;
                    if(that.current == count) { 
                        that.current = 0; 
                    }
                    that.moveToNextImage();
                }
                
            });


            this.$control.on('click', function(){
                var direction = $(this).data('direction');
                that.controlLeftRight(direction);
            });

            
        },

        controlLeftRight: function(direction){
                var direction = direction;

                (direction == 'next') ? this.current++ : this.current--;

                if(this.current < 0) { 
                        this.current = this.count - 1; 
                }
                else if(this.current == this.count) { 
                        this.current = 0; 
                }

                this.moveToNextImage();
        },

        moveToNextImage: function(){
            var that = this;

            var currentImg = this.bigItemsList.children('li:eq(' + that.current + ')');
            //add this to show index of img in list
            var index = this.current + 1;
            // currentImg.find('.img-index').html(index + ' sur ' + that.count);
                              currentImg.addClass('fadeInScaleUp')
                                        .siblings('li')
                                        .filter('.fadeInScaleUp')
                                        .removeClass('fadeInScaleUp')
                                        .addClass('fadeOut')
                                        .one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e) {
                                            $(this).removeClass('fadeOut');
                                        });

            
            this.changeHeight(600);
        },

        handleQuit: function(){

            var that = this;

            this.$document.on('keydown', function(e){
                var e = e || window.event;
                    key = e.keyCode;

                if(key == 16 && that.slideshow){
                    that.quitSlideShow();
                }
            });
            
            this.$grid.on('click', function(){
                that.quitSlideShow();
            });
        },

        controlFullScreen: function(){
            var that = this, gallery = this.element;

            this.$fsButton.css('display', 'inline-block').on('click', function(){
               if (screenfull.enabled) {
                    screenfull.toggle(gallery);
                    if(!that.isFullScreen){
                        $(this).removeClass('icon-fullscreen').addClass('icon-fullscreen-exit');
                        that.isFullScreenfull = true;
                    }
                    else{
                        $(this).removeClass('icon-fullscreen-exit').addClass('icon-fullscreen');
                        that.isFullScreen=false;
                    }
                } 
                else {
                    return false;
                }      
            });
        },

        quitSlideShow: function(test) {
            
            this.hideControls();
            this.fadeAllIn();
            this.slideshow = false;

            var that = this;

            if(!this.isFullScreen){
                this.galleryContainer.animate({'height' : that.initialHeight}, 0, function(){
                    $(this).css('height', 'auto');
                });
            }

            this.bigItemsList.css('pointer-events', 'none');
            var currentImg = this.galleryContainer.children('ul:eq(1)').children('li:eq(' + that.current + ')'),
                  dropZone = this.galleryContainer.children('ul:eq(0)').children('li:eq(' + that.current + ')'),
                    height = dropZone.height() - dropZone.find('.item-price').height(),
                     width = dropZone.width(),
                      left = dropZone.position().left,
                       top = dropZone.position().top,
                     delay = parseFloat(dropZone.css('animation-delay')),
                  duration = parseFloat(dropZone.css('animation-duration')),
                      wait = delay + duration;

            //hide image description while it is resizing
            currentImg.find('.img-caption').css('opacity', '0');
            currentImg.children('img').andSelf().animate({
                'height'     : height,
                'width'      : width ,
                'left'       : left  + 'px',
                'top'        : top  + 'px',
            }, wait * 1000, function(){
                    $(this).removeClass('fadeInScaleUp').removeAttr('style');
                    currentImg.find('.img-caption').css('opacity', '1');
            });
        }
    };

    
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );
