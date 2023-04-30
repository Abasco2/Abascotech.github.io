var baselAdminModule, basel_media_init;

(function($) {
    "use strict";
    // Class for import box element.
    var ImportBox = function( $form ) {

        this.form = $form;

        this.interval = 0;

        this.sequence = false;

        this.mainArea = $('.basel-main-import-area');

        this.responseArea = this.form.find('.basel-response');
        
        this.progressBar = this.form.find('.basel-import-progress');

        this.verSelect = this.form.find('.basel_version');

        this.pagePreviews();

        // Events 
        $form.on('submit', { importBox: this}, this.formSubmit )

    };

    ImportBox.prototype.formSubmit = function(e) {
        e.preventDefault();

        var importBox = e.data.importBox;

        var $form = importBox.form;

        if( $form.hasClass('form-in-action') ) return;

        $form.addClass('form-in-action');

        var version = $form.find('.basel_version').val();

        if( $form.find('#full_import').prop('checked') == true ) {
            importBox.sequence = true;
            version = $form.find('.basel_versions').val();

            var subLenght = 3;

            var ajaxSuccess = function( response ) {

                if( ! versions[i] ) {
                    // importBox.handleResponse(response);
                    // importBox.responseArea.html( '' ).fadeIn();
                }
            };

            var ajaxComplete = function() {

                if( ! versions[i] ) {

                    importBox.form.removeClass('form-in-action');

                    importBox.updateProgress( importBox.progressBar, 100, 0 );

                    importBox.initialClearer = setTimeout(function() {
                        importBox.destroyProgressBar(200);
                    }, 2000 );

                    importBox.mainArea.addClass( "imported-full right-after-import imported-" +  versions.join(" imported-") );
                    importBox.mainArea.find('.full-import-box').remove();
                } else {
                    importBox.updateProgress( importBox.progressBar, progressSteps * i, 350 );
                    importBox.callImportAJAX( versions.slice(i, i + subLenght).join(','), ajaxSuccess, ajaxComplete );
                    i = i + subLenght;
                }
            };

            var versions = version.split(',');
            var i = 0;
            var progressSteps = 95 / versions.length;

            importBox.callImportAJAX( versions[i++], ajaxSuccess, ajaxComplete );

            importBox.updateProgress( importBox.progressBar, progressSteps, 350 );

            return;
        }

        clearInterval( importBox.initialClearer );

        importBox.fakeLoading( 30, 50, 70 );

        importBox.clearResponseArea();

        importBox.callImportAJAX( version, function(response) {

            importBox.clearResponseArea();
            importBox.handleResponse(response);

        }, function() {

            importBox.clearFakeLoading();

            importBox.form.removeClass('form-in-action');

            importBox.updateProgress( importBox.progressBar, 100, 0 );

            importBox.progressBar.parent().find('.basel-notice').remove();

            importBox.mainArea.addClass( "right-after-import imported-" +  version );
            // importBox.mainArea.removeClass( "imported-full");

            importBox.initialClearer = setTimeout(function() {
                importBox.destroyProgressBar(200);
            }, 2000 );
        } );
    };


    ImportBox.prototype.callImportAJAX = function( version, success, complete ) {
        var box = this;

        $.ajax({
            url: baselConfig.ajax,
            data: {
                basel_version: version,
                action: "basel_import_data",
				sequence: box.sequence,
				security: baselConfig.import_nonce,
            },
            timeout: 1000000,
            success: function( response ) {

                if( success ) success( response );

            },
            error: function( response ) {
                box.responseArea.html( '<div class="basel-warning">Import AJAX problem. Please, try import data manually.</div>' ).fadeIn();
                console.log('import ajax ERROR');
            },
            complete: function() {

                if( complete ) complete();

                //console.log('import ajax complete');
            },
        });
    };

    ImportBox.prototype.handleResponse = function( response ) {
        var rJSON = { status: '', message: '' };

        try {
            rJSON = JSON.parse(response);
        } catch( e ) {}           

        if( ! response ) {
            this.responseArea.html( '<div class="basel-warning">Empty AJAX response, please try again.</div>' ).fadeIn();
        } else if( rJSON.status == 'success' ) {
            console.log(rJSON.message);
            this.responseArea.html( '<div class="basel-success">All data imported successfully!</div>' ).fadeIn();
        } else if( rJSON.status == 'fail' ) {
            this.responseArea.html( '<div class="basel-error">' + rJSON.message + '</div>' ).fadeIn();
        } else {
            this.responseArea.html( '<div class="">' + response + '</div>' ).fadeIn();
        }

    };


    ImportBox.prototype.fakeLoading = function(fake1progress, fake2progress, noticeProgress) {
        var that = this;
        
        this.destroyProgressBar(0);

        this.updateProgress( this.progressBar, fake1progress, 350 );

        this.fake2timeout = setTimeout( function() {
            that.updateProgress( that.progressBar, fake2progress, 100 );
        }, 25000 );

        this.noticeTimeout = setTimeout( function() {
            that.updateProgress( that.progressBar, noticeProgress, 100 );
            that.progressBar.after( '<p class="basel-notice small">Please, wait. Theme needs much time to download all attachments</p>' );
        }, 60000 );

        this.errorTimeout = setTimeout( function() {
            that.progressBar.parent().find('.basel-notice').remove();
            that.progressBar.after( '<p class="basel-notice small">Something wrong with import. Please, try to import data manually</p>' );
        }, 3100000 );
    };

    ImportBox.prototype.clearFakeLoading = function() {
        clearTimeout( this.fake2timeout );
        clearTimeout( this.noticeTimeout );                          
        clearTimeout( this.errorTimeout );
    };

    ImportBox.prototype.destroyProgressBar = function( hide ) {
        this.progressBar.hide( hide ).attr('data-progress', 0).find('div').width(0);
    };

    ImportBox.prototype.clearResponseArea = function() {
        this.responseArea.fadeOut(200, function() {
            $(this).html( '' );
        });
    };

    ImportBox.prototype.updateProgress = function( el, to, interval ) {
        el.show();
        var box = this;

        clearInterval( box.interval );

        var from = el.attr('data-progress'),
            i = from;

        if( interval == 0 ) {
            el.attr('data-progress', 100).find('div').width(el.attr('data-progress') + '%');
        } else {
            box.interval = setInterval(function() {
                i++;
                el.attr('data-progress', i).find('div').width(el.attr('data-progress') + '%');
                if( i >= to ) clearInterval( box.interval );
            }, interval);
        }

    };

    ImportBox.prototype.pagePreviews = function() {
        var preview = this.form.find('.page-preview'),
            image = preview.find('img'),
            dir = image.data('dir'),
            newImage = '';

        image.on('load', function() {
          // do stuff on success
            $(this).removeClass('loading-image');
        }).on('error', function() {
          // do stuff on smth wrong (error 404, etc.)
            $(this).removeClass('loading-image');
        }).each(function() {
            if(this.complete) {
                $(this).removeClass('loading-image');
            } else if(this.error) {
                $(this).removeClass('loading-image');
            }
        });

        this.verSelect.on('change', function() {
            var page = $(this).val();

            if( page == '' || page == '--select--' ) page = 'base';

            newImage = dir + '/' + page + '/preview.jpg';

            image.addClass('loading-image').attr('src', newImage);
        });
    };


    $.fn.import_box = function() {
        new ImportBox( this );
        return this;
    };

    baselAdminModule = (function() {

        var baselAdmin = {

            listElement : function(){
                var $editor = $( '#vc_ui-panel-edit-element' );

                $editor.on( 'vcPanel.shown', function() {
                    if( $editor.attr( 'data-vc-shortcode' ) != 'basel_list' ) return;

                    var $groupField = $editor.find( '[data-param_type="param_group"]' ),
                        $groupFieldOpenBtn = $groupField.find( '.column_toggle:first' );

                    setTimeout( function() {
                        $groupFieldOpenBtn.click();
                    }, 300 );
                } );
            },
            
            sizeGuideInit : function(){
                if ( $.fn.editTable ) {
                    $( '.basel-sguide-table-edit' ).each( function() {
                        $( this ).editTable(); 
                    } );
                }
            },

            importAction: function() {

                $('.basel-import-form').each(function() {
                    $(this).import_box();
                })
            },

            attributesMetaboxes: function() {

                if( ! $('body').hasClass('product_page_product_attributes') ) return;

                var orderByRow = $('#attribute_orderby').parent(),
                    orderByTableRow = $('#attribute_orderby').parents('tr'),
                    //Select swatch size
                    selectedSize = ( baselConfig.attributeSwatchSize != undefined && baselConfig.attributeSwatchSize.length > 1 ) ? baselConfig.attributeSwatchSize : '',
                    labelSelectSize = '<label for="attribute_swatch_size">Attributes swatch size</label>',
                    descriptionSelectSize = '<p class="description">If you will set color or images swatches for terms of this attribute.</p>',
                    selectSize = [
                        '<select name="attribute_swatch_size" id="attribute_swatch_size">',
                            '<option value="default"' + (( selectedSize == 'default' ) ?  ' selected="selected"' : '') + '>Default</option>',
                            '<option value="large"' + (( selectedSize == 'large' ) ?  ' selected="selected"' : '') + '>Large</option>',
                            '<option value="xlarge"' + (( selectedSize == 'xlarge' ) ?  ' selected="selected"' : '') + '>Extra large</option>',
                        '</select>',
                    ].join(''),
                    //Checkbox show attribute on product
                    showOnProduct = ( baselConfig.attributeShowOnProduct != undefined && baselConfig.attributeShowOnProduct.length > 1 ) ? baselConfig.attributeShowOnProduct : '',
                    labelShowAttr = '<label for="attribute_show_on_product">Show attribute label on products</label>',
                    checkboxShowAttr = '<input' + ( ( showOnProduct == 'on' ) ?  ' checked="checked"' : '' ) + ' name="attribute_show_on_product" id="attribute_show_on_product" type="checkbox">',
                    descriptionShowAttr = '<p class="description">Enable this if you want to show this attribute label on products in your store.</p>',
                    metaHTMLTable = [
                        //Select swatch size
                        '<tr class="form-field form-required">',
                            '<th scope="row" valign="top">',
                                labelSelectSize,
                            '</th>',
                            '<td>',
                                selectSize,
                                descriptionSelectSize,
                            '</td>',
                        '</tr>',

                        //Checkbox show attribute on product
                        '<tr class="form-field form-required">',
                            '<th scope="row" valign="top">',
                                labelShowAttr,
                            '</th>',
                            '<td>',
                                checkboxShowAttr,
                                descriptionShowAttr,
                            '</td>',
                        '</tr>',
                    ].join(''),

                    metaHTMLParagraph = [
                        //Select swatch size
                        '<div class="form-field">',
                            labelSelectSize,
                            selectSize,
                            descriptionSelectSize,
                        '</div>',

                        //Checkbox show attribute on product
                        '<div class="form-field">',
                            labelShowAttr,
                            checkboxShowAttr,
                            descriptionShowAttr,
                        '</div>',
                    ].join('');

                if( orderByTableRow.length > 0 ) {
                    orderByTableRow.after( metaHTMLTable );
                } else {
                    orderByRow.after( metaHTMLParagraph );
                }
            },

            product360ViewGallery: function() {

                // Product gallery file uploads.
                var product_gallery_frame;
                var $image_gallery_ids = $( '#product_360_image_gallery' );
                var $product_images    = $( '#product_360_images_container' ).find( 'ul.product_360_images' );

                $( '.add_product_360_images' ).on( 'click', 'a', function( event ) {
                    var $el = $( this );

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if ( product_gallery_frame ) {
                        product_gallery_frame.open();
                        return;
                    }

                    // Create the media frame.
                    product_gallery_frame = wp.media.frames.product_gallery = wp.media({
                        // Set the title of the modal.
                        title: $el.data( 'choose' ),
                        button: {
                            text: $el.data( 'update' )
                        },
                        states: [
                            new wp.media.controller.Library({
                                title: $el.data( 'choose' ),
                                filterable: 'all',
                                multiple: true
                            })
                        ]
                    });

                    // When an image is selected, run a callback.
                    product_gallery_frame.on( 'select', function() {
                        var selection = product_gallery_frame.state().get( 'selection' );
                        var attachment_ids = $image_gallery_ids.val();

                        selection.map( function( attachment ) {
                            attachment = attachment.toJSON();

                            if ( attachment.id ) {
                                attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                                var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                                $product_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
                            }
                        });

                        $image_gallery_ids.val( attachment_ids );
                    });

                    // Finally, open the modal.
                    product_gallery_frame.open();
                });

				// Image ordering.
				if (typeof $product_images.sortable !== 'undefined') {
					$product_images.sortable({
						items: 'li.image',
						cursor: 'move',
						scrollSensitivity: 40,
						forcePlaceholderSize: true,
						forceHelperSize: false,
						helper: 'clone',
						opacity: 0.65,
						placeholder: 'wc-metabox-sortable-placeholder',
						start: function( event, ui ) {
							ui.item.css( 'background-color', '#f6f6f6' );
						},
						stop: function( event, ui ) {
							ui.item.removeAttr( 'style' );
						},
						update: function() {
							var attachment_ids = '';

							$( '#product_360_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
								var attachment_id = $( this ).attr( 'data-attachment_id' );
								attachment_ids = attachment_ids + attachment_id + ',';
							});

							$image_gallery_ids.val( attachment_ids );
						}
					});
				}

                // Remove images.
                $( '#product_360_images_container' ).on( 'click', 'a.delete', function() {
                    $( this ).closest( 'li.image' ).remove();

                    var attachment_ids = '';

                    $( '#product_360_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
                        var attachment_id = $( this ).attr( 'data-attachment_id' );
                        attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $image_gallery_ids.val( attachment_ids );

                    // Remove any lingering tooltips.
                    $( '#tiptip_holder' ).removeAttr( 'style' );
                    $( '#tiptip_arrow' ).removeAttr( 'style' );

                    return false;
                });
            },
            
			variationGallery: function () {

				$('#woocommerce-product-data').on('woocommerce_variations_loaded', function () {

					$('.basel-variation-gallery-wrapper').each(function () {

						var $this = $(this);
						var $galleryImages = $this.find('.basel-variation-gallery-images');
						var $imageGalleryIds = $this.find('.variation-gallery-ids');
						var galleryFrame;

						$this.find('.basel-add-variation-gallery-image').on('click', function (event) {
							event.preventDefault();

							// If the media frame already exists, reopen it.
							if (galleryFrame) {
								galleryFrame.open();
								return;
							}

							// Create the media frame.
							galleryFrame = wp.media.frames.product_gallery = wp.media({
								states: [
									new wp.media.controller.Library({
										filterable: 'all',
										multiple: true
									})
								]
							});

							// When an image is selected, run a callback.
							galleryFrame.on('select', function () {
								var selection = galleryFrame.state().get('selection');
								var attachment_ids = $imageGalleryIds.val();

								selection.map(function (attachment) {
									attachment = attachment.toJSON();

									if (attachment.id) {
										var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
										attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;

										$galleryImages.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '"><a href="#" class="delete basel-remove-variation-gallery-image"><span class="dashicons dashicons-dismiss"></span></a></li>');

										$this.trigger('basel_variation_gallery_image_added');
									}
								});

								$imageGalleryIds.val(attachment_ids);

								$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
								$('#variable_product_options').find('input').eq(0).change();

							});

							// Finally, open the modal.
							galleryFrame.open();
						});

						// Image ordering.
						if (typeof $galleryImages.sortable !== 'undefined') {
							$galleryImages.sortable({
								items: 'li.image',
								cursor: 'move',
								scrollSensitivity: 40,
								forcePlaceholderSize: true,
								forceHelperSize: false,
								helper: 'clone',
								opacity: 0.65,
								placeholder: 'wc-metabox-sortable-placeholder',
								start: function (event, ui) {
									ui.item.css('background-color', '#f6f6f6');
								},
								stop: function (event, ui) {
									ui.item.removeAttr('style');
								},
								update: function () {
									var attachment_ids = '';

									$galleryImages.find('li.image').each(function () {
										var attachment_id = $(this).attr('data-attachment_id');
										attachment_ids = attachment_ids + attachment_id + ',';
									});

									$imageGalleryIds.val(attachment_ids);

									$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
									$('#variable_product_options').find('input').eq(0).change();
								}
							});
						}

						// Remove images.
						$(document).on('click', '.basel-remove-variation-gallery-image', function (event) {
							event.preventDefault();
							$(this).parent().remove();

							var attachment_ids = '';

							$galleryImages.find('li.image').each(function () {
								var attachment_id = $(this).attr('data-attachment_id');
								attachment_ids = attachment_ids + attachment_id + ',';
							});

							$imageGalleryIds.val(attachment_ids);

							$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
							$('#variable_product_options').find('input').eq(0).change();
						});

					});

				});
			},
        };
        
        return {
            init: function() {

                baselAdmin.importAction();

                $(document).ready(function() {
                    baselAdmin.listElement();
                    baselAdmin.sizeGuideInit();
                    baselAdmin.attributesMetaboxes();
                    baselAdmin.product360ViewGallery();
					baselAdmin.variationGallery();
                });
            },

            mediaInit: function(selector, button_selector, image_selector)  {
                var clicked_button = false;
                $(selector).each(function (i, input) {
                    var button = $(input).next(button_selector);
                    button.click(function (event) {
                        event.preventDefault();
                        var selected_img;
                        clicked_button = $(this);
             
                        // // check for media manager instance
                        // if(wp.media.frames.gk_frame) {
                        //     wp.media.frames.gk_frame.open();
                        //     return;
                        // }
                        // configuration of the media manager new instance
                        wp.media.frames.gk_frame = wp.media({
                            title: 'Select image',
                            multiple: false,
                            library: {
                                type: 'image'
                            },
                            button: {
                                text: 'Use selected image'
                            }
                        });
             
                        // Function used for the image selection and media manager closing
                        var gk_media_set_image = function() {
                            var selection = wp.media.frames.gk_frame.state().get('selection');
             
                            // no selection
                            if (!selection) {
                                return;
                            }
             
                            // iterate through selected elements
                            selection.each(function(attachment) {
                                var url = attachment.attributes.url;
                                clicked_button.prev(selector).val(attachment.attributes.id);
                                $(image_selector).attr('src', url).show();
                            });
                        };
             
                        // closing event for media manger
                        wp.media.frames.gk_frame.on('close', gk_media_set_image);
                        // image selection event
                        wp.media.frames.gk_frame.on('select', gk_media_set_image);
                        // showing media manager
                        wp.media.frames.gk_frame.open();
                    });
               });
            }

        }

    }());

})(jQuery);

basel_media_init = baselAdminModule.mediaInit;

jQuery(document).ready(function() {
    baselAdminModule.init();
});
