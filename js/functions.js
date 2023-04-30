var baselThemeModule;
/* global basel_settings */
(function($) {
	'use strict';

	baselThemeModule = (function() {
		var baselTheme = {
			popupEffect           : 'mfp-move-horizontal',
			shopLoadMoreBtn       : '.basel-products-load-more.load-on-scroll',
			supports_html5_storage: false,
			ajaxLinks             : '.basel-product-categories a, .widget_product_categories a, .widget_layered_nav_filters a, .filters-area a, body.post-type-archive-product:not(.woocommerce-account) .woocommerce-pagination a, body.tax-product_cat:not(.woocommerce-account) .woocommerce-pagination a, .basel-woocommerce-layered-nav a, .widget_product_tag_cloud a, .basel-products-shop-view a, .basel-price-filter a, .woocommerce-widget-layered-nav a, .basel-clear-filters-wrapp a, .basel-woocommerce-sort-by a, .woocommerce-widget-layered-nav-list a, .basel-widget-stock-status a',
			mainCarouselArg       : {
				rtl            : $('body').hasClass('rtl'),
				items          : 1,
				autoplay       : basel_settings.product_slider_autoplay,
				autoplayTimeout: 3000,
				loop           : basel_settings.product_slider_autoplay,
				dots           : false,
				nav            : false,
				autoHeight     : basel_settings.product_slider_auto_height === 'yes',
				navText        : false,
				onRefreshed    : function() {
					$(window).trigger('resize');
				}
			}
		};

		try {
			baselTheme.supports_html5_storage = ('sessionStorage' in window && window.sessionStorage !== null);

			window.sessionStorage.setItem('basel', 'test');
			window.sessionStorage.removeItem('basel');
		}
		catch (err) {
			baselTheme.supports_html5_storage = false;
		}

		return {
			init: function() {
				this.$window = $(window);

				this.$document = $(document);

				this.$body = $('body');

				this.windowWidth = this.$window.width();

				this.productFilters();
				this.woocommercePriceSlider();
				this.updateCartWidgetFromLocalStorage();
				this.categoriesAccordion();
				this.categoriesMenuBtns();
				this.filterDropdowns();
				this.headerBanner();
				this.verticalHeader();
				this.splitNavHeader();
				this.visibleElements();
				this.bannersHover();
				this.parallax();
				this.googleMap();
				this.scrollTop();
				this.quickViewInit();
				this.quickShop();
				this.sidebarMenu();
				this.addToCart();
				this.productImages();
				this.productImagesGallery();
				this.stickyDetails();
				this.mfpPopup();
				this.swatchesVariations();
				this.swatchesOnGrid();
				this.blogMasonry();
				this.blogLoadMore();
				this.productsTabs();
				this.portfolioLoadMore();
				this.equalizeColumns();
				this.menuSetUp();
				this.onePageMenu();
				this.mobileNavigation();
				this.simpleDropdown();
				this.woocommerceWrappTable();
				this.wishList();
				this.compare();
				this.baselCompare();
				this.promoPopup();
				this.cookiesPopup();
				this.productVideo();
				this.product360Button();
				this.stickyFooter();
				this.updateWishListNumberInit();
				this.cartWidget();
				this.ajaxFilters();
				this.filtersArea();
				this.categoriesMenu();
				this.searchFullScreen();
				this.loginTabs();
				this.productAccordion();
				this.countDownTimer();
				this.mobileFastclick();
				this.woocommerceComments();
				this.woocommerceQuantity();
				this.initZoom();
				this.videoPoster();
				this.addToCartAllTypes();
				this.contentPopup();
				this.mobileSearchIcon();
				this.shopHiddenSidebar();
				this.loginSidebar();
				this.stickyAddToCart();
				this.stickySidebarBtn();
				this.lazyLoading();
				this.owlCarouselInit();
				this.baselSliderLazyLoad();
				this.portfolioPhotoSwipe();
				this.sortByWidget();
				this.instagramAjaxQuery();
				this.footerWidgetsAccordion();
				this.wishlist();
				this.variationsPrice();
				this.googleMapInit();
				this.commentImage();
				this.commentImagesUploadValidation();
				this.moreCategoriesButton();
				this.swatchesLimit();
				this.categoriesDropdowns();
				this.miniCartQuantity();
				this.shopMasonry();

				// baselThemeModule.$window.trigger('resize');

				baselThemeModule.$body.addClass('document-ready');

				baselThemeModule.$body.on('updated_cart_totals', function() {
					baselThemeModule.woocommerceWrappTable();
				});
			},

			removeDuplicatedStylesFromHTML: function(html, callback) {
				var $data = $('<div class="temp-wrapper"></div>').append(html);
				var $links = $data.find('link');
				var counter = 0;
				var timeout = false;

				if (0 === $links.length || 'yes' === basel_settings.combined_css) {
					callback(html);
					return;
				}

				setTimeout(function() {
					if (counter <= $links.length && !timeout) {
						callback($($data.html()));
						timeout = true;
					}
				}, 500);

				$links.each(function() {
					var $link = $(this);
					var id = $link.attr('id');
					var href = $link.attr('href');

					$link.remove();

					if ('undefined' === typeof basel_page_css[id]) {
						$('head').append($link.on('load', function() {
							counter++;

							basel_page_css[id] = href;

							if (counter >= $links.length && !timeout) {
								callback($($data.html()));
								timeout = true;
							}
						}));
					} else {
						counter++;

						if (counter >= $links.length && !timeout) {
							callback($($data.html()));
							timeout = true;
						}
					}
				});
			},

			miniCartQuantity: function() {
				var timeout;

				baselThemeModule.$document.on('change input', '.woocommerce-mini-cart .quantity .qty', function() {
					var input = $(this);
					var qtyVal = input.val();
					var itemID = input.parents('.woocommerce-mini-cart-item').data('key');
					var cart_hash_key = basel_settings.cart_hash_key;
					var fragment_name = basel_settings.fragment_name;

					clearTimeout(timeout);

					timeout = setTimeout(function() {
						input.parents('.mini_cart_item').addClass('basel-loading');

						$.ajax({
							url     : basel_settings.ajaxurl,
							data    : {
								action : 'basel_update_cart_item',
								item_id: itemID,
								qty    : qtyVal
							},
							success : function(data) {
								if (data && data.fragments) {

									$.each(data.fragments, function(key, value) {
										if ($(key).hasClass('widget_shopping_cart_content')) {
											var dataItemValue = $(value).find('.woocommerce-mini-cart-item[data-key="' + itemID + '"]');
											var dataFooterValue = $(value).find('.woocommerce-mini-cart__total');
											var $itemSelector = $(key).find('.woocommerce-mini-cart-item[data-key="' + itemID + '"]');

											if (!data.cart_hash) {
												$(key).replaceWith(value);
											} else {
												$itemSelector.replaceWith(dataItemValue);
												$('.woocommerce-mini-cart__total').replaceWith(dataFooterValue);
											}
										} else {
											$(key).replaceWith(value);
										}
									});

									if (baselTheme.supports_html5_storage) {
										sessionStorage.setItem(fragment_name, JSON.stringify(data.fragments));
										localStorage.setItem(cart_hash_key, data.cart_hash);
										sessionStorage.setItem(cart_hash_key, data.cart_hash);

										if (data.cart_hash) {
											sessionStorage.setItem('wc_cart_created', (new Date()).getTime());
										}
									}
								}
							},
							dataType: 'json',
							method  : 'GET'
						});
					}, 500);
				});
			},

			categoriesDropdowns: function() {
				$('.dropdown_product_cat').on('change', function() {
					if ($(this).val()) {
						var this_page;
						var home_url = basel_settings.home_url;
						if (home_url.indexOf('?') > 0) {
							this_page = home_url + '&product_cat=' + jQuery(this).val();
						} else {
							this_page = home_url + '?product_cat=' + jQuery(this).val();
						}
						location.href = this_page;
					} else {
						location.href = basel_settings.shop_url;
					}
				});

				$('.widget_product_categories').each(function() {
					var $select = $(this).find('select');

					if ($().selectWoo) {
						$select.selectWoo({
							minimumResultsForSearch: 5,
							width                  : '100%',
							allowClear             : true,
							placeholder            : basel_settings.product_categories_placeholder,
							language               : {
								noResults: function() {
									return basel_settings.product_categories_no_results;
								}
							}
						});
					}
				});
			},

			swatchesLimit: function() {
				$('.basel-swatches-divider').on('click', function() {
					var $this = $(this);

					$this.parent().find('.swatch-on-grid').removeClass('basel-hidden');
					$this.parent().addClass('basel-all-shown');
				});
			},

			moreCategoriesButton: function() {
				$('.basel-more-cat').each(function() {
					var $wrapper = $(this);

					$wrapper.find('.basel-more-cat-btn a').on('click', function(e) {
						e.preventDefault();
						$wrapper.addClass('basel-show-cat');
					});
				});
			},

			commentImage: function() {
				$('form.comment-form').attr('enctype', 'multipart/form-data');
			},

			commentImagesUploadValidation: function() {
				var $form = $('.comment-form');
				var $input = $form.find('#basel-add-img-btn');
				var allowedMimes = [];

				if ($input.length === 0) {
					return;
				}

				$.each(basel_settings.comment_images_upload_mimes, function(index, value) {
					allowedMimes.push(String(value));
				});

				$form.find('#basel-add-img-btn').on('change', function() {
					$form.find('.basel-add-img-count').text(basel_settings.comment_images_added_count_text.replace('%s', this.files.length));
				});

				$form.on('submit', function(e) {
					$form.find('.woocommerce-error').remove();

					var hasLarge = false;
					var hasNotAllowedMime = false;

					if ($input[0].files.length > basel_settings.comment_images_count) {
						showError(basel_settings.comment_images_count_text);
						e.preventDefault();
					}

					Array.prototype.forEach.call($input[0].files, function(file) {
						var size = file.size;
						var type = String(file.type);

						if (size > basel_settings.comment_images_upload_size) {
							hasLarge = true;
						}

						if ($.inArray(type, allowedMimes) < 0) {
							hasNotAllowedMime = true;
						}
					});

					if (hasLarge) {
						showError(basel_settings.comment_images_upload_size_text);
						e.preventDefault();
					}

					if (hasNotAllowedMime) {
						showError(basel_settings.comment_images_upload_mimes_text);
						e.preventDefault();
					}
				});

				function showError(text) {
					$form.prepend('<ul class="woocommerce-error" role="alert"><li>' + text + '</li></ul>');
				}
			},

			googleMapInit: function() {
				$('.google-map-container').each(function() {
					var $map = $(this);
					var data = $map.data('map-args');

					var config = {
						locations      : [
							{
								lat      : data.latitude,
								lon      : data.longitude,
								icon     : data.marker_icon,
								animation: google.maps.Animation.DROP
							}
						],
						controls_on_map: false,
						map_div        : '#' + data.selector,
						start          : 1,
						map_options    : {
							zoom       : parseInt(data.zoom),
							scrollwheel: 'yes' === data.mouse_zoom
						}
					};

					if (data.json_style) {
						config.styles = {};
						config.styles[basel_settings.google_map_style_text] = JSON.parse(data.json_style);
					}

					if ('yes' === data.marker_text_needed) {
						config.locations[0].html = data.marker_text;
					}

					if ('button' === data.init_type) {
						$map.find('.basel-init-map').on('click', function(e) {
							e.preventDefault();

							if ($map.hasClass('basel-map-inited')) {
								return;
							}

							$map.addClass('basel-map-inited');
							new Maplace(config).Load();
						});
					} else if ('scroll' === data.init_type) {
						baselThemeModule.$window.on('scroll', function() {
							if (window.innerHeight + baselThemeModule.$window.scrollTop() + parseInt(data.init_offset) > $map.offset().top) {
								if ($map.hasClass('basel-map-inited')) {
									return;
								}

								$map.addClass('basel-map-inited');
								new Maplace(config).Load();
							}
						});

						baselThemeModule.$window.on('scroll');
					} else {
						new Maplace(config).Load();
					}
				});
			},

			variationsPrice: function() {
				if ('no' === basel_settings.single_product_variations_price) {
					return;
				}

				$('.variations_form').each(function() {
					var $form = $(this);
					var $price = $form.parent().find('> .price').first();
					var priceOriginalHtml = $price.html();

					$form.on('show_variation', function(e, variation) {
						if (variation.price_html.length > 1) {
							$price.html(variation.price_html);
						}
					});

					$form.on('hide_variation', function() {
						$price.html(priceOriginalHtml);
					});
				});
			},

			wishlist: function() {
				var cookiesName = 'basel_wishlist_count';

				if (baselThemeModule.$body.hasClass('logged-in')) {
					cookiesName += '_logged';
				}

				if (basel_settings.is_multisite) {
					cookiesName += '_' + basel_settings.current_blog_id;
				}

				var $widget = $('.wishlist-info-widget');
				var cookie = Cookies.get(cookiesName);

				if ($widget.length > 0 && 'undefined' !== typeof cookie) {
					try {
						var count = JSON.parse(cookie);
						$widget.find('.wishlist-count').text(count);
					}
					catch (e) {
						console.log('cant parse cookies json');
					}
				}

				baselThemeModule.$body.on('click', '.wishlist-btn-wrapper a, .basel-wishlist-btn a', function(e) {
					var $this = $(this);
					var productId = $this.data('product-id');
					var addedText = $this.data('added-text');
					var key = $this.data('key');

					if ($this.hasClass('added')) {
						return true;
					}

					e.preventDefault();

					$this.addClass('loading');

					$.ajax({
						url     : basel_settings.ajaxurl,
						data    : {
							action    : 'basel_add_to_wishlist',
							product_id: productId,
							key       : key
						},
						dataType: 'json',
						method  : 'GET',
						success : function(response) {
							if (response) {
								$this.addClass('added');
								baselThemeModule.$document.trigger('added_to_wishlist');

								if (response.wishlist_content) {
									updateWishlist(response);
								}

								if ($this.find('span').length > 0) {
									$this.find('span').text(addedText);
								} else {
									$this.text(addedText);
								}
							} else {
								console.log('something wrong loading wishlist data ',
									response);
							}
						},
						error   : function() {
							console.log(
								'We cant add to wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
						},
						complete: function() {
							$this.removeClass('loading');
						}
					});
				});

				baselThemeModule.$body.on('click', '.basel-wishlist-content .basel-remove-button', function(e) {
					var $this = $(this);
					var productId = $this.data('product-id');
					var key = $this.data('key');

					if ($this.hasClass('added')) {
						return true;
					}

					e.preventDefault();

					$this.addClass('loading');

					$.ajax({
						url     : basel_settings.ajaxurl,
						data    : {
							action    : 'basel_remove_from_wishlist',
							product_id: productId,
							key       : key
						},
						dataType: 'json',
						method  : 'GET',
						success : function(response) {
							if (response.wishlist_content) {
								updateWishlist(response);
							} else {
								console.log('something wrong loading wishlist data ',
									response);
							}
						},
						error   : function() {
							console.log(
								'We cant remove from wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
						},
						complete: function() {
							$this.removeClass('loading');
						}
					});
				});

				function updateWishlist(data) {
					if ($widget.length > 0) {
						$widget.find('.wishlist-count').text(data.count);
					}

					var $wishlistContent = $('.basel-wishlist-content');
					if ($wishlistContent.length > 0 && !$wishlistContent.hasClass('basel-wishlist-preview')) {
						$wishlistContent.replaceWith(data.wishlist_content);
					}

					baselThemeModule.swatchesVariations();
					baselThemeModule.btnsToolTips();
					baselThemeModule.countDownTimer();
					baselThemeModule.swatchesLimit();
				}
			},

			footerWidgetsAccordion: function() {
				if (baselThemeModule.windowWidth > 767) {
					return;
				}

				$('.footer-widget-collapse .widget-title').on('click', function() {
					var $title = $(this);
					var $widget = $title.parent();
					var $content = $widget.find('> *:not(.widget-title)');

					if ($widget.hasClass('footer-widget-opened')) {
						$widget.removeClass('footer-widget-opened');
						$content.stop().slideUp(200);
					} else {
						$widget.addClass('footer-widget-opened');
						$content.stop().slideDown(200);
					}
				});
			},

			instagramAjaxQuery: function() {
				$('.instagram-widget').each(function() {
					var $instagram = $(this);
					if (!$instagram.hasClass('instagram-with-error')) {
						return;
					}

					var username = $instagram.data('username');
					var atts = $instagram.data('atts');
					var request_param = username.indexOf('#') > -1 ? 'explore/tags/' + username.substr(1) : username;

					var url = 'https://www.instagram.com/' + request_param + '/';

					$instagram.addClass('loading');

					$.ajax({
						url    : url,
						success: function(response) {
							$.ajax({
								url     : basel_settings.ajaxurl,
								data    : {
									action: 'basel_instagram_ajax_query',
									body  : response,
									atts  : atts
								},
								dataType: 'json',
								method  : 'POST',
								success : function(response) {
									$instagram.parent().html(response);
									baselThemeModule.owlCarouselInit();
								},
								error   : function() {
									console.log('instagram ajax error');
								}
							});
						},
						error  : function() {
							console.log('instagram ajax error');
						}
					});

				});
			},

			sortByWidget: function() {
				if (baselThemeModule.$body.hasClass('basel-ajax-shop-off')) {
					return;
				}

				var $wcOrdering = $('.woocommerce-ordering');

				$wcOrdering.on('change', 'select.orderby', function() {
					var $form = $(this).closest('form');

					$form.find('[name="_pjax"]').remove();

					$.pjax({
						container     : '.main-page-wrapper',
						timeout       : basel_settings.pjax_timeout,
						url           : '?' + $form.serialize(),
						scrollTo      : false,
						renderCallback: function(context, html, afterRender) {
							baselThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
								context.html(html);
								afterRender();
								baselThemeModule.shopPageInit();
								baselThemeModule.$document.trigger('basel-images-loaded');
							});
						}
					});
				});

				$wcOrdering.on('submit', function(e) {
					e.preventDefault(e);
				});
			},

			portfolioPhotoSwipe: function() {
				baselThemeModule.$document.on('click', '.portfolio-enlarge', function(e) {
					e.preventDefault();
					var $parent = $(this).parents('.portfolio-entry');
					var index = $parent.index();
					var items = getPortfolioImages();
					baselThemeModule.callPhotoSwipe(index, items);
				});

				var getPortfolioImages = function() {
					var items = [];
					$('.portfolio-entry').find('figure a img').each(function() {
						var $this = $(this);

						items.push({
							src: $this.attr('src'),
							w  : $this.attr('width'),
							h  : $this.attr('height')
						});
					});
					return items;
				};
			},

			productFilters: function() {
				var removeValue = function($mainInput, currentVal) {
					if ($mainInput.length === 0) {
						return;
					}
					var mainInputVal = $mainInput.val();
					if (mainInputVal.indexOf(',') > 0) {
						$mainInput.val(mainInputVal.replace(',' + currentVal, '').replace(currentVal + ',', ''));
					} else {
						$mainInput.val(mainInputVal.replace(currentVal, ''));
					}
				};

				$('.basel-pf-checkboxes li > .pf-value').on('click', function(e) {
					e.preventDefault();
					var $this = $(this);
					var $li = $this.parent();
					var $widget = $this.parents('.basel-pf-checkboxes');
					var $mainInput = $widget.find('.result-input');
					var $results = $widget.find('.basel-pf-results');

					var multiSelect = $widget.hasClass('multi_select');
					var mainInputVal = $mainInput.val();
					var currentText = $this.data('title');
					var currentVal = $this.data('val');

					if (multiSelect) {
						if (!$li.hasClass('pf-active')) {
							if (!mainInputVal) {
								$mainInput.val(currentVal);
							} else {
								$mainInput.val(mainInputVal + ',' + currentVal);
							}
							$results.prepend('<li class="selected-value" data-title="' + currentVal + '">' + currentText + '</li>');
							$li.addClass('pf-active');
						} else {
							removeValue($mainInput, currentVal);
							$results.find('li[data-title="' + currentVal + '"]').remove();
							$li.removeClass('pf-active');
						}
					} else {
						if (!$li.hasClass('pf-active')) {
							$mainInput.val(currentVal);
							$results.find('.selected-value').remove();
							$results.prepend('<li class="selected-value" data-title="' + currentVal + '">' + currentText + '</li>');
							$li.parents('.basel-scroll-content').find('.pf-active').removeClass('pf-active');
							$li.addClass('pf-active');
						} else {
							$mainInput.val('');
							$results.find('.selected-value').remove();
							$li.removeClass('pf-active');
						}
					}
				});

				var $pfCheckbox = $('.basel-pf-checkboxes');
				$pfCheckbox.on('click', '.selected-value', function() {
					var $this = $(this);
					var $widget = $this.parents('.basel-pf-checkboxes');
					var $mainInput = $widget.find('.result-input');
					var currentVal = $this.data('title');

					// Price filter clear.
					if (currentVal === 'price-filter') {
						var min = $this.data('min');
						var max = $this.data('max');
						var $slider = $widget.find('.price_slider_widget');
						$slider.slider('values', 0, min);
						$slider.slider('values', 1, max);
						$widget.find('.min_price').val('');
						$widget.find('.max_price').val('');
						baselThemeModule.$body.trigger('filter_price_slider_slide', [
							min,
							max,
							min,
							max,
							$slider
						]);
						return;
					}

					removeValue($mainInput, currentVal);
					$widget.find('.pf-value[data-val="' + currentVal + '"]').parent().removeClass('pf-active');
					$this.remove();
				});

				//Checkboxes value dropdown
				$pfCheckbox.each(function() {
					var $this = $(this);
					var $btn = $this.find('.basel-pf-title');
					var $list = $btn.siblings('.basel-pf-dropdown');
					var multiSelect = $this.hasClass('multi_select');

					$btn.on('click', function(e) {
						var target = e.target;
						if ($(target).is($btn.find('.selected-value'))) {
							return;
						}

						if (!$this.hasClass('opened')) {
							$this.addClass('opened');
							$list.slideDown(100);
						} else {
							close();
						}
					});

					baselThemeModule.$document.on('click', function(e) {
						var target = e.target;
						if ($this.hasClass('opened') && (multiSelect && !$(target).is($this) && !$(target).parents().is($this)) || (!multiSelect && !$(target).is($btn) && !$(target).parents().is($btn))) {
							close();
						}
					});

					var close = function() {
						$this.removeClass('opened');
						$list.slideUp(100);
					};
				});

				var removeEmptyValues = function($selector) {
					$selector.find('.basel-pf-checkboxes').each(function() {
						var $this = $(this);
						if (!$this.find('input[type="hidden"]').val()) {
							$this.find('input[type="hidden"]').remove();
						}
					});
				};

				var changeFormAction = function($form) {
					var activeCat = $form.find('.basel-pf-categories .pf-active .pf-value');
					if (activeCat.length > 0) {
						$form.attr('action', activeCat.attr('href'));
					}
				};

				//Price slider init
				baselThemeModule.$body.on('filter_price_slider_create filter_price_slider_slide', function(event, min, max, minPrice, maxPrice, $slider) {
					var minHtml = accounting.formatMoney(min, {
						symbol   : woocommerce_price_slider_params.currency_format_symbol,
						decimal  : woocommerce_price_slider_params.currency_format_decimal_sep,
						thousand : woocommerce_price_slider_params.currency_format_thousand_sep,
						precision: woocommerce_price_slider_params.currency_format_num_decimals,
						format   : woocommerce_price_slider_params.currency_format
					});

					var maxHtml = accounting.formatMoney(max, {
						symbol   : woocommerce_price_slider_params.currency_format_symbol,
						decimal  : woocommerce_price_slider_params.currency_format_decimal_sep,
						thousand : woocommerce_price_slider_params.currency_format_thousand_sep,
						precision: woocommerce_price_slider_params.currency_format_num_decimals,
						format   : woocommerce_price_slider_params.currency_format
					});

					$slider.siblings('.filter_price_slider_amount').find('span.from').html(minHtml);
					$slider.siblings('.filter_price_slider_amount').find('span.to').html(maxHtml);

					var $results = $slider.parents('.basel-pf-checkboxes').find('.basel-pf-results');
					var value = $results.find('.selected-value');
					if (min == minPrice && max == maxPrice) {
						value.remove();
					} else {
						if (value.length === 0) {
							$results.prepend('<li class="selected-value" data-title="price-filter" data-min="' + minPrice + '" data-max="' + maxPrice + '">' + minHtml + ' - ' + maxHtml + '</li>');
						} else {
							value.html(minHtml + ' - ' + maxHtml);
						}
					}

					baselThemeModule.$body.trigger('price_slider_updated', [
						min,
						max
					]);
				});

				$('.basel-pf-price-range .price_slider_widget').each(function() {
					var $this = $(this);
					var $minInput = $this.siblings('.filter_price_slider_amount').find('.min_price');
					var $maxInput = $this.siblings('.filter_price_slider_amount').find('.max_price');
					var minPrice = parseInt($minInput.data('min'));
					var maxPrice = parseInt($maxInput.data('max'));
					var currentMinPrice = parseInt($minInput.val());
					var currentMaxPrice = parseInt($maxInput.val());

					$('.price_slider_widget, .price_label').show();

					$this.slider({
						range  : true,
						animate: true,
						min    : minPrice,
						max    : maxPrice,
						values : [
							currentMinPrice,
							currentMaxPrice
						],
						create : function() {
							if (currentMinPrice == minPrice && currentMaxPrice == maxPrice) {
								$minInput.val('');
								$maxInput.val('');
							}
							baselThemeModule.$body.trigger('filter_price_slider_create', [
								currentMinPrice,
								currentMaxPrice,
								minPrice,
								maxPrice,
								$this
							]);
						},
						slide  : function(event, ui) {
							if (ui.values[0] == minPrice && ui.values[1] == maxPrice) {
								$minInput.val('');
								$maxInput.val('');
							} else {
								$minInput.val(ui.values[0]);
								$maxInput.val(ui.values[1]);
							}
							baselThemeModule.$body.trigger('filter_price_slider_slide', [
								ui.values[0],
								ui.values[1],
								minPrice,
								maxPrice,
								$this
							]);
						},
						change : function(event, ui) {
							baselThemeModule.$body.trigger('price_slider_change', [
								ui.values[0],
								ui.values[1]
							]);
						}
					});
				});

				// Submit filter form.
				$('.basel-product-filters').one('click', '.basel-pf-btn button', function() {
					var $this = $(this);
					var $form = $this.parents('.basel-product-filters');
					removeEmptyValues($form);
					changeFormAction($form);

					if (!baselThemeModule.$body.hasClass('basel-ajax-shop-on') || typeof ($.fn.pjax) == 'undefined' || !$form.hasClass('with-ajax')) {
						return;
					}
					$.pjax({
						container     : '.main-page-wrapper',
						timeout       : basel_settings.pjax_timeout,
						url           : $form.attr('action'),
						data          : $form.serialize(),
						scrollTo      : false,
						renderCallback: function(context, html, afterRender) {
							baselThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
								context.html(html);
								afterRender();
								baselThemeModule.shopPageInit();
								baselThemeModule.$document.trigger('basel-images-loaded');
							});
						}
					});
					$this.prop('disabled', true);
				});

				// Create labels after ajax.
				$('.basel-pf-checkboxes .pf-active > .pf-value').each(function() {
					var $this = $(this);
					var resultsWrapper = $this.parents('.basel-pf-checkboxes').find('.basel-pf-results');
					resultsWrapper.prepend('<li class="selected-value" data-title="' + $this.data('val') + '">' + $this.data('title') + '</li>');
				});

			},

			owlCarouselInit: function() {
				$('[data-owl-carousel]:not(.scroll-init)').each(function() {
					owlInit($(this));
				});

				if (typeof ($.fn.waypoint) != 'undefined') {
					$('[data-owl-carousel].scroll-init').waypoint(function() {
						var $this = $($(this)[0].element);
						owlInit($this);
					}, {
						offset: '100%'
					});
				}

				function owlInit($this) {
					var $owl = $this.find('.owl-carousel');
					var options = {
						rtl               : baselThemeModule.$body.hasClass('rtl'),
						items             : $this.data('desktop') ? $this.data('desktop') : 1,
						responsive        : {
							979: {
								items: $this.data('desktop') ? $this.data('desktop') : 1
							},
							768: {
								items: $this.data('desktop_small') ? $this.data('desktop_small') : 1
							},
							479: {
								items: $this.data('tablet') ? $this.data('tablet') : 1
							},
							0  : {
								items: $this.data('mobile') ? $this.data('mobile') : 1
							}
						},
						autoplay          : $this.data('autoplay') === 'yes',
						autoplayHoverPause: $this.data('autoplay') === 'yes',
						autoplayTimeout   : $this.data('speed') ? $this.data('speed') : 5000,
						dots              : $this.data('hide_pagination_control') !== 'yes',
						nav               : $this.data('hide_prev_next_buttons') !== 'yes',
						autoHeight        : $this.data('autoheight') === 'yes',
						slideBy           : !$this.data('scroll_per_page') ? 1 : 'page',
						navText           : false,
						center            : $this.data('center_mode') === 'yes',
						loop              : $this.data('wrap') === 'yes',
						dragEndSpeed      : $this.data('dragendspeed') ? $this.data('dragendspeed') : 200,
						onRefreshed       : function() {
							baselThemeModule.$window.trigger('resize');
						}
					};

					if ($this.data('sliding_speed')) {
						options.smartSpeed = $this.data('sliding_speed');
						options.dragEndSpeed = $this.data('sliding_speed');
					}

					if ($this.data('animation')) {
						options.animateOut = $this.data('animation');
						options.mouseDrag = false;
					}

					if ($this.data('content_animation')) {
						function determinePseudoActive() {
							var id = $owl.find('.owl-item.active').find('.basel-slide').attr('id');
							$owl.find('.owl-item.pseudo-active').removeClass('pseudo-active');
							var $els = $owl.find('[id="' + id + '"]');
							$els.each(function() {
								var $this = $(this);
								if (!$this.parent().hasClass('active')) {
									$this.parent().addClass('pseudo-active');
								}
							});
						}

						determinePseudoActive();
						options.onTranslated = function() {
							determinePseudoActive();
						};
					}

					baselThemeModule.$window.on('vc_js', function() {
						$owl.trigger('refresh.owl.carousel');
					});

					// Fix for css in files.
					$owl.find('link').appendTo('head');

					$owl.owlCarousel(options);

					if ($this.data('autoheight') === 'yes') {
						$owl.imagesLoaded(function() {
							$owl.trigger('refresh.owl.carousel');
						});
					}
				}
			},

			baselSliderLazyLoad: function() {
				$('.basel-slider').on('changed.owl.carousel', function(event) {
					var $this = $(this);
					var active = $this.find('.owl-item').eq(event.item.index);
					var id = active.find('.basel-slide').attr('id');
					var $els = $this.find('[id="' + id + '"]');

					active.find('.basel-slide').addClass('basel-loaded');
					$els.each(function() {
						$(this).addClass('basel-loaded');
					});
				});
			},

			lazyLoading: function() {
				if (!window.addEventListener || !window.requestAnimationFrame || !document.getElementsByClassName) {
					return;
				}

				var pItem = document.getElementsByClassName('basel-lazy-load'), pCount, timer;

				baselThemeModule.$document.on('basel-images-loaded added_to_cart', function() {
					inView();
				});

				$('.basel-scroll-content, .basel-sidebar-content').on('scroll', function() {
					baselThemeModule.$document.trigger('basel-images-loaded');
				});

				// WooCommerce tabs fix
				$('.wc-tabs > li').on('click', function() {
					baselThemeModule.$document.trigger('basel-images-loaded');
				});

				// scroll and resize events
				window.addEventListener('scroll', scroller, false);
				window.addEventListener('resize', scroller, false);

				// DOM mutation observer
				if (MutationObserver) {

					var observer = new MutationObserver(function() {
						if (pItem.length !== pCount) {
							inView();
						}
					});

					observer.observe(document.body, {
						subtree      : true,
						childList    : true,
						attributes   : true,
						characterData: true
					});

				}

				// initial check
				inView();

				// throttled scroll/resize
				function scroller() {
					timer = timer || setTimeout(function() {
						timer = null;
						inView();
					}, 100);
				}

				// image in view?
				function inView() {
					if (pItem.length) {
						requestAnimationFrame(function() {
							var offset = parseInt(basel_settings.lazy_loading_offset);
							var wT = window.pageYOffset, wB = wT + window.innerHeight + offset, cRect, pT, pB, p = 0;

							while (p < pItem.length) {

								cRect = pItem[p].getBoundingClientRect();
								pT = wT + cRect.top;
								pB = pT + cRect.height;

								if (wT < pB && wB > pT && !pItem[p].loaded) {
									loadFullImage(pItem[p], p);
								} else {
									p++;
								}

							}

							pCount = pItem.length;
						});
					}
				}

				function loadFullImage(item) {
					item.onload = addedImg;

					if (item.querySelector('img') !== null) {
						item.querySelector('img').onload = addedImg;
						item.querySelector('img').src = item.dataset.baselSrc;
						item.querySelector('source').srcset = item.dataset.baselSrc;

						if (typeof (item.dataset.srcset) != 'undefined') {
							item.querySelector('img').srcset = item.dataset.srcset;
						}
					}

					item.src = item.dataset.baselSrc;
					if (typeof (item.dataset.srcset) != 'undefined') {
						item.srcset = item.dataset.srcset;
					}

					item.loaded = true;

					// replace image
					function addedImg() {
						requestAnimationFrame(function() {
							item.classList.add('basel-loaded');

							var $masonry = jQuery(item).parents('.view-masonry .gallery-images, .grid-masonry, .masonry-container');
							if ($masonry.length > 0) {
								$masonry.isotope('layout');
							}
							var $categories = jQuery(item).parents('.categories-masonry');
							if ($categories.length > 0) {
								$categories.packery();
							}
						});
					}
				}
			},

			productLoaderPosition: function() {
				var reculc = function() {
					$('.basel-products-loader').each(function() {
						var $loader     = $(this),
						    $loaderWrap = $loader.parent();

						if ($loader.length === 0) {
							return;
						}

						$loader.css('left', $loaderWrap.offset().left + $loaderWrap.outerWidth() / 2);
					});
				};

				baselThemeModule.$window.off('scroll.loaderVerticalPosition');

				baselThemeModule.$window.on('scroll.loaderVerticalPosition', reculc);
			},

			stickySidebarBtn: function() {
				var $trigger = $('.basel-show-sidebar-btn');
				var $stickyBtn = $('.shop-sidebar-opener');

				if ($stickyBtn.length <= 0 || $trigger.length <= 0 || baselThemeModule.windowWidth >= 1024) {
					return;
				}

				var stickySidebarBtnToggle = function() {
					var btnOffset = $trigger.offset().top + $trigger.outerHeight();
					var windowScroll = baselThemeModule.$window.scrollTop();

					if (btnOffset < windowScroll) {
						$stickyBtn.addClass('basel-sidebar-btn-shown');
					} else {
						$stickyBtn.removeClass('basel-sidebar-btn-shown');
					}
				};

				stickySidebarBtnToggle();

				baselThemeModule.$window.on('scroll', stickySidebarBtnToggle);
				baselThemeModule.$window.on('resize', stickySidebarBtnToggle);
			},

			stickyAddToCart: function() {
				var $trigger = $('.summary-inner .cart');
				var $stickyBtn = $('.basel-sticky-btn');

				if ($stickyBtn.length <= 0 || $trigger.length <= 0 || (baselThemeModule.windowWidth <= 768 && $stickyBtn.hasClass('mobile-off'))) {
					return;
				}

				var summaryOffset = $trigger.offset().top + $trigger.outerHeight();
				var $scrollToTop = $('.scrollToTop');

				var stickyAddToCartToggle = function() {
					var windowScroll = baselThemeModule.$window.scrollTop();
					var windowHeight = baselThemeModule.$window.height();
					var documentHeight = baselThemeModule.$document.height();

					if (summaryOffset < windowScroll && windowScroll + windowHeight !== documentHeight) {
						$stickyBtn.addClass('basel-sticky-btn-shown');
						$scrollToTop.addClass('basel-sticky-btn-shown');

					} else if (windowScroll + windowHeight === documentHeight || summaryOffset > windowScroll) {
						$stickyBtn.removeClass('basel-sticky-btn-shown');
						$scrollToTop.removeClass('basel-sticky-btn-shown');
					}
				};

				stickyAddToCartToggle();

				baselThemeModule.$window.on('scroll', stickyAddToCartToggle);

				$('.basel-sticky-add-to-cart').on('click', function(e) {
					e.preventDefault();
					$('html, body').animate({
						scrollTop: $('.summary-inner').offset().top
					}, 800);
				});

				// Wishlist.
				$('.basel-sticky-btn .basel-sticky-btn-wishlist a').on('click', function(e) {
					if (!$(this).hasClass('added')) {
						e.preventDefault();
					}

					$('.entry-summary .basel-wishlist-btn').trigger('click');
				});

				baselThemeModule.$document.on('added_to_wishlist', function() {
					$('.basel-sticky-btn .basel-sticky-btn-wishlist a').addClass('added');
				});

				// Compare.
				$('.basel-sticky-btn .basel-sticky-btn-compare a').on('click', function(e) {
					if (!$(this).hasClass('added')) {
						e.preventDefault();
					}

					$('.entry-summary .basel-compare-btn').trigger('click');
				});

				baselThemeModule.$document.on('added_to_compare', function() {
					$('.basel-sticky-btn .basel-sticky-btn-compare a').addClass('added');
				});

				// Quantity.
				$('.basel-sticky-btn-cart .qty').on('change', function() {
					$('.summary-inner .qty').val($(this).val());
				});

				$('.summary-inner .qty').on('change', function() {
					$('.basel-sticky-btn-cart .qty').val($(this).val());
				});
			},

			shopLoader: function() {
				var loaderClass       = '.basel-shop-loader',
				    contentClass      = '.products[data-source="main_loop"]',
				    sidebarClass      = '.area-sidebar-shop',
				    sidebarLeftClass  = 'sidebar-left',
				    hiddenClass       = 'hidden-loader',
				    hiddenTopClass    = 'hidden-from-top',
				    hiddenBottomClass = 'hidden-from-bottom';

				var loaderVerticalPosition = function() {
					var $products = $(contentClass),
					    $loader   = $products.parent().find(loaderClass);

					if ($products.length < 1) {
						return;
					}

					var offset       = baselThemeModule.$window.height() / 2,
					    scrollTop    = baselThemeModule.$window.scrollTop(),
					    holderTop    = $products.offset().top - offset,
					    holderHeight = $products.height(),
					    holderBottom = holderTop + holderHeight - 100;

					if (scrollTop < holderTop) {
						$loader.addClass(hiddenClass + ' ' + hiddenTopClass);
					} else if (scrollTop > holderBottom) {
						$loader.addClass(hiddenClass + ' ' + hiddenBottomClass);
					} else {
						$loader.removeClass(hiddenClass + ' ' + hiddenTopClass + ' ' + hiddenBottomClass);
					}
				};

				var loaderHorizontalPosition = function() {
					var $products    = $(contentClass),
					    $sidebar     = $(sidebarClass),
					    $loader      = $products.parent().find(loaderClass),
					    sidebarWidth = $sidebar.outerWidth();

					if ($products.length < 1) {
						return;
					}

					if (sidebarWidth > 0 && $sidebar.hasClass(sidebarLeftClass)) {
						if (baselThemeModule.$body.hasClass('rtl')) {
							$loader.css({
								'marginLeft': -sidebarWidth / 2 - 15
							});
						} else {
							$loader.css({
								'marginLeft': sidebarWidth / 2 - 15
							});
						}
					} else if (sidebarWidth > 0) {
						if (baselThemeModule.$body.hasClass('rtl')) {
							$loader.css({
								'marginLeft': sidebarWidth / 2 - 15
							});
						} else {
							$loader.css({
								'marginLeft': -sidebarWidth / 2 - 15
							});
						}
					}
				};

				baselThemeModule.$window.off('scroll.loaderVerticalPosition');
				baselThemeModule.$window.off('loaderHorizontalPosition');

				baselThemeModule.$window.on('scroll.loaderVerticalPosition', loaderVerticalPosition);
				baselThemeModule.$window.on('resize.loaderHorizontalPosition', loaderHorizontalPosition);
			},

			loginSidebar: function() {
				var body = baselThemeModule.$body;

				$('.login-side-opener').on('click', function(e) {
					e.preventDefault();
					if (isOpened()) {
						closeWidget();
					} else {
						setTimeout(function() {
							openWidget();
						}, 10);
					}
				});

				body.on('click touchstart', '.basel-close-side', function() {
					if (isOpened()) {
						closeWidget();
					}
				});

				body.on('click', '.widget-close', function(e) {
					e.preventDefault();
					if (isOpened()) {
						closeWidget();
					}
				});

				var closeWidget = function() {
					body.removeClass('basel-login-side-opened');
				};

				var openWidget = function() {
					body.addClass('basel-login-side-opened');
				};

				var isOpened = function() {
					return body.hasClass('basel-login-side-opened');
				};
			},

			headerBanner: function() {
				var banner_version = basel_settings.header_banner_version,
				    banner_btn     = basel_settings.header_banner_close_btn,
				    banner_enabled = basel_settings.header_banner_enabled;
				if (Cookies.get('basel_tb_banner_' + banner_version) == 'closed' || banner_btn == false || banner_enabled == false) {
					return;
				}
				var banner = $('.header-banner');

				if (!baselThemeModule.$body.hasClass('page-template-maintenance')) {
					baselThemeModule.$body.addClass('header-banner-display');
				}

				banner.on('click', '.close-header-banner', function(e) {
					e.preventDefault();
					closeBanner();
				});

				var closeBanner = function() {
					baselThemeModule.$body.removeClass('header-banner-display').addClass('header-banner-hide');
					Cookies.set('basel_tb_banner_' + banner_version, 'closed', {
						expires: 60,
						path   : '/'
					});
				};
			},

			shopHiddenSidebar: function() {
				baselThemeModule.$body.on('click', '.basel-show-sidebar-btn, .basel-sticky-sidebar-opener', function(e) {
					e.preventDefault();
					if ($('.sidebar-container').hasClass('show-hidden-sidebar')) {
						baselThemeModule.hideShopSidebar();
					} else {
						showSidebar();
					}
				});

				baselThemeModule.$body.on('click touchstart', '.basel-close-side, .basel-close-sidebar-btn', function() {
					baselThemeModule.hideShopSidebar();
				});

				var showSidebar = function() {
					$('.sidebar-container').addClass('show-hidden-sidebar');
					baselThemeModule.$body.addClass('basel-show-hidden-sidebar');
					$('.basel-show-sidebar-btn').addClass('btn-clicked');
				};
			},

			hideShopSidebar: function() {
				$('.basel-show-sidebar-btn').removeClass('btn-clicked');
				$('.sidebar-container').removeClass('show-hidden-sidebar');
				baselThemeModule.$body.removeClass('basel-show-hidden-sidebar');
			},

			mobileSearchIcon: function() {
				var body = baselThemeModule.$body;
				$('.mobile-search-icon.search-button').on('click', function(e) {
					if (baselThemeModule.windowWidth > 991) {
						return;
					}

					e.preventDefault();
					if (!body.hasClass('act-mobile-menu')) {
						body.addClass('act-mobile-menu');
						$('.mobile-nav .searchform').find('input[type="text"]').focus();
					}
				});
			},

			contentPopup: function() {
				$('.basel-popup-with-content').magnificPopup({
					type        : 'inline',
					removalDelay: 500,
					tClose      : basel_settings.close,
					tLoading    : basel_settings.loading,
					callbacks   : {
						beforeOpen: function() {
							this.st.mainClass = baselTheme.popupEffect + ' content-popup-wrapper';
						},
						open      : function() {
							baselThemeModule.$document.trigger('basel-images-loaded');
						}
					}
				});
			},

			addToCartAllTypes: function() {
				if (basel_settings.ajax_add_to_cart == false) {
					return;
				}

				baselThemeModule.$body.on('submit', 'form.cart', function(e) {
					var $form = $(this);
					var $productWrapper = $form.parents('.single-product-page');
					if ($productWrapper.length === 0) {
						$productWrapper = $form.parents('.product-quick-view');
					}

					if ($productWrapper.hasClass('product-type-external') || $productWrapper.hasClass('product-type-zakeke')) {
						return;
					}

					e.preventDefault();

					var $thisbutton = $form.find('.single_add_to_cart_button');
					var data = $form.serialize();

					data += '&action=basel_ajax_add_to_cart';

					if ($thisbutton.val()) {
						data += '&add-to-cart=' + $thisbutton.val();
					}

					$thisbutton.removeClass('added not-added');
					$thisbutton.addClass('loading');

					// Trigger event
					baselThemeModule.$body.trigger('adding_to_cart', [
						$thisbutton,
						data
					]);

					$.ajax({
						url     : basel_settings.ajaxurl,
						data    : data,
						method  : 'POST',
						success : function(response) {
							if (!response) {
								return;
							}

							var this_page = window.location.toString();

							this_page.replace('add-to-cart', 'added-to-cart');

							if (response.error && response.product_url) {
								window.location = response.product_url;
								return;
							}

							// Redirect to cart option
							if (basel_settings.cart_redirect_after_add === 'yes') {
								window.location = basel_settings.cart_url;
								return;
							} else {
								$thisbutton.removeClass('loading');

								var fragments = response.fragments;
								var cart_hash = response.cart_hash;

								// Block fragments class
								if (fragments) {
									$.each(fragments, function(key) {
										$(key).addClass('updating');
									});
								}

								// Replace fragments
								if (fragments) {
									$.each(fragments, function(key, value) {
										$(key).replaceWith(value);
									});
								}

								// Show notices
								if (response.notices.indexOf('error') > 0) {
									var $error = $('.woocommerce-error');
									if ($error.length > 0) {
										$error.remove();
									}
									$('.single-product-content').prepend(response.notices);
									$thisbutton.addClass('not-added');
								} else {
									if (basel_settings.add_to_cart_action === 'widget') {
										$.magnificPopup.close();
									}

									// Changes button classes
									$thisbutton.addClass('added');
									// Trigger event so themes can refresh other areas
									baselThemeModule.$body.trigger('added_to_cart', [
										fragments,
										cart_hash,
										$thisbutton
									]);
								}
							}
						},
						error   : function() {
							console.log('ajax adding to cart error');
						},
						complete: function() { }
					});
				});
			},

			initZoom: function() {
				var $mainGallery = $('.woocommerce-product-gallery__wrapper:not(.quick-view-gallery)');

				if (basel_settings.zoom_enable !== 'yes') {
					return false;
				}

				var zoomOptions = {
					touch: false
				};

				if ('ontouchstart' in window) {
					zoomOptions.on = 'click';
				}

				init($mainGallery.find('.woocommerce-product-gallery__image').eq(0));

				var $gallery = $('.woocommerce-product-gallery');

				if ($gallery.hasClass('thumbs-position-bottom') || $gallery.hasClass('thumbs-position-left')) {
					$mainGallery.on('changed.owl.carousel', function(e) {
						var $wrapper = $mainGallery.find('.woocommerce-product-gallery__image').eq(e.item.index);

						init($wrapper);
					});
				} else {
					$mainGallery.find('.product-image-wrap').each(function() {
						var $wrapper = $(this).find('.woocommerce-product-gallery__image');

						init($wrapper);
					});
				}

				function init($wrapper) {
					var image = $wrapper.find('img');

					if (image.data('large_image_width') > $wrapper.width()) {
						$wrapper.trigger('zoom.destroy');
						$wrapper.zoom(zoomOptions);
					}
				}
			},

			videoPoster: function() {
				$('.basel-video-poster-wrapper').on('click', function() {
					var videoWrapper = $(this),
					    video        = videoWrapper.siblings('iframe'),
					    videoScr     = video.attr('src'),
					    videoNewSrc  = videoScr + '&autoplay=1';

					if (videoScr.indexOf('vimeo.com') + 1) {
						videoNewSrc = videoScr + '?autoplay=1';
					}
					video.attr('src', videoNewSrc);
					videoWrapper.addClass('hidden-poster');
				});
			},

			fixedHeaders: function() {
				var getHeaderHeight = function() {
					var headerHeight = header.outerHeight();

					if (body.hasClass('sticky-navigation-only')) {
						headerHeight = header.find('.navigation-wrap').outerHeight();
					}

					return headerHeight;
				};

				var headerSpacer = function() {
					if (stickyHeader.hasClass(headerStickedClass)) {
						return;
					}
					$('.header-spacing').height(getHeaderHeight()).css('marginBottom', 40);
				};

				var body               = baselThemeModule.$body,
				    header             = $('.main-header'),
				    stickyHeader       = header,
				    headerHeight       = getHeaderHeight(),
				    headerStickedClass = 'act-scroll',
				    stickyClasses      = '',
				    stickyStart        = 0,
				    links              = header.find('.main-nav .menu>li>a');

				if (!body.hasClass('enable-sticky-header') || body.hasClass('global-header-vertical') || header.length === 0) {
					return;
				}

				var logo        = header.find('.site-logo').clone().html(),
				    navigation  = header.find('.main-nav').clone().html(),
				    rightColumn = header.find('.right-column').clone().html();

				var headerClone = '<div class="sticky-header header-clone"><div class="container"><div class="site-logo">' + logo + '</div><div class="main-nav site-navigation basel-navigation">' + navigation + '</div><div class="right-column">' + rightColumn + '</div></div></div>';

				var $topBarWrapper = $('.topbar-wrapp');
				var $headerBanner = $('.header-banner');

				if ($topBarWrapper.length > 0) {
					stickyStart = $topBarWrapper.outerHeight();
				}

				if ($headerBanner.length > 0 && body.hasClass('header-banner-display')) {
					stickyStart += $headerBanner.outerHeight();
				}

				if (body.hasClass('sticky-header-real')) {
					var headerSpace = $('<div/>').addClass('header-spacing');
					header.before(headerSpace);

					baselThemeModule.$window.on('resize', headerSpacer);
					headerSpacer();

					var timeout;

					baselThemeModule.$window.on('scroll', function() {
						if (body.hasClass('header-banner-hide')) {
							stickyStart = ($topBarWrapper.length > 0) ? $$topBarWrapper.outerHeight() : 0;
						}
						if ($(this).scrollTop() > stickyStart) {
							stickyHeader.addClass(headerStickedClass);
						} else {
							stickyHeader.removeClass(headerStickedClass);
							clearTimeout(timeout);
							timeout = setTimeout(function() {
								headerSpacer();
							}, 200);
						}
					});

				} else if (body.hasClass('sticky-header-clone')) {
					header.before(headerClone);
					stickyHeader = $('.sticky-header');
				}

				// Change header height smooth on scroll
				if (body.hasClass('basel-header-smooth')) {
					baselThemeModule.$window.on('scroll', function() {
						var space = (120 - $(this).scrollTop()) / 2;

						if (space >= 60) {
							space = 60;
						} else if (space <= 30) {
							space = 30;
						}
						links.css({
							paddingTop   : space,
							paddingBottom: space
						});
					});
				}

				if (body.hasClass('basel-header-overlap') || body.hasClass('sticky-navigation-only')) {
				}

				if (!body.hasClass('basel-header-overlap') && body.hasClass('sticky-header-clone')) {
					header.attr('class').split(' ').forEach(function(el) {
						if (el.indexOf('main-header') === -1 && el.indexOf('header-') === -1) {
							stickyClasses += ' ' + el;
						}
					});

					stickyHeader.addClass(stickyClasses);

					stickyStart += headerHeight;

					baselThemeModule.$window.on('scroll', function() {
						if (body.hasClass('header-banner-hide')) {
							stickyStart = $('.topbar-wrapp').outerHeight() + headerHeight;
						}
						if ($(this).scrollTop() > stickyStart) {
							stickyHeader.addClass(headerStickedClass);
						} else {
							stickyHeader.removeClass(headerStickedClass);
						}
					});
				}

				body.addClass('sticky-header-prepared');
			},

			verticalHeader: function() {
				var $header = $('.header-vertical').first();

				if ($header.length < 1) {
					return;
				}

				var $body, $window, top                                                                                    = false,
				    bottom = false, windowWidth, windowHeight, lastWindowPos = 0, bodyHeight, headerHeight, resizeTimer, Y = 0, delta,
				    headerBottom, viewportBottom, scrollStep;

				$body = baselThemeModule.$body;
				$window = baselThemeModule.$window;

				$window
					.on('scroll', scroll)
					.on('resize', function() {
						clearTimeout(resizeTimer);
						resizeTimer = setTimeout(resizeAndScroll, 500);
					});

				resizeAndScroll();

				for (var i = 1; i < 6; i++) {
					setTimeout(resizeAndScroll, 100 * i);
				}

				// Sidebar scrolling.
				function resize() {
					windowWidth = $window.width();

					if (1024 > windowWidth) {
						top = bottom = false;
						$header.removeAttr('style');
					}
				}

				function scroll() {
					var windowPos = $window.scrollTop();

					if (1024 > windowWidth) {
						return;
					}

					headerHeight = $header.height();
					headerBottom = headerHeight + $header.offset().top;
					windowHeight = $window.height();
					bodyHeight = $body.height();
					viewportBottom = windowHeight + $window.scrollTop();
					delta = headerHeight - windowHeight;
					scrollStep = lastWindowPos - windowPos;

					// If header height larger than window viewport
					if (delta > 0) {
						if (windowPos > lastWindowPos) {
							if (headerBottom > viewportBottom) {
								Y += scrollStep;
							}

							if (Y < -delta) {
								bottom = true;
								Y = -delta;
							}

							top = false;
						} else if (windowPos < lastWindowPos) {
							if ($header.offset().top < $window.scrollTop()) {
								Y += scrollStep;
							}

							if (Y >= 0) {
								top = true;
								Y = 0;
							}

							bottom = false;
						} else {
							if (headerBottom < viewportBottom) {
								Y = windowHeight - headerHeight;
							}

							if (Y >= 0) {
								top = true;
								Y = 0;
							}
						}
					} else {
						Y = 0;
					}

					// Change header Y coordinate
					$header.css({
						top: Y
					});

					lastWindowPos = windowPos;
				}

				function resizeAndScroll() {
					resize();
					scroll();
				}
			},

			splitNavHeader: function() {
				var header = $('.header-split');

				if (header.length <= 0) {
					return;
				}

				var navigation  = header.find('.main-nav'),
				    navItems    = navigation.find('.menu > li'),
				    itemsNumber = navItems.length,
				    rtl         = baselThemeModule.$body.hasClass('rtl'),
				    midIndex    = parseInt(itemsNumber / 2 + 0.5 * rtl - .5),
				    midItem     = navItems.eq(midIndex),
				    logo        = header.find('.site-logo > .basel-logo-wrap'),
				    logoWidth,
				    leftWidth   = 0,
				    rule        = (!rtl) ? 'marginRight' : 'marginLeft',
				    rightWidth  = 0;

				var recalc = function() {
					logoWidth = logo.outerWidth();
					leftWidth = 5;
					rightWidth = 0;

					for (var i = itemsNumber - 1; i >= 0; i--) {
						var itemWidth = navItems.eq(i).outerWidth();
						if (i > midIndex) {
							rightWidth += itemWidth;
						} else {
							leftWidth += itemWidth;
						}
					}

					var diff = leftWidth - rightWidth;

					if (rtl) {
						if (leftWidth > rightWidth) {
							navigation.find('.menu > li:first-child').css('marginRight', -diff);
						} else {
							navigation.find('.menu > li:last-child').css('marginLeft', diff + 5);
						}
					} else {
						if (leftWidth > rightWidth) {
							navigation.find('.menu > li:last-child').css('marginRight', diff + 5);
						} else {
							navigation.find('.menu > li:first-child').css('marginLeft', -diff);
						}
					}

					midItem.css(rule, logoWidth);
				};

				logo.imagesLoaded(function() {
					recalc();
					header.addClass('menu-calculated');
				});

				baselThemeModule.$window.on('resize', recalc);

				if (basel_settings.split_nav_fix) {
					baselThemeModule.$window.on('scroll', function() {
						if (header.hasClass('act-scroll') && !header.hasClass('menu-sticky-calculated')) {
							recalc();
							header.addClass('menu-sticky-calculated');
							header.removeClass('menu-calculated');
						}
						if (!header.hasClass('act-scroll') && !header.hasClass('menu-calculated')) {
							recalc();
							header.addClass('menu-calculated');
							header.removeClass('menu-sticky-calculated');
						}
					});
				}

			},

			counterShortcode: function(counter) {
				if (counter.attr('data-state') === 'done' || parseInt(counter.text()) !== parseInt(counter.data('final'))) {
					return;
				}

				counter.prop('Counter', 0).animate({
					Counter: counter.text()
				}, {
					duration: 3000,
					easing  : 'swing',
					step    : function(now) {
						if (now >= counter.data('final')) {
							counter.attr('data-state', 'done');
						}
						counter.text(Math.ceil(now));
					}
				});
			},

			visibleElements: function() {
				$('.basel-counter .counter-value').each(function() {
					var $this = $(this);
					$this.waypoint(function() {
						baselThemeModule.counterShortcode($this);
					}, {offset: '100%'});
				});
			},

			wishList: function() {
				var body = baselThemeModule.$body;

				body.on('click', '.add_to_wishlist', function() {
					$(this).parent().addClass('feid-in');
				});
			},

			compare: function() {
				var body   = baselThemeModule.$body,
				    button = $('a.compare');

				body.on('click', 'a.compare', function() {
					$(this).addClass('loading');
				});

				body.on('yith_woocompare_open_popup', function() {
					button.removeClass('loading');
					body.addClass('compare-opened');
				});

				body.on('click', '#cboxClose, #cboxOverlay', function() {
					body.removeClass('compare-opened');
				});
			},

			baselCompare: function() {
				var cookiesName = 'basel_compare_list';

				if (basel_settings.is_multisite) {
					cookiesName += '_' + basel_settings.current_blog_id;
				}

				var $body         = baselThemeModule.$body,
				    $widget       = $('.compare-info-widget'),
				    compareCookie = Cookies.get(cookiesName);

				if ($widget.length > 0 && 'undefined' !== typeof compareCookie) {
					try {
						var ids = JSON.parse(compareCookie);
						$widget.find('.compare-count').text(ids.length);
					}
					catch (e) {
						console.log('cant parse cookies json');
					}
				} else {
					$widget.find('.compare-count').text(0);
				}

				$body.on('click', '.basel-compare-btn a, a.basel-compare-btn', function(e) {
					var $this     = $(this),
					    id        = $this.data('id'),
					    addedText = $this.data('added-text');

					if ($this.hasClass('added')) {
						return true;
					}

					e.preventDefault();

					$this.addClass('loading');

					jQuery.ajax({
						url     : basel_settings.ajaxurl,
						data    : {
							action: 'basel_add_to_compare',
							id    : id
						},
						dataType: 'json',
						method  : 'GET',
						success : function(response) {
							if (response.table) {
								updateCompare(response);
								baselThemeModule.$document.trigger('added_to_compare');
							} else {
								console.log('something wrong loading compare data ', response);
							}
						},
						error   : function() {
							console.log('We cant add to compare. Something wrong with AJAX response. Probably some PHP conflict.');
						},
						complete: function() {
							$this.removeClass('loading').addClass('added');

							if ($this.find('span').length > 0) {
								$this.find('span').text(addedText);
							} else {
								$this.text(addedText);
							}
						}
					});

				});

				// Remove from compare action
				$body.on('click', '.basel-compare-table .basel-remove-button', function(e) {
					var $table = $('.basel-compare-table');

					e.preventDefault();
					var $this = $(this),
					    id    = $this.data('id');

					$table.addClass('loading');
					$this.addClass('loading');

					jQuery.ajax({
						url     : basel_settings.ajaxurl,
						data    : {
							action: 'basel_remove_from_compare',
							id    : id
						},
						dataType: 'json',
						method  : 'GET',
						success : function(response) {
							if (response.table) {
								updateCompare(response);
							} else {
								console.log('something wrong loading compare data ', response);
							}
						},
						error   : function() {
							console.log('We cant remove product compare. Something wrong with AJAX response. Probably some PHP conflict.');
						},
						complete: function() {
							$table.removeClass('loading');
							$this.addClass('loading');
						}
					});

				});

				// Elements update after ajax
				function updateCompare(data) {
					var $widget = $('.compare-info-widget');
					if ($widget.length > 0) {
						$widget.find('.compare-count').text(data.count);
					}

					var $compareTable = $('.basel-compare-table');
					if ($compareTable.length > 0) {
						$compareTable.replaceWith(data.table);
					}
				}
			},

			promoPopup: function() {
				var promo_version = basel_settings.promo_version;

				if (baselThemeModule.$body.hasClass('page-template-maintenance') || basel_settings.enable_popup !== 'yes' || (basel_settings.promo_popup_hide_mobile === 'yes' && baselThemeModule.windowWidth < 768)) {
					return;
				}

				var shown = false,
				    pages = Cookies.get('basel_shown_pages');

				var showPopup = function() {
					$.magnificPopup.open({
						items       : {
							src: '.basel-promo-popup'
						},
						type        : 'inline',
						removalDelay: 400,
						tClose      : basel_settings.close,
						tLoading    : basel_settings.loading,
						callbacks   : {
							beforeOpen: function() {
								this.st.mainClass = 'basel-popup-effect';
							},
							close     : function() {
								Cookies.set('basel_popup_' + promo_version, 'shown', {
									expires: 7,
									path   : '/'
								});
							}
						}
					});
					baselThemeModule.$document.trigger('basel-images-loaded');
				};

				$('.basel-open-popup').on('click', function(e) {
					e.preventDefault();
					showPopup();
				});

				if (!pages) {
					pages = 0;
				}

				if (pages < basel_settings.popup_pages) {
					pages++;
					Cookies.set('basel_shown_pages', pages, {
						expires: 7,
						path   : '/'
					});
					return false;
				}

				if (Cookies.get('basel_popup_' + promo_version) !== 'shown') {
					if (basel_settings.popup_event === 'scroll') {
						baselThemeModule.$window.on('scroll', function() {
							if (shown) {
								return false;
							}
							if (baselThemeModule.$document.scrollTop() >= basel_settings.popup_scroll) {
								showPopup();
								shown = true;
							}
						});
					} else {
						setTimeout(function() {
							showPopup();
						}, basel_settings.popup_delay);
					}
				}
			},

			productVideo: function() {
				$('.product-video-button a').magnificPopup({
					tClose         : basel_settings.close,
					tLoading       : basel_settings.loading,
					type           : 'iframe',
					iframe         : {
						markup  : '<div class="mfp-iframe-scaler mfp-with-anim">' +
							'<div class="mfp-close"></div>' +
							'<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>' +
							'</div>',
						patterns: {
							youtube: {
								index: 'youtube.com/',
								id   : 'v=',
								src  : '//www.youtube.com/embed/%id%?rel=0&autoplay=1'
							}
						}
					},
					mainClass      : 'mfp-fade',
					removalDelay   : 500,
					preloader      : false,
					disableOn      : false,
					fixedContentPos: false,
					callbacks      : {
						beforeOpen: function() {
							this.st.mainClass = baselTheme.popupEffect;
						}
					}
				});
			},

			product360Button: function() {
				$('.product-360-button a').magnificPopup({
					tClose         : basel_settings.close,
					tLoading       : basel_settings.loading,
					type           : 'inline',
					removalDelay   : 500,
					disableOn      : false,
					preloader      : false,
					fixedContentPos: false,
					callbacks      : {
						beforeOpen: function() {
							this.st.mainClass = baselTheme.popupEffect;
						},
						open      : function() {
							baselThemeModule.$window.on('resize');
						}
					}
				});
			},

			cookiesPopup: function() {
				var cookies_version = basel_settings.cookies_version;
				if (Cookies.get('basel_cookies_' + cookies_version) === 'accepted') {
					return;
				}
				var popup = $('.basel-cookies-popup');

				setTimeout(function() {
					popup.addClass('popup-display');
					popup.on('click', '.cookies-accept-btn', function(e) {
						e.preventDefault();
						acceptCookies();
					});
				}, 2500);

				var acceptCookies = function() {
					popup.removeClass('popup-display').addClass('popup-hide');
					Cookies.set('basel_cookies_' + cookies_version, 'accepted', {
						expires: 60,
						path   : '/'
					});
				};
			},

			googleMap: function() {
				var gmap = $('.google-map-container-with-content');

				baselThemeModule.$window.on('resize', function() {
					gmap.css({
						'height': gmap.find('.basel-google-map.with-content').outerHeight()
					});
				});

			},

			woocommerceWrappTable: function() {
				var wooTable = $('.woocommerce .shop_table:not(.wishlist_table)');
				var cartTotals = $('.woocommerce .cart_totals table');
				wooTable.wrap('<div class=\'responsive-table\'></div>');
				cartTotals.wrap('<div class=\'responsive-table\'></div>');
			},

			menuSetUp: function() {
				var mainMenu    = $('.basel-navigation').find('ul.menu'),
				    openedClass = 'item-menu-opened';

				mainMenu.off('click').on('click', ' > .item-event-click.menu-item-has-children > a', function(e) {
					var $this = $(this);
					e.preventDefault();
					if (!$this.parent().hasClass(openedClass)) {
						$('.' + openedClass).removeClass(openedClass);
					}
					$this.parent().toggleClass(openedClass);
				});

				baselThemeModule.$document.on('click', function(e) {
					var target = e.target;
					if ($('.' + openedClass).length > 0 && !$(target).is('.item-event-hover') && !$(target).parents().is('.item-event-hover') && !$(target).parents().is('.' + openedClass + '')) {
						mainMenu.find('.' + openedClass + '').removeClass(openedClass);
						return false;
					}
				});

				var menuForIPad = function() {
					if (baselThemeModule.windowWidth <= 1024) {
						mainMenu.find(' > .item-event-hover').each(function() {
							$(this).data('original-event', 'hover').removeClass('item-event-hover').addClass('item-event-click');
						});
					} else {
						mainMenu.find(' > .item-event-click').each(function() {
							var $this = $(this);
							if ($this.data('original-event') === 'hover') {
								$this.removeClass('item-event-click').addClass('item-event-hover');
							}
						});
					}
				};

				baselThemeModule.$window.on('resize', menuForIPad);
			},

			menuOffsets: function() {
				var $window  = baselThemeModule.$window,
				    $header  = $('.main-header'),
				    mainMenu = $('.main-nav').find('ul.menu');

				mainMenu.on('mouseenter mousemove', ' > li', function() {
					setOffset($(this));
				});

				var setOffset = function(li) {
					var dropdown    = li.find(' > .sub-menu-dropdown'),
					    siteWrapper = $('.website-wrapper');

					dropdown.attr('style', '');

					var dropdownWidth  = dropdown.outerWidth(),
					    dropdownOffset = dropdown.offset(),
					    screenWidth    = $window.width(),
					    bodyRight      = siteWrapper.outerWidth() + siteWrapper.offset().left,
					    viewportWidth  = (baselThemeModule.$body.hasClass('wrapper-boxed') || baselThemeModule.$body.hasClass('wrapper-boxed-small')) ? bodyRight : screenWidth;

					if (!dropdownWidth || !dropdownOffset) {
						return;
					}

					if (baselThemeModule.$body.hasClass('rtl') && dropdownOffset.left <= 0 && li.hasClass('menu-item-design-sized') && !$header.hasClass('header-vertical')) {
						// If right point is not in the viewport
						var toLeft = -dropdownOffset.left;

						dropdown.css({
							right: -toLeft - 10
						});
					} else if (dropdownOffset.left + dropdownWidth >= viewportWidth && li.hasClass('menu-item-design-sized') && !$header.hasClass('header-vertical')) {
						// If right point is not in the viewport
						var toRight = dropdownOffset.left + dropdownWidth - viewportWidth;

						dropdown.css({
							left: -toRight - 10
						});
					}

					// Vertical header fit
					if ($header.hasClass('header-vertical')) {
						var bottom         = dropdown.offset().top + dropdown.outerHeight(),
						    viewportBottom = $window.scrollTop() + $window.outerHeight();

						if (bottom > viewportBottom) {
							dropdown.css({
								top: viewportBottom - bottom - 10
							});
						}
					}
				};

				// lis.each(function() {
				// 	setOffset($(this));
				// 	$(this).addClass('with-offsets');
				// });
			},

			onePageMenu: function() {
				var scrollToRow = function(hash) {
					var row = $('#' + hash);

					if (row.length < 1) {
						return;
					}

					var position = row.offset().top;

					$('html, body').stop().animate({
						scrollTop: position - basel_settings.one_page_menu_offset
					}, 800, function() {
						activeMenuItem(hash);
					});
				};

				var activeMenuItem = function(hash) {
					var itemHash;
					$('.onepage-link').each(function() {
						var $this = $(this);
						itemHash = $this.find('> a').attr('href').split('#')[1];

						if (itemHash == hash) {
							$('.onepage-link').removeClass('current-menu-item');
							$this.addClass('current-menu-item');
						}
					});
				};

				baselThemeModule.$body.on('click', '.onepage-link > a', function(e) {
					var $this = $(this),
					    hash  = $this.attr('href').split('#')[1];

					if ($('#' + hash).length < 1) {
						return;
					}

					e.preventDefault();

					scrollToRow(hash);

					// close mobile menu
					$('.basel-close-side').trigger('click');
				});

				if ($('.onepage-link').length > 0) {
					$('.entry-content > .vc_section, .entry-content > .vc_row').waypoint(function() {
						var $this = $($(this)[0].element);
						var hash = $this.attr('id');
						activeMenuItem(hash);
					}, {offset: 0});

					// URL contains hash
					var locationHash = window.location.hash.split('#')[1];

					if (window.location.hash.length > 1) {
						setTimeout(function() {
							scrollToRow(locationHash);
						}, 500);
					}
				}
			},

			mobileNavigation: function() {
				var body        = baselThemeModule.$body,
				    mobileNav   = $('.mobile-nav'),
				    dropDownCat = $('.mobile-nav .site-mobile-menu .menu-item-has-children'),
				    elementIcon = '<span class="icon-sub-menu"></span>';

				dropDownCat.append(elementIcon);

				// Fix for menu.
				body.on('click', '.mobile-nav-icon, .basel-show-categories', function() {
					baselThemeModule.$document.trigger('basel-images-loaded');
				});

				mobileNav.on('click', '.icon-sub-menu', function(e) {
					e.preventDefault();
					var $this = $(this);

					if ($this.parent().hasClass('opener-page')) {
						$this.parent().removeClass('opener-page').find('> ul').slideUp(200);
						$this.parent().removeClass('opener-page').find('.sub-menu-dropdown .container > ul').slideUp(200);
						$this.parent().find('> .icon-sub-menu').removeClass('up-icon');
					} else {
						$this.parent().addClass('opener-page').find('> ul').slideDown(200);
						$this.parent().addClass('opener-page').find('.sub-menu-dropdown .container > ul').slideDown(200);
						$this.parent().find('> .icon-sub-menu').addClass('up-icon');
					}
				});

				body.on('click', '.mobile-nav-icon', function() {
					if (body.hasClass('act-mobile-menu')) {
						closeMenu();
					} else {
						openMenu();
					}
				});

				body.on('click touchstart', '.basel-close-side, .basel-close-sidebar-btn', function() {
					closeMenu();
				});

				body.on('click', '.mobile-nav .login-side-opener', function() {
					closeMenu();
				});

				function openMenu() {
					body.addClass('act-mobile-menu');
				}

				function closeMenu() {
					body.removeClass('act-mobile-menu');
				}
			},

			simpleDropdown: function() {
				$('.input-dropdown-inner').each(function() {
					var dd = $(this);
					var btn = dd.find('> a');
					var input = dd.find('> input');
					var list = dd.find('> ul');

					baselThemeModule.$document.on('click', function(e) {
						var target = e.target;
						if (dd.hasClass('dd-shown') && !$(target).is('.input-dropdown-inner') && !$(target).parents().is('.input-dropdown-inner')) {
							hideList();
							return false;
						}
					});

					btn.on('click', function(e) {
						e.preventDefault();

						if (dd.hasClass('dd-shown')) {
							hideList();
						} else {
							showList();
						}
						return false;
					});

					list.on('click', 'a', function(e) {
						e.preventDefault();
						var $this = $(this);
						var value = $this.data('val');
						var label = $this.text();
						list.find('.current-item').removeClass('current-item');
						$this.parent().addClass('current-item');
						if (value != 0) {
							list.find('> li:first-child').show();
						} else if (value == 0) {
							list.find('> li:first-child').hide();
						}
						btn.text(label);
						input.val(value).trigger('cat_selected');
						hideList();
					});

					function showList() {
						dd.addClass('dd-shown');
						list.slideDown(100);

						if (typeof ($.fn.devbridgeAutocomplete) != 'undefined') {
							dd.parent().siblings('[type="text"]').devbridgeAutocomplete('hide');
						}
					}

					function hideList() {
						dd.removeClass('dd-shown');
						list.slideUp(100);
					}
				});
			},

			equalizeColumns: function() {
				$.fn.basel_equlize = function(options) {
					var settings = $.extend({
						child: ''
					}, options);

					var that = this;

					if (!settings.child) {
						that = this.find(settings.child);
					}

					var resize = function() {
						var maxHeight = 0;

						that.each(function() {
							var $this = $(this);
							$this.attr('style', '');
							if (baselThemeModule.windowWidth > 767 && $this.outerHeight() > maxHeight) {
								maxHeight = $this.outerHeight();
							}
						});

						that.each(function() {
							$(this).css({
								minHeight: maxHeight
							});
						});
					};

					baselThemeModule.$window.on('resize', function() {
						resize();
					});
					setTimeout(function() {
						resize();
					}, 200);
					setTimeout(function() {
						resize();
					}, 500);
					setTimeout(function() {
						resize();
					}, 800);
				};

				$('.equal-columns').each(function() {
					$(this).basel_equlize({
						child: '> [class*=col-]'
					});
				});
			},

			blogMasonry: function() {
				if (typeof ($.fn.isotope) == 'undefined' || typeof ($.fn.imagesLoaded) == 'undefined') {
					return;
				}
				var $container = $('.masonry-container');

				// initialize Masonry after all images have loaded
				$container.imagesLoaded(function() {
					$container.isotope({
						gutter      : 0,
						isOriginLeft: !baselThemeModule.$body.hasClass('rtl'),
						itemSelector: '.blog-design-masonry, .blog-design-mask, .masonry-item'
					});
				});

				$('.masonry-filter').on('click', 'a', function(e) {
					e.preventDefault();
					var $this = $(this);

					setTimeout(function() {
						jQuery(document).trigger('basel-images-loaded');
					}, 300);

					$('.masonry-filter').find('.filter-active').removeClass('filter-active');
					$this.addClass('filter-active');
					var filterValue = $this.attr('data-filter');
					$this.parents('.portfolio-filter').siblings('.masonry-container.basel-portfolio-holder').first().isotope({
						filter: filterValue
					});
				});
			},

			blogLoadMore: function() {
				$('.basel-blog-load-more').on('click', function(e) {
					e.preventDefault();

					var $this    = $(this),
					    holderId = $this.data('holder-id'),
					    holder   = $('.basel-blog-holder#' + holderId),
					    atts     = holder.data('atts'),
					    paged    = holder.data('paged');

					$this.addClass('loading');

					$.ajax({
						url     : basel_settings.ajaxurl,
						data    : {
							atts  : atts,
							paged : paged,
							action: 'basel_get_blog_shortcode'
						},
						dataType: 'json',
						method  : 'POST',
						success : function(data) {
							baselThemeModule.removeDuplicatedStylesFromHTML(data.items, function(html) {
								var $items = $(html);

								if ($items) {
									if (holder.hasClass('masonry-container')) {
										holder.append($items).isotope('appended', $items);
										holder.imagesLoaded().progress(function() {
											holder.isotope('layout');
										});
									} else {
										holder.append($items);
									}

									holder.data('paged', paged + 1);
								}

								if (data.status === 'no-more-posts') {
									$this.hide();
								}
							});
						},
						error   : function() {
							console.log('ajax error');
						},
						complete: function() {
							$this.removeClass('loading');
						}
					});
				});
			},

			productsLoadMore: function() {
				var process = false,
				    intervalID;

				$('.basel-products-element').each(function() {
					var $this = $(this),
					    cache = [],
					    inner = $this.find('.basel-products-holder');

					if (!inner.hasClass('pagination-arrows') && !inner.hasClass('pagination-more-btn')) {
						return;
					}

					cache[1] = {
						items : inner.html(),
						status: 'have-posts'
					};

					$this.on('recalc', function() {
						calc();
					});

					if (inner.hasClass('pagination-arrows')) {
						baselThemeModule.$window.on('resize', function() {
							calc();
						});
					}

					var calc = function() {
						var height = inner.outerHeight();
						$this.stop().css({minHeight: height});
					};

					var body        = baselThemeModule.$body,
					    btnWrap     = $this.find('.products-footer'),
					    btnLeft     = btnWrap.find('.basel-products-load-prev'),
					    btnRight    = btnWrap.find('.basel-products-load-next'),
					    loadWrapp   = $this.find('.basel-products-loader'),
					    scrollTop,
					    holderTop,
					    btnLeftOffset,
					    btnRightOffset,
					    holderBottom,
					    holderHeight,
					    holderWidth,
					    btnsHeight,
					    offsetArrow = 50,
					    offset,
					    windowWidth;

					if (body.hasClass('rtl')) {
						btnLeft = btnRight;
						btnRight = btnWrap.find('.basel-products-load-prev');
					}

					baselThemeModule.$window.on('scroll', function() {
						buttonsPos();
					});

					setTimeout(function() {
						buttonsPos();
					}, 500);

					function buttonsPos() {
						offset = baselThemeModule.$window.height() / 2;
						windowWidth = baselThemeModule.$window.outerWidth(true) + 17;
						holderWidth = $this.outerWidth(true) + 10;
						scrollTop = baselThemeModule.$window.scrollTop();
						holderTop = $this.offset().top - offset;
						btnLeftOffset = $this.offset().left - offsetArrow;
						btnRightOffset = btnLeftOffset + holderWidth + offsetArrow;
						btnsHeight = btnLeft.outerHeight();
						holderHeight = $this.height() - 50 - btnsHeight;
						holderBottom = holderTop + holderHeight;

						if (windowWidth <= 1047 && windowWidth >= 992 || windowWidth <= 825 && windowWidth >= 768) {
							btnLeftOffset += 18;
							btnRightOffset -= 18;
						}

						if (windowWidth < 768 || body.hasClass('wrapper-boxed') || body.hasClass('wrapper-boxed-small') || $('.main-header').hasClass('header-vertical')) {
							btnLeftOffset += 51;
							btnRightOffset -= 51;
						}

						btnLeft.css({
							'left': btnLeftOffset + 'px'
						});

						btnRight.css({
							'left': btnRightOffset + 'px'
						});

						if (scrollTop < holderTop || scrollTop > holderBottom) {
							btnWrap.removeClass('show-arrow');
							loadWrapp.addClass('hidden-loader');
						} else {
							btnWrap.addClass('show-arrow');
							loadWrapp.removeClass('hidden-loader');
						}
					}

					$this.find('.basel-products-load-prev, .basel-products-load-next').on('click', function(e) {
						e.preventDefault();
						var $this = $(this);

						if (process || $this.hasClass('disabled')) {
							return;
						}
						process = true;

						clearInterval(intervalID);

						var holder  = $this.parent().siblings('.basel-products-holder'),
						    next    = $this.parent().find('.basel-products-load-next'),
						    prev    = $this.parent().find('.basel-products-load-prev'),
						    atts    = holder.data('atts'),
						    paged   = holder.attr('data-paged'),
						    ajaxurl = basel_settings.ajaxurl,
						    action  = 'basel_get_products_shortcode',
						    method  = 'POST';

						if ($this.hasClass('basel-products-load-prev')) {
							if (paged < 2) {
								return;
							}
							paged = paged - 2;
						}

						paged++;

						loadProducts('arrows', atts, ajaxurl, action, method, paged, holder, $this, cache, function(data) {
							holder.addClass('basel-animated-products');

							if (data.items) {
								holder.html(data.items).attr('data-paged', paged);
								holder.imagesLoaded().progress(function() {
									holder.parent().trigger('recalc');
								});

								baselThemeModule.$document.trigger('basel-images-loaded');

								baselThemeModule.btnsToolTips();
								baselThemeModule.swatchesLimit();
							}

							if (baselThemeModule.windowWidth < 768) {
								$('html, body').stop().animate({
									scrollTop: holder.offset().top - 150
								}, 400);
							}

							var iter = 0;
							intervalID = setInterval(function() {
								holder.find('.product-grid-item').eq(iter).addClass('basel-animated');
								iter++;
							}, 100);

							if (paged > 1) {
								prev.removeClass('disabled');
							} else {
								prev.addClass('disabled');
							}

							if (data.status === 'no-more-posts') {
								next.addClass('disabled');
							} else {
								next.removeClass('disabled');
							}
						});

					});
				});

				baselThemeModule.clickOnScrollButton(baselTheme.shopLoadMoreBtn, false);

				baselThemeModule.$document.off('click', '.basel-products-load-more').on('click', '.basel-products-load-more', function(e) {
					e.preventDefault();

					if (process) {
						return;
					}
					process = true;

					var $this   = $(this),
					    holder  = $this.parent().siblings('.basel-products-holder'),
					    source  = holder.data('source'),
					    action  = 'basel_get_products_' + source,
					    ajaxurl = basel_settings.ajaxurl,
					    method  = 'POST',
					    atts    = holder.data('atts'),
					    paged   = holder.data('paged');

					paged++;

					if (source === 'main_loop') {
						ajaxurl = $this.attr('href');
						method = 'GET';
					}

					loadProducts('load-more', atts, ajaxurl, action, method, paged, holder, $this, [], function(data) {
						if (data.items) {
							if (holder.hasClass('grid-masonry')) {
								isotopeAppend(holder, data.items);
							} else {
								holder.append(data.items);
							}

							holder.imagesLoaded().progress(function() {
								baselThemeModule.clickOnScrollButton(baselTheme.shopLoadMoreBtn, true);
							});

							baselThemeModule.$document.trigger('basel-images-loaded');

							holder.data('paged', paged);

							baselThemeModule.btnsToolTips();
							baselThemeModule.swatchesLimit();
						}

						if (source === 'main_loop') {
							$this.attr('href', data.nextPage);
							if (data.status === 'no-more-posts') {
								$this.hide().remove();
							}
						}

						if (data.status === 'no-more-posts') {
							$this.hide().remove();
						}
					});
				});

				function removeURLParameter(url, parameter) {
					var urlparts = url.split('?');

					if (urlparts.length >= 2) {
						var prefix = encodeURIComponent(parameter) + '=';
						var pars = urlparts[1].split(/[&;]/g);

						for (var i = pars.length; i-- > 0;) {
							if (pars[i].lastIndexOf(prefix, 0) !== -1) {
								pars.splice(i, 1);
							}
						}

						return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
					}

					return url;
				}

				var loadProducts = function(btnType, atts, ajaxurl, action, method, paged, holder, btn, cache, callback) {
					var data = {
						atts    : atts,
						paged   : paged,
						action  : action,
						woo_ajax: 1
					};

					ajaxurl = removeURLParameter(ajaxurl, 'loop');
					ajaxurl = removeURLParameter(ajaxurl, 'woo_ajax');

					if (cache[paged]) {
						holder.addClass('loading');
						setTimeout(function() {
							callback(cache[paged]);
							holder.removeClass('loading');
							process = false;
						}, 300);
						return;
					}

					holder.addClass('loading').parent().addClass('element-loading');

					if (btnType === 'arrows') {
						holder.addClass('loading').parent().addClass('element-loading');
					}

					if (action === 'basel_get_products_main_loop') {
						var loop = holder.find('.product').last().data('loop');
						data = {
							loop    : loop,
							woo_ajax: 1
						};
					}

					btn.addClass('loading');

					$.ajax({
						url     : ajaxurl,
						data    : data,
						dataType: 'json',
						method  : method,
						success : function(data) {
							baselThemeModule.removeDuplicatedStylesFromHTML(data.items, function(html) {
								data.items = html;
								cache[paged] = data;
								callback(data);

								if ('yes' === basel_settings.load_more_button_page_url_opt && data.currentPage){
									window.history.pushState('', '', data.currentPage + window.location.search);
									$('.woocommerce-breadcrumb').replaceWith(data.breadcrumbs);
								}
							});
						},
						error   : function() {
							console.log('ajax error');
						},
						complete: function() {
							holder.removeClass('loading').parent().removeClass('element-loading');
							btn.removeClass('loading');
							process = false;
							baselThemeModule.compare();
							baselThemeModule.countDownTimer();
						}
					});
				};

				var isotopeAppend = function(el, items) {
					var $items = $(items);
					el.append($items).isotope('appended', $items);
					el.isotope('layout');
					setTimeout(function() {
						el.isotope('layout');
					}, 100);
					el.imagesLoaded().progress(function() {
						el.isotope('layout');
					});
				};

			},

			clickOnScrollButton: function(btnClass) {
				if (typeof $.fn.waypoint != 'function') {
					return;
				}

				var $btn = $(btnClass);
				if ($btn.length === 0) {
					return;
				}

				$btn.trigger('wd-waypoint-destroy');

				var waypoint = new Waypoint({
					element: $btn[0],
					handler: function() {
						$btn.trigger('click');
					},
					offset : '100%'
				});

				$btn.data('waypoint-inited', true).off('wd-waypoint-destroy').on('wd-waypoint-destroy', function() {
					if ($btn.data('waypoint-inited')) {
						waypoint.destroy();
						$btn.data('waypoint-inited', false);
					}
				});
			},

			productsTabs: function() {
				var process = false;

				$('.basel-products-tabs').each(function() {
					var $this  = $(this),
					    $inner = $this.find('.basel-tab-content'),
					    cache  = [];

					if ($inner.find('.owl-carousel').length < 1) {
						cache[0] = {
							html: $inner.html()
						};
					}

					$this.find('.products-tabs-title li').on('click', function(e) {
						e.preventDefault();

						var $this = $(this),
						    atts  = $this.data('atts'),
						    index = $this.index();

						if (process || $this.hasClass('active-tab-title')) {
							return;
						}
						process = true;

						loadTab(atts, index, $inner, $this, cache, function(data) {
							if (data.html) {
								baselThemeModule.removeDuplicatedStylesFromHTML(data.html, function(html) {
									$inner.html(html);

									baselThemeModule.$document.trigger('basel-images-loaded');
									baselThemeModule.$document.trigger('basel-products-tabs-loaded');

									$inner.removeClass('loading').parent().removeClass('element-loading');
									$this.removeClass('loading');

									baselThemeModule.btnsToolTips();
									baselThemeModule.shopMasonry();
									baselThemeModule.productLoaderPosition();
									baselThemeModule.productsLoadMore();
									baselThemeModule.swatchesLimit();
								});
							}
						});

					});

					var $nav     = $this.find('.tabs-navigation-wrapper'),
					    $subList = $nav.find('ul');

					$nav.on('click', '.open-title-menu', function() {
							var $btn = $(this);

							if ($subList.hasClass('list-shown')) {
								$btn.removeClass('toggle-active');
								$subList.removeClass('list-shown');
							} else {
								$btn.addClass('toggle-active');
								$subList.addClass('list-shown');
								setTimeout(function() {
									baselThemeModule.$body.one('click', function(e) {
										var target = e.target;
										if (!$(target).is('.tabs-navigation-wrapper') && !$(target).parents().is('.tabs-navigation-wrapper')) {
											$btn.removeClass('toggle-active');
											$subList.removeClass('list-shown');
											return false;
										}
									});
								}, 10);
							}
						})
						.on('click', 'li', function() {
							var $btn = $nav.find('.open-title-menu'),
							    text = $(this).text();

							if ($subList.hasClass('list-shown')) {
								$btn.removeClass('toggle-active').text(text);
								$subList.removeClass('list-shown');
							}
						});
				});

				var loadTab = function(atts, index, holder, btn, cache, callback) {
					btn.parent().find('.active-tab-title').removeClass('active-tab-title');
					btn.addClass('active-tab-title');

					if (cache[index]) {
						holder.addClass('loading');
						setTimeout(function() {
							process = false;
							callback(cache[index]);
							holder.removeClass('loading');
						}, 300);
						return;
					}

					holder.addClass('loading').parent().addClass('element-loading');

					btn.addClass('loading');

					$.ajax({
						url     : basel_settings.ajaxurl,
						data    : {
							atts  : atts,
							action: 'basel_get_products_tab_shortcode'
						},
						dataType: 'json',
						method  : 'POST',
						success : function(data) {
							process = false;
							cache[index] = data;
							callback(data);
						},
						error   : function() {
							console.log('ajax error');
						},
						complete: function() {
							process = false;
							baselThemeModule.compare();
						}
					});
				};

			},

			portfolioLoadMore: function() {
				if (typeof $.fn.waypoint != 'function') {
					return;
				}

				var waypoint = $('.basel-portfolio-load-more.load-on-scroll').waypoint(function() {
					    $('.basel-portfolio-load-more.load-on-scroll').trigger('click');
				    }, {offset: '100%'}),
				    process  = false;

				$('.basel-portfolio-load-more').on('click', function(e) {
					e.preventDefault();
					var $this = $(this);

					if (process || $this.hasClass('no-more-posts')) {
						return;
					}

					process = true;

					var holder   = $this.parent().parent().find('.basel-portfolio-holder'),
					    source   = holder.data('source'),
					    action   = 'basel_get_portfolio_' + source,
					    ajaxurl  = basel_settings.ajaxurl,
					    dataType = 'json',
					    method   = 'POST',
					    timeout,
					    atts     = holder.data('atts'),
					    paged    = holder.data('paged');

					$this.addClass('loading');

					var data = {
						atts  : atts,
						paged : paged,
						action: action
					};

					if (source === 'main_loop') {
						ajaxurl = $this.attr('href');
						method = 'GET';
						data = {};
					}

					$.ajax({
						url     : ajaxurl,
						data    : data,
						dataType: dataType,
						method  : method,
						success : function(data) {
							baselThemeModule.removeDuplicatedStylesFromHTML(data.items, function(html) {
								var items = $(html);

								if (items) {
									if (holder.hasClass('masonry-container')) {
										holder.append(items).isotope('appended', items);
										holder.imagesLoaded().progress(function() {
											holder.isotope('layout');

											clearTimeout(timeout);

											timeout = setTimeout(function() {
												waypoint = $('.basel-portfolio-load-more.load-on-scroll').waypoint(function() {
													$('.basel-portfolio-load-more.load-on-scroll').trigger('click');
												}, {offset: '100%'});
											}, 1000);
										});
									} else {
										holder.append(items);
									}

									holder.data('paged', paged + 1);

									$this.attr('href', data.nextPage);
								}

								baselThemeModule.mfpPopup();

								if (data.status === 'no-more-posts') {
									$this.addClass('no-more-posts');
									$this.hide();
								}
							});
						},
						error   : function() {
							console.log('ajax error');
						},
						complete: function() {
							$this.removeClass('loading');
							process = false;
						}
					});
				});
			},

			shopMasonry: function() {
				if (typeof ($.fn.isotope) == 'undefined' || typeof ($.fn.imagesLoaded) == 'undefined') {
					return;
				}
				var $container = $('.elements-grid.grid-masonry');

				$container.imagesLoaded(function() {
					$container.isotope({
						isOriginLeft: !baselThemeModule.$body.hasClass('rtl'),
						itemSelector: '.category-grid-item, .product-grid-item'
					});
				});

				// Categories masonry
				function initMasonry() {
					var $catsContainer = $('.categories-masonry');
					var colWidth = ($catsContainer.hasClass('categories-style-masonry')) ? '.category-grid-item' : '.col-md-3.category-grid-item';
					$catsContainer.imagesLoaded(function() {
						$catsContainer.packery({
							resizable   : false,
							isOriginLeft: !baselThemeModule.$body.hasClass('rtl'),
							packery     : {
								gutter     : 0,
								columnWidth: colWidth
							},
							itemSelector: '.category-grid-item'
						});
					});
				}

				baselThemeModule.$window.on('resize', function() {
					initMasonry();
				});
				initMasonry();
			},

			sidebarMenu: function() {
				var heightMegaMenu = $('.widget_nav_mega_menu').height();
				var heightMegaNavigation = $('.categories-menu-dropdown').height();
				var subMenuHeight = $('.widget_nav_mega_menu ul > li.menu-item-design-sized > .sub-menu-dropdown, .widget_nav_mega_menu ul > li.menu-item-design-full-width > .sub-menu-dropdown');
				var megaNavigationHeight = $('.categories-menu-dropdown ul > li.menu-item-design-sized > .sub-menu-dropdown, .categories-menu-dropdown ul > li.menu-item-design-full-width > .sub-menu-dropdown');
				subMenuHeight.css(
					'min-height', heightMegaMenu + 'px'
				);

				megaNavigationHeight.css(
					'min-height', heightMegaNavigation + 'px'
				);
			},

			productImages: function() {
				var currentImage,
				    $productGallery   = $('.woocommerce-product-gallery'),
				    $mainImages       = $('.woocommerce-product-gallery__wrapper'),
				    $thumbs           = $productGallery.find('.thumbnails'),
				    gallery           = $('.photoswipe-images'),
				    PhotoSwipeTrigger = '.basel-show-product-gallery',
				    galleryType       = 'photo-swipe';

				$thumbs.addClass('thumbnails-ready');

				if ($productGallery.hasClass('image-action-popup')) {
					PhotoSwipeTrigger += ', .woocommerce-product-gallery__image a';
				}

				$productGallery.on('click', '.woocommerce-product-gallery__image a', function(e) {
					e.preventDefault();
				});

				$productGallery.on('click', PhotoSwipeTrigger, function(e) {
					e.preventDefault();

					currentImage = $(this).attr('href');

					if (galleryType === 'magnific') {
						$.magnificPopup.open({
							type    : 'image',
							tClose  : basel_settings.close,
							tLoading: basel_settings.loading,
							image   : {
								verticalFit: false
							},
							items   : getProductItems(),
							gallery : {
								enabled           : true,
								navigateByImgClick: false
							}
						}, 0);
					}

					if (galleryType === 'photo-swipe') {
						var items = getProductItems();

						baselThemeModule.callPhotoSwipe(getCurrentGalleryIndex(e), items);
					}
				});

				$thumbs.on('click', '.image-link', function(e) {
					e.preventDefault();
				});

				gallery.each(function() {
					var $this = $(this);
					$this.on('click', 'a', function(e) {
						e.preventDefault();
						var index = $(e.currentTarget).data('index') - 1;
						var items = getGalleryItems($this, []);
						baselThemeModule.callPhotoSwipe(index, items);
					});
				});

				var getCurrentGalleryIndex = function(e) {
					if ($mainImages.hasClass('owl-carousel')) {
						return $mainImages.find('.owl-item.active').index();
					} else {
						return $(e.currentTarget).parent().index();
					}
				};

				var getProductItems = function() {
					var items = [];

					$mainImages.find('figure a img').each(function() {
						var $this   = $(this),
						    src     = $this.attr('data-large_image'),
						    width   = $this.attr('data-large_image_width'),
						    height  = $this.attr('data-large_image_height'),
						    caption = $this.data('caption');

						items.push({
							src  : src,
							w    : width,
							h    : height,
							title: (basel_settings.product_images_captions === 'yes') ? caption : false
						});

					});

					return items;
				};

				var getGalleryItems = function($gallery, items) {
					var src, width, height, title;

					$gallery.find('a').each(function() {
						var $this = $(this);
						src = $this.attr('href');
						width = $this.data('width');
						height = $this.data('height');
						title = $this.attr('title');
						if (!isItemInArray(items, src)) {
							items.push({
								src  : src,
								w    : width,
								h    : height,
								title: title
							});
						}
					});

					return items;
				};

				var isItemInArray = function(items, src) {
					var i;
					for (i = 0; i < items.length; i++) {
						if (items[i].src === src) {
							return true;
						}
					}

					return false;
				};
			},

			callPhotoSwipe: function(index, items) {
				var pswpElement = document.querySelectorAll('.pswp')[0];

				if (baselThemeModule.$body.hasClass('rtl')) {
					index = items.length - index - 1;
					items = items.reverse();
				}

				// define options (if needed)
				var options = {
					index        : index,
					closeOnScroll: basel_settings.photoswipe_close_on_scroll,
					shareButtons : [
						{
							id   : 'facebook',
							label: basel_settings.share_fb,
							url  : 'https://www.facebook.com/sharer/sharer.php?u={{url}}'
						},
						{
							id   : 'twitter',
							label: basel_settings.tweet,
							url  : 'https://twitter.com/intent/tweet?text={{text}}&url={{url}}'
						},
						{
							id   : 'pinterest',
							label: basel_settings.pin_it,
							url  : 'https://www.pinterest.com/pin/create/button/' +
								'?url={{url}}&media={{image_url}}&description={{text}}'
						},
						{
							id      : 'download',
							label   : basel_settings.download_image,
							url     : '{{raw_image_url}}',
							download: true
						}
					]
				};

				// Initializes and opens PhotoSwipe
				var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
				gallery.init();
			},

			productImagesGallery: function() {
				var $mainGallery = $('.woocommerce-product-gallery__wrapper:not(.quick-view-gallery)');
				var $thumbs  = $('.images .thumbnails'),
				    $mainOwl = $('.woocommerce-product-gallery__wrapper');

				if (basel_settings.product_gallery.images_slider) {
					if (basel_settings.product_slider_auto_height === 'yes') {
						$('.product-images').imagesLoaded(function() {
							initMainGallery();
						});
					} else {
						initMainGallery();
					}
				}

				if (basel_settings.product_gallery.thumbs_slider.enabled && basel_settings.product_gallery.images_slider) {
					initThumbnailsMarkup();
					if (basel_settings.product_gallery.thumbs_slider.position === 'left' && jQuery(window).width() > 991) {
						initThumbnailsVertical();
					} else {
						initThumbnailsHorizontal();
					}
				}

				function initMainGallery() {
					$mainGallery.trigger('destroy.owl.carousel');
					$mainGallery.addClass('owl-carousel').owlCarousel(baselTheme.mainCarouselArg);
					baselThemeModule.$document.trigger('basel-images-loaded');
				}

				function initThumbnailsMarkup() {
					var markup = '';

					$mainGallery.find('.woocommerce-product-gallery__image').each(function() {
						var $this = $(this);
						var image = $this.data('thumb'),
						    alt   = $this.find('a > img').attr('alt'),
						    title = $this.find('a > img').attr('title');

						if (!title) {
							title = $this.find('a picture').attr('title');
						}

						markup += '<img alt="' + alt + '" title="' + title + '" src="' + image + '" />';
					});

					if ($thumbs.hasClass('slick-slider')) {
						$thumbs.slick('unslick');
					} else if ($thumbs.hasClass('owl-carousel')) {
						$thumbs.trigger('destroy.owl.carousel');
					}

					$thumbs.empty();
					$thumbs.append(markup);

				}

				function initThumbnailsVertical() {
					if ($thumbs.length === 0) {
						return;
					}

					$thumbs.slick({
						slidesToShow   : basel_settings.product_gallery.thumbs_slider.items.vertical_items,
						slidesToScroll : basel_settings.product_gallery.thumbs_slider.items.vertical_items,
						vertical       : true,
						verticalSwiping: true,
						infinite       : false
					});

					$thumbs.on('click', 'img', function() {
						var i = $(this).index();
						$mainOwl.trigger('to.owl.carousel', i);
					});

					$mainOwl.on('changed.owl.carousel', function(e) {
						var i = e.item.index;
						$thumbs.slick('slickGoTo', i);
						$thumbs.find('.active-thumb').removeClass('active-thumb');
						$thumbs.find('img').eq(i).addClass('active-thumb');
					});

					$thumbs.find('img').eq(0).addClass('active-thumb');
				}

				function initThumbnailsHorizontal() {
					$thumbs.addClass('owl-carousel').owlCarousel({
						rtl       : baselThemeModule.$body.hasClass('rtl'),
						items     : basel_settings.product_gallery.thumbs_slider.items.desktop,
						responsive: {
							979: {
								items: basel_settings.product_gallery.thumbs_slider.items.desktop
							},
							768: {
								items: basel_settings.product_gallery.thumbs_slider.items.desktop_small
							},
							479: {
								items: basel_settings.product_gallery.thumbs_slider.items.tablet
							},
							0  : {
								items: basel_settings.product_gallery.thumbs_slider.items.mobile
							}
						},
						dots      : false,
						nav       : true,
						navText   : false
					});

					var $thumbsOwl = $thumbs.owlCarousel();

					$thumbs.on('mousedown', '.owl-item', function() {
						var i = $(this).index();
						$thumbsOwl.trigger('to.owl.carousel', i);
						$mainOwl.trigger('to.owl.carousel', i);
					});

					$mainOwl.on('changed.owl.carousel', function(e) {
						var i = e.item.index;
						$thumbsOwl.trigger('to.owl.carousel', i);
						$thumbs.find('.active-thumb').removeClass('active-thumb');
						$thumbs.find('.owl-item').eq(i).addClass('active-thumb');
					});

					$thumbs.find('.owl-item').eq(0).addClass('active-thumb');
				}
			},

			stickyDetails: function() {
				if (!baselThemeModule.$body.hasClass('basel-product-design-sticky')) {
					return;
				}

				var details        = $('.entry-summary'),
				    detailsInner   = details.find('.summary-inner'),
				    detailsWidth   = details.width(),
				    images         = $('.product-images'),
				    thumbnails     = images.find('.woocommerce-product-gallery__wrapper a'),
				    offsetThumbnils,
				    viewportHeight = baselThemeModule.$window.height(),
				    imagesHeight   = images.outerHeight(),
				    topOffset      = 130,
				    maxWidth       = 600,
				    innerWidth,
				    detailsHeight  = details.outerHeight(),
				    scrollTop      = baselThemeModule.$window.scrollTop(),
				    imagesTop      = images.offset().top,
				    detailsLeft    = details.offset().left + 15,
				    imagesBottom   = imagesTop + imagesHeight,
				    detailsBottom  = scrollTop + topOffset + detailsHeight;

				details.css({
					height: detailsHeight
				});

				baselThemeModule.$window.on('resize', function() {
					recalculate();
				});

				baselThemeModule.$window.on('scroll', function() {
					onscroll();
					animateThumbnails();
				});

				images.imagesLoaded(function() {
					recalculate();
				});

				function animateThumbnails() {
					viewportHeight = baselThemeModule.$window.height();

					thumbnails.each(function() {
						var $this = $(this);
						offsetThumbnils = $this.offset().top;

						if (scrollTop > (offsetThumbnils - viewportHeight + 20)) {
							$this.addClass('animate-images');
						}
					});
				}

				function onscroll() {
					scrollTop = baselThemeModule.$window.scrollTop();
					detailsBottom = scrollTop + topOffset + detailsHeight;
					detailsWidth = details.width();
					detailsLeft = details.offset().left + 15;
					imagesTop = images.offset().top;
					imagesBottom = imagesTop + imagesHeight;

					if (detailsWidth > maxWidth) {
						innerWidth = (detailsWidth - maxWidth) / 2;
						detailsLeft = detailsLeft + innerWidth;
					}

					// Fix after scroll the header
					if (scrollTop + topOffset >= imagesTop) {
						details.addClass('block-sticked');

						detailsInner.css({
							top      : topOffset,
							left     : detailsLeft,
							width    : detailsWidth,
							position : 'fixed',
							transform: 'translateY(-20px)'
						});
					} else {
						details.removeClass('block-sticked');
						detailsInner.css({
							top      : 'auto',
							left     : 'auto',
							width    : 'auto',
							position : 'relative',
							transform: 'translateY(0px)'
						});
					}

					// When rich the bottom line
					if (detailsBottom > imagesBottom) {
						details.addClass('hide-temporary');
					} else {
						details.removeClass('hide-temporary');
					}
				}

				function recalculate() {
					viewportHeight = baselThemeModule.$window.height();
					detailsHeight = details.outerHeight();
					imagesHeight = images.outerHeight();

					// If enough space in the viewport
					if (detailsHeight < (viewportHeight - topOffset)) {
						details.addClass('in-viewport').removeClass('not-in-viewport');
					} else {
						details.removeClass('in-viewport').addClass('not-in-viewport');
					}
				}
			},

			mfpPopup: function() {
				$('.gallery').magnificPopup({
					tClose  : basel_settings.close,
					tLoading: basel_settings.loading,
					delegate: ' > a',
					type    : 'image',
					image   : {
						verticalFit: true
					},
					gallery : {
						enabled           : true,
						navigateByImgClick: true
					}
				});

				$('[data-rel="mfp"]').magnificPopup({
					tClose  : basel_settings.close,
					tLoading: basel_settings.loading,
					type    : 'image',
					image   : {
						verticalFit: true
					},
					gallery : {
						enabled           : false,
						navigateByImgClick: false
					}
				});

				baselThemeModule.$document.on('click', '.mfp-img', function() {
					var mfp = jQuery.magnificPopup.instance;
					mfp.st.image.verticalFit = !mfp.st.image.verticalFit;
					mfp.currItem.img.removeAttr('style');
					mfp.updateSize();
				});
			},

			addToCart: function() {
				var that = this;
				var timeoutNumber = 0;
				var timeout;

				baselThemeModule.$body.on('added_to_cart', function() {
					if (basel_settings.add_to_cart_action === 'popup') {
						var html = [
							'<div class="added-to-cart">',
							'<p>' + basel_settings.added_to_cart + '</p>',
							'<a href="#" class="btn btn-style-link close-popup">' + basel_settings.continue_shopping + '</a>',
							'<a href="' + basel_settings.cart_url + '" class="btn btn-color-primary view-cart">' + basel_settings.view_cart + '</a>',
							'</div>'
						].join('');

						$.magnificPopup.open({
							tClose      : basel_settings.close,
							tLoading    : basel_settings.loading,
							removalDelay: 500,
							callbacks   : {
								beforeOpen: function() {
									this.st.mainClass = baselTheme.popupEffect + '  cart-popup-wrapper';
								}
							},
							items       : {
								src : '<div class="white-popup add-to-cart-popup mfp-with-anim popup-added_to_cart">' + html + '</div>',
								type: 'inline'
							}
						});

						$('.white-popup').on('click', '.close-popup', function(e) {
							e.preventDefault();
							$.magnificPopup.close();
						});

						closeAfterTimeout();
					} else if (basel_settings.add_to_cart_action === 'widget') {
						clearTimeout(timeoutNumber);

						var currentHeader = ($('.sticky-header.act-scroll').length > 0) ? $('.sticky-header .dropdown-wrap-cat') : $('.main-header .dropdown-wrap-cat');

						var $opener = $('.cart-widget-opener a');
						if ($opener.length > 0) {
							$opener.trigger('click');
						} else if ($('.shopping-cart .a').length > 0) {
							$('.shopping-cart .dropdown-wrap-cat').addClass('display-widget');
							timeoutNumber = setTimeout(function() {
								$('.display-widget').removeClass('display-widget');
							}, 3500);
						} else {
							currentHeader.addClass('display-widget');
							timeoutNumber = setTimeout(function() {
								$('.display-widget').removeClass('display-widget');
							}, 3500);
						}

						closeAfterTimeout();
					}

					that.btnsToolTips();
				});

				var closeAfterTimeout = function() {
					if ('yes' !== basel_settings.add_to_cart_action_timeout) {
						return false;
					}

					clearTimeout(timeout);

					timeout = setTimeout(function() {
						$('.basel-close-side').trigger('click');
						$.magnificPopup.close();
					}, parseInt(basel_settings.add_to_cart_action_timeout_number) * 1000);
				};
			},

			updateWishListNumberInit: function() {
				if (basel_settings.wishlist === 'no' || $('.wishlist-count').length <= 0) {
					return;
				}

				var that = this;

				if (baselTheme.supports_html5_storage) {

					try {
						var wishlistNumber = sessionStorage.getItem('basel_wishlist_number'),
						    cookie_hash    = Cookies.get('basel_wishlist_hash');

						if (wishlistNumber === null || wishlistNumber === undefined || wishlistNumber === '') {
							wishlistNumber = 0;
						}

						if (cookie_hash === null || cookie_hash === undefined || cookie_hash === '') {
							cookie_hash = 0;
						}

						if (wishlistNumber == cookie_hash) {
							this.setWishListNumber(wishlistNumber);
						} else {
							throw 'No wishlist number';
						}
					}
					catch (err) {
						this.updateWishListNumber();
					}

				} else {
					this.updateWishListNumber();
				}

				baselThemeModule.$body.on('added_to_cart added_to_wishlist removed_from_wishlist', function() {
					that.updateWishListNumber();
					that.btnsToolTips();
					that.woocommerceWrappTable();
				});
			},

			updateCartWidgetFromLocalStorage: function() {
				if (baselTheme.supports_html5_storage) {
					try {
						var wc_fragments = JSON.parse(sessionStorage.getItem(wc_cart_fragments_params.fragment_name));

						if (wc_fragments && wc_fragments['div.widget_shopping_cart_content']) {

							$.each(wc_fragments, function(key, value) {
								$(key).replaceWith(value);
							});

							baselThemeModule.$body.trigger('wc_fragments_loaded');
						} else {
							throw 'No fragment';
						}

					}
					catch (err) {
						console.log('cant update cart widget');
					}
				}
			},

			updateWishListNumber: function() {
				var that = this;
				$.ajax({
					url    : basel_settings.ajaxurl,
					data   : {
						action: 'basel_wishlist_number'
					},
					method : 'get',
					success: function(data) {
						that.setWishListNumber(data);
						if (baselTheme.supports_html5_storage) {
							sessionStorage.setItem('basel_wishlist_number', data);
						}
					}
				});
			},

			setWishListNumber: function(num) {
				num = ($.isNumeric(num)) ? num : 0;
				$('.wishlist-info-widget .wishlist-count').text(num);
			},

			cartWidget: function() {
				var widget = $('.cart-widget-opener'),
				    body   = baselThemeModule.$body;

				widget.on('click', 'a', function(e) {
					if (!isCart() && !isCheckout()) {
						e.preventDefault();
					}

					if (isOpened()) {
						closeWidget();
					} else {
						setTimeout(function() {
							openWidget();
						}, 10);
					}
				});

				body.on('click touchstart', '.basel-close-side', function() {
					if (isOpened()) {
						closeWidget();
					}
				});

				body.on('click', '.widget-close', function(e) {
					e.preventDefault();
					if (isOpened()) {
						closeWidget();
					}
				});

				baselThemeModule.$document.on('keyup', function(e) {
					if (e.keyCode === 27 && isOpened()) {
						closeWidget();
					}
				});

				var closeWidget = function() {
					baselThemeModule.$body.removeClass('basel-cart-opened');
				};

				var openWidget = function() {
					if (isCart() || isCheckout()) {
						return false;
					}
					baselThemeModule.$body.addClass('basel-cart-opened');
				};

				var isOpened = function() {
					return baselThemeModule.$body.hasClass('basel-cart-opened');
				};

				var isCart = function() {
					return baselThemeModule.$body.hasClass('woocommerce-cart');
				};

				var isCheckout = function() {
					return baselThemeModule.$body.hasClass('woocommerce-checkout');
				};

				baselThemeModule.$document.on('wc_fragments_refreshed wc_fragments_loaded added_to_cart', function() {
					baselThemeModule.$document.trigger('basel-images-loaded');
				});
			},

			bannersHover: function() {
				var $banner = $('.promo-banner.hover-4');

				if ($banner.length > 0) {
					$banner.panr({
						sensitivity         : 20,
						scale               : false,
						scaleOnHover        : true,
						scaleTo             : 1.15,
						scaleDuration       : .34,
						panY                : true,
						panX                : true,
						panDuration         : 0.5,
						resetPanOnMouseLeave: true
					});
				}
			},

			parallax: function() {
				$('.parallax-yes').each(function() {
					var $bgobj = $(this);
					baselThemeModule.$window.on('scroll', function() {
						var yPos = -(baselThemeModule.$window.scrollTop() / $bgobj.data('speed'));
						var coords = 'center ' + yPos + 'px';
						$bgobj.css({
							backgroundPosition: coords
						});
					});
				});

				$('.basel-parallax').each(function() {
					var $this = $(this);
					if ($this.hasClass('wpb_column')) {
						$this.find('> .vc_column-inner').parallax('50%', 0.3);
					} else {
						$this.parallax('50%', 0.3);
					}
				});
			},

			scrollTop: function() {
				baselThemeModule.$window.on('scroll', function() {
					if ($(this).scrollTop() > 100) {
						$('.scrollToTop').addClass('button-show');
					} else {
						$('.scrollToTop').removeClass('button-show');
					}
				});

				$('.scrollToTop').on('click', function() {
					$('html, body').animate({
						scrollTop: 0
					}, 800);
					return false;
				});
			},

			quickViewInit: function() {
				var that = this;
				// Open popup with product info when click on Quick View button
				baselThemeModule.$document.on('click', '.open-quick-view', function(e) {

					e.preventDefault();

					if ($('.open-quick-view').hasClass('loading')) {
						return true;
					}

					var $this = $(this);
					var productId = $this.data('id'),
					    loopName  = $this.data('loop-name'),
					    loop      = $this.data('loop'),
					    prev      = '',
					    next      = '',
					    loopBtns  = $('.quick-view').find('[data-loop-name="' + loopName + '"]'),
					    btn       = $this;

					btn.addClass('loading');

					if (typeof loopBtns[loop - 1] != 'undefined') {
						prev = loopBtns.eq(loop - 1).addClass('quick-view-prev');
						prev = $('<div>').append(prev.clone()).html();
					}

					if (typeof loopBtns[loop + 1] != 'undefined') {
						next = loopBtns.eq(loop + 1).addClass('quick-view-next');
						next = $('<div>').append(next.clone()).html();
					}

					that.quickViewLoad(productId, btn, prev, next);
				});
			},

			quickViewCarousel: function() {
				var $wrapper = $('.product-quick-view .woocommerce-product-gallery__wrapper');
				$wrapper.trigger('destroy.owl.carousel');
				$wrapper.addClass('owl-carousel').owlCarousel({
					rtl    : baselThemeModule.$body.hasClass('rtl'),
					items  : 1,
					dots   : false,
					nav    : true,
					navText: false
				});
			},

			quickViewLoad: function(id, btn) {
				var data = {
					id    : id,
					action: 'basel_quick_view'
				};

				var initPopup = function(data) {
					var items = $(data);

					$.magnificPopup.open({
						items       : {
							src : items,
							type: 'inline'
						},
						tClose      : basel_settings.close,
						tLoading    : basel_settings.loading,
						removalDelay: 500,
						callbacks   : {
							beforeOpen: function() {
								this.st.mainClass = baselTheme.popupEffect;
							},
							open      : function() {
								var $form = $('.variations_form');
								$form.each(function() {
									$(this).wc_variation_form().find('.variations select:eq(0)').change();
								});
								$form.trigger('wc_variation_form');
								baselThemeModule.$body.trigger('basel-quick-view-displayed');
								baselThemeModule.swatchesVariations();

								baselThemeModule.btnsToolTips();
								baselThemeModule.swatchesLimit();
								baselThemeModule.quickViewCarousel();
							}
						}
					});
				};

				$.ajax({
					url     : basel_settings.ajaxurl,
					data    : data,
					method  : 'get',
					success : function(data) {
						baselThemeModule.removeDuplicatedStylesFromHTML(data, function(data) {
							if (basel_settings.quickview_in_popup_fix) {
								$.magnificPopup.close();
								setTimeout(function() {
									initPopup(data);
								}, 500);
							} else {
								initPopup(data);
							}
						});
					},
					complete: function() {
						btn.removeClass('loading');
					},
					error   : function() {
					}
				});
			},

			quickShop: function() {
				var btnSelector = '.btn-quick-shop';

				baselThemeModule.$document.on('click', btnSelector, function(e) {
						e.preventDefault();

						var $this        = $(this),
						    $product     = $this.parents('.product'),
						    $content     = $product.find('.quick-shop-form'),
						    id           = $this.data('id'),
						    loadingClass = 'btn-loading';

						if ($this.hasClass(loadingClass)) {
							return;
						}

						// Simply show quick shop form if it is already loaded with AJAX previously
						if ($product.hasClass('quick-shop-loaded')) {
							$product.addClass('quick-shop-shown');
							return;
						}

						$this.addClass(loadingClass);
						$product.addClass('loading-quick-shop');

						$.ajax({
							url     : basel_settings.ajaxurl,
							data    : {
								action: 'basel_quick_shop',
								id    : id
							},
							method  : 'get',
							success : function(data) {

								// insert variations form
								$content.append(data);

								initVariationForm($product);
								baselThemeModule.$body.trigger('basel-quick-view-displayed');
								baselThemeModule.swatchesVariations();
								baselThemeModule.btnsToolTips();
								baselThemeModule.swatchesLimit();

							},
							complete: function() {
								$this.removeClass(loadingClass);
								$product.removeClass('loading-quick-shop');
								$product.addClass('quick-shop-shown quick-shop-loaded');
							}
						});
					})
					.on('click', '.quick-shop-close', function() {
						var $this    = $(this),
						    $product = $this.parents('.product');

						$product.removeClass('quick-shop-shown');
					});

				function initVariationForm($product) {
					$product.find('.variations_form').wc_variation_form().find('.variations select:eq(0)').change();
					$product.find('.variations_form').trigger('wc_variation_form');
				}
			},

			btnsToolTips: function() {
				$('.basel-tooltip, .product-actions-btns > a, .product-grid-item .add_to_cart_button, .quick-view a, .product-compare-button a, .product-grid-item .yith-wcwl-add-to-wishlist a').on('mouseenter touchstart', function() {
					var $this = $(this);

					if ($(window).width() <= 1024 || $this.hasClass('basel-tooltip-inited')) {
						return;
					}

					$this.find('.basel-tooltip-label').remove();
					$this.addClass('basel-tooltip').prepend('<span class="basel-tooltip-label">' + $this.text() + '</span>');

					$this.addClass('basel-tooltip-inited');
				});
			},

			stickyFooter: function() {
				if (!baselThemeModule.$body.hasClass('sticky-footer-on') || baselThemeModule.windowWidth < 991) {
					return;
				}

				var $footer = $('.footer-container'),
				    $page   = $('.main-page-wrapper'),
				    $window = baselThemeModule.$window;

				var $prefooter = $('.basel-prefooter');
				if ($prefooter.length > 0) {
					$page = $prefooter;
				}

				var footerOffset = function() {
					$page.css({
						marginBottom: $footer.outerHeight()
					});
				};

				$window.on('resize', footerOffset);

				$footer.imagesLoaded(function() {
					footerOffset();
				});

				var footerScrollFix = function() {
					var windowScroll = $window.scrollTop();
					var footerOffsetTop = baselThemeModule.$document.outerHeight() - $footer.outerHeight();

					if (footerOffsetTop < windowScroll + $footer.outerHeight() + $window.outerHeight()) {
						$footer.addClass('visible-footer');
					} else {
						$footer.removeClass('visible-footer');
					}
				};

				footerScrollFix();
				$window.on('scroll', footerScrollFix);
			},

			swatchesVariations: function() {
				var $variation_forms = $('.variations_form');
				var variationGalleryReplace = false;

				// Firefox mobile fix.
				$('.variations_form .label').on('click', function(e) {
					if ($(this).siblings('.value').hasClass('with-swatches')) {
						e.preventDefault();
					}
				});

				$variation_forms.each(function() {
					var $variation_form = $(this);

					if ($variation_form.data('swatches')) {
						return;
					}
					$variation_form.data('swatches', true);

					if (!$variation_form.data('product_variations')) {
						$variation_form.find('.swatches-select').find('> div').addClass('swatch-enabled');
					}

					if ($('.swatches-select > div').hasClass('active-swatch')) {
						$variation_form.addClass('variation-swatch-selected');
					}

					$variation_form.on('click', '.swatches-select > div', function() {
							var $this = $(this);
							var value = $this.data('value');
							var id = $this.parent().data('id');

							resetSwatches($variation_form);

							if ($this.hasClass('active-swatch')) {
								return;
							}

							if ($this.hasClass('swatch-disabled')) {
								return;
							}
							$variation_form.find('select#' + id).val(value).trigger('change');
							$this.parent().find('.active-swatch').removeClass('active-swatch');
							$this.addClass('active-swatch');
							resetSwatches($variation_form);
						})
						.on('click', '.reset_variations', function() {
							$variation_form.find('.active-swatch').removeClass('active-swatch');
						})
						.on('reset_data', function() {
							var $this = $(this);
							var all_attributes_chosen = true;
							var some_attributes_chosen = false;

							$variation_form.find('.variations select').each(function() {
								var value = $this.val() || '';

								if (value.length === 0) {
									all_attributes_chosen = false;
								} else {
									some_attributes_chosen = true;
								}

							});

							if (all_attributes_chosen) {
								$this.parent().find('.active-swatch').removeClass('active-swatch');
							}

							$variation_form.removeClass('variation-swatch-selected');

							var $mainOwl = $('.woocommerce-product-gallery__wrapper.owl-carousel');

							resetSwatches($variation_form);

							if ($mainOwl.length === 0) {
								return;
							}

							if (basel_settings.product_slider_auto_height === 'yes') {
								if (!isQuickView() && isVariationGallery('default') && variationGalleryReplace) {
									$mainOwl.trigger('destroy.owl.carousel');
								}
								$('.product-images').imagesLoaded(function() {
									$mainOwl = $mainOwl.owlCarousel(baselTheme.mainCarouselArg);
									$mainOwl.trigger('refresh.owl.carousel');
								});
							} else {
								$mainOwl = $mainOwl.owlCarousel(baselTheme.mainCarouselArg);
								$mainOwl.trigger('refresh.owl.carousel');
							}

							$mainOwl.trigger('to.owl.carousel', 0);

							replaceMainGallery('default', $variation_form);
						})
						.on('reset_image', function() {
							var $thumb = $('.thumbnails img').first();
							if (!isQuickView() && !isQuickShop($variation_form)) {
								$thumb.wc_reset_variation_attr('src');
							}
						})
						.on('show_variation', function(e, variation) {
							if (!variation.image.src) {
								return;
							}

							// See if the gallery has an image with the same original src as the image we want to switch to.
							var galleryHasImage = $variation_form.parents('.single-product-content').find('.thumbnails img[data-o_src="' + variation.image.thumb_src + '"]').length > 0;
							var $firstThumb = $variation_form.parents('.single-product-content').find('.thumbnails img').first();

							// If the gallery has the image, reset the images. We'll scroll to the correct one.
							if (galleryHasImage) {
								$firstThumb.wc_reset_variation_attr('src');
							}

							if (!isQuickShop($variation_form) && !replaceMainGallery(variation.variation_id, $variation_form)) {
								if ($firstThumb.attr('src') != variation.image.thumb_src) {
									$firstThumb.wc_set_variation_attr('src', variation.image.src);
								}
								baselThemeModule.initZoom();
							}

							var $mainOwl = $('.woocommerce-product-gallery__wrapper');

							$variation_form.addClass('variation-swatch-selected');

							if (!isQuickShop($variation_form) && !isQuickView()) {
								scrollToTop();
							}

							if (!$mainOwl.hasClass('owl-carousel')) {
								return;
							}

							if (basel_settings.product_slider_auto_height === 'yes') {
								if (!isQuickView() && isVariationGallery(variation.variation_id) && variationGalleryReplace) {
									$mainOwl.trigger('destroy.owl.carousel');
								}
								$('.product-images').imagesLoaded(function() {
									$mainOwl = $mainOwl.owlCarousel(baselTheme.mainCarouselArg);
									$mainOwl.trigger('refresh.owl.carousel');
								});
							} else {
								$mainOwl = $mainOwl.owlCarousel(baselTheme.mainCarouselArg);
								$mainOwl.trigger('refresh.owl.carousel');
							}

							var $thumbs = $('.images .thumbnails');

							$mainOwl.trigger('to.owl.carousel', 0);

							if ($thumbs.hasClass('owl-carousel')) {
								$thumbs.owlCarousel().trigger('to.owl.carousel', 0);
								$thumbs.find('.active-thumb').removeClass('active-thumb');
								$thumbs.find('.owl-item').eq(0).addClass('active-thumb');
							} else if ($thumbs.length > 0) {
								$thumbs.slick('slickGoTo', 0);
								$thumbs.find('.active-thumb').removeClass('active-thumb');
								$thumbs.find('img').eq(0).addClass('active-thumb');
							}
						});
				});

				var resetSwatches = function($variation_form) {
					// If using AJAX
					if (!$variation_form.data('product_variations')) {
						return;
					}

					$variation_form.find('.variations select').each(function() {

						var select = $(this);
						var swatch = select.parent().find('.swatches-select');
						var options = select.html();

						options = $(options);

						swatch.find('> div').removeClass('swatch-enabled').addClass('swatch-disabled');

						options.each(function() {
							var $this = $(this);
							var value = $this.val();

							if ($this.hasClass('enabled')) {
								swatch.find('div[data-value="' + value + '"]').removeClass('swatch-disabled').addClass('swatch-enabled');
							} else {
								swatch.find('div[data-value="' + value + '"]').addClass('swatch-disabled').removeClass('swatch-enabled');
							}
						});
					});
				};

				var scrollToTop = function() {
					if ((basel_settings.swatches_scroll_top_desktop == 1 && baselThemeModule.windowWidth >= 1024) || (basel_settings.swatches_scroll_top_mobile == 1 && baselThemeModule.windowWidth <= 1024)) {
						var $page = $('html, body');

						$page.stop(true);
						baselThemeModule.$window.on('mousedown wheel DOMMouseScroll mousewheel keyup touchmove', function() {
							$page.stop(true);
						});
						$page.animate({
							scrollTop: $('.product-image-summary').offset().top - 150
						}, 800);
					}
				};

				var isQuickShop = function($form) {
					return $form.parent().hasClass('quick-shop-form');
				};

				var isQuickView = function() {
					return $('.single-product-content').hasClass('product-quick-view');
				};

				var isVariationGallery = function(key) {
					if (typeof basel_variation_gallery_data === 'undefined' && typeof basel_qv_variation_gallery_data === 'undefined') {
						return;
					}

					var variation_gallery_data = isQuickView() ? basel_qv_variation_gallery_data : basel_variation_gallery_data;

					return typeof variation_gallery_data !== 'undefined' && variation_gallery_data && variation_gallery_data[key];
				};

				var replaceMainGallery = function(key, $variationForm) {
					if (!isVariationGallery(key) || isQuickShop($variationForm) || ('default' === key && !variationGalleryReplace)) {
						return false;
					}

					var variation_gallery_data = isQuickView() ? basel_qv_variation_gallery_data : basel_variation_gallery_data;

					var imagesData = variation_gallery_data[key];
					var $mainGallery = $variationForm.parents('.single-product-content').find('.woocommerce-product-gallery__wrapper');
					$mainGallery.empty();

					for (var index = 0; index < imagesData.length; index++) {
						var $html = '<figure data-thumb="' + imagesData[index].data_thumb + '" class="woocommerce-product-gallery__image">';

						if (!isQuickView()) {
							$html += '<a href="' + imagesData[index].href + '">';
						}

						$html += imagesData[index].image;

						if (!isQuickView()) {
							$html += '</a>';
						}

						$html += '</figure>';

						$mainGallery.append($html);
					}

					baselThemeModule.productImagesGallery();
					baselThemeModule.quickViewCarousel();
					$('.woocommerce-product-gallery__image').trigger('zoom.destroy');
					if (!isQuickView()) {
						baselThemeModule.initZoom();
					}

					variationGalleryReplace = 'default' !== key;

					return true;
				};

			},

			swatchesOnGrid: function() {
				baselThemeModule.$body.on('click', '.swatch-on-grid', function() {

					var src, srcset, image_sizes;

					var $this = $(this);
					var imageSrc    = $this.data('image-src'),
					    imageSrcset = $this.data('image-srcset'),
					    imageSizes  = $this.data('image-sizes');

					if (typeof imageSrc == 'undefined') {
						return;
					}

					var product    = $this.parents('.product-grid-item'),
					    image      = product.find('.product-element-top > a img'),
					    srcOrig    = image.data('original-src'),
					    source     = product.find('.product-element-top > a picture source'),
					    srcsetOrig = image.data('original-srcset'),
					    sizesOrig  = image.data('original-sizes');

					if (typeof srcOrig == 'undefined') {
						image.data('original-src', image.attr('src'));
					}

					if (typeof srcsetOrig == 'undefined') {
						image.data('original-srcset', image.attr('srcset'));
					}

					if (typeof sizesOrig == 'undefined') {
						image.data('original-sizes', image.attr('sizes'));
					}

					if ($this.hasClass('current-swatch')) {
						src = srcOrig;
						srcset = srcsetOrig;
						image_sizes = sizesOrig;
						$this.removeClass('current-swatch');
						product.removeClass('product-swatched');
					} else {
						$this.parent().find('.current-swatch').removeClass('current-swatch');
						$this.addClass('current-swatch');
						product.addClass('product-swatched');
						src = imageSrc;
						srcset = imageSrcset;
						image_sizes = imageSizes;
					}

					if (image.attr('src') === src) {
						return;
					}

					product.addClass('loading-image');

					image.attr('src', src).attr('srcset', srcset).attr('image_sizes', image_sizes).one('load', function() {
						product.removeClass('loading-image');
					});

					if (source.length > 0) {
						source.attr('srcset', srcset).attr('image_sizes', image_sizes);
					}
				});
			},

			ajaxFilters: function() {
				if (!baselThemeModule.$body.hasClass('basel-ajax-shop-on') || typeof ($.fn.pjax) == 'undefined' || baselThemeModule.$body.hasClass('single-product')) {
					return;
				}

				var that         = this,
				    filtersState = false;

				baselThemeModule.$body.on('click', '.post-type-archive-product .products-footer .woocommerce-pagination a', function() {
					scrollToTop();
				});

				baselThemeModule.$document.pjax(baselTheme.ajaxLinks, '.main-page-wrapper', {
					timeout       : basel_settings.pjax_timeout,
					scrollTo      : false,
					renderCallback: function(context, html, afterRender) {
						baselThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
							context.html(html);
							afterRender();
							baselThemeModule.shopPageInit();
							baselThemeModule.$document.trigger('basel-images-loaded');
						});
					}
				});

				baselThemeModule.$document.on('click', '.widget_price_filter form .button', function() {
					var form = $('.widget_price_filter form');
					console.log(form.serialize());
					$.pjax({
						container     : '.main-page-wrapper',
						timeout       : basel_settings.pjax_timeout,
						url           : form.attr('action'),
						data          : form.serialize(),
						scrollTo      : false,
						renderCallback: function(context, html, afterRender) {
							baselThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
								context.html(html);
								afterRender();
								baselThemeModule.shopPageInit();
								baselThemeModule.$document.trigger('basel-images-loaded');
							});
						}
					});

					return false;
				});

				baselThemeModule.$document.on('pjax:error', function(xhr, textStatus, error) {
					console.log('pjax error ' + error);
				});

				baselThemeModule.$document.on('pjax:start', function() {
					baselThemeModule.$body.addClass('basel-loading');
					baselThemeModule.hideShopSidebar();
				});

				baselThemeModule.$document.on('pjax:beforeReplace', function() {
					if ($('.filters-area').hasClass('filters-opened') && basel_settings.shop_filters_close === 'yes') {
						filtersState = true;
						baselThemeModule.$body.addClass('body-filters-opened');
					}
				});

				baselThemeModule.$document.on('pjax:complete', function() {
					that.shopPageInit();

					scrollToTop();

					baselThemeModule.$document.trigger('basel-images-loaded');

					$('.basel-sidebar-content').on('scroll', function() {
						baselThemeModule.$document.trigger('basel-images-loaded');
					});

					baselThemeModule.$body.removeClass('basel-loading');
				});

				baselThemeModule.$document.on('pjax:end', function() {
					if (filtersState) {
						$('.filters-area').css('display', 'block');
						baselThemeModule.openFilters(200);
						filtersState = false;
					}

					baselThemeModule.$body.removeClass('basel-loading');
				});

				var scrollToTop = function() {
					if (basel_settings.ajax_scroll === 'no') {
						return false;
					}

					var $scrollTo = $(basel_settings.ajax_scroll_class),
					    scrollTo  = $scrollTo.offset().top - basel_settings.ajax_scroll_offset;

					$('html, body').stop().animate({
						scrollTop: scrollTo
					}, 400);
				};
			},

			shopPageInit: function() {
				this.shopMasonry();
				this.ajaxSearch();
				this.btnsToolTips();
				this.compare();
				this.filterDropdowns();
				this.categoriesMenuBtns();
				this.sortByWidget();
				this.categoriesAccordion();
				this.woocommercePriceSlider();
				this.updateCartWidgetFromLocalStorage();
				this.countDownTimer();
				this.shopLoader();
				this.stickySidebarBtn();
				this.productFilters();
				this.categoriesDropdowns();
				this.swatchesLimit();

				baselThemeModule.clickOnScrollButton(baselTheme.shopLoadMoreBtn, false);

				$('.woocommerce-ordering').on('change', 'select.orderby', function() {
					var $this = $(this);
					$this.closest('form').find('[name="_pjax"]').remove();
					$this.closest('form').submit();
				});

				baselThemeModule.$body.on('updated_wc_div', function() {
					baselThemeModule.$document.trigger('basel-images-loaded');
				});

				// baselThemeModule.$document.trigger('resize.vcRowBehaviour');

				baselThemeModule.$document.trigger('basel-shop-page-inited');
			},

			filterDropdowns: function() {
				$('.basel-widget-layered-nav-dropdown-form').each(function() {
					var $form = $(this);
					var $select = $form.find('select');
					var slug = $select.data('slug');

					$select.on('change', function() {
						var val = $(this).val();
						$('input[name=filter_' + slug + ']').val(val);
					});

					if ($().selectWoo) {
						$select.selectWoo({
							placeholder            : $select.data('placeholder'),
							minimumResultsForSearch: 5,
							width                  : '100%',
							allowClear             : !$select.attr('multiple'),
							language               : {
								noResults: function() {
									return $select.data('noResults');
								}
							}
						}).on('select2:unselecting', function() {
							$(this).data('unselecting', true);
						}).on('select2:opening', function(e) {
							var $this = $(this);
							if ($this.data('unselecting')) {
								$this.removeData('unselecting');
								e.preventDefault();
							}
						});
					}
				});

				function ajaxAction($element) {
					var $form = $element.parent('.basel-widget-layered-nav-dropdown-form');
					if (!baselThemeModule.$body.hasClass('basel-ajax-shop-on') || typeof ($.fn.pjax) == 'undefined') {
						return;
					}

					$.pjax({
						container     : '.main-page-wrapper',
						timeout       : basel_settings.pjax_timeout,
						url           : $form.attr('action'),
						data          : $form.serialize(),
						scrollTo      : false,
						renderCallback: function(context, html, afterRender) {
							baselThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
								context.html(html);
								afterRender();
								baselThemeModule.shopPageInit();
								baselThemeModule.$document.trigger('basel-images-loaded');
							});
						}
					});
				}

				$('.basel-widget-layered-nav-dropdown__submit').on('click', function() {
					var $this = $(this);
					if (!$this.siblings('select').attr('multiple') || !baselThemeModule.$body.hasClass('basel-ajax-shop-on')) {
						return;
					}

					ajaxAction($this);

					$this.prop('disabled', true);
				});

				$('.basel-widget-layered-nav-dropdown-form select').on('change', function() {
					var $this = $(this);
					if (!baselThemeModule.$body.hasClass('basel-ajax-shop-on')) {
						$this.parent().submit();
						return;
					}

					ajaxAction($this);
				});
			},

			backHistory: function() {
				history.go(-1);

				setTimeout(function() {
					$('.filters-area').removeClass('filters-opened').stop().hide();
					$('.open-filters').removeClass('btn-opened');
					if (baselThemeModule.windowWidth < 992) {
						$('.basel-product-categories').removeClass('categories-opened').stop().hide();
						$('.basel-show-categories').removeClass('button-open');
					}

					baselThemeModule.woocommercePriceSlider();
				}, 20);
			},

			categoriesMenu: function() {
				if (baselThemeModule.windowWidth > 991) {
					return;
				}

				var categories = $('.basel-product-categories'),
				    time       = 200;

				baselThemeModule.$body.on('click', '.icon-drop-category', function() {
					var $this = $(this);
					if ($this.parent().find('> ul').hasClass('child-open')) {
						$this.removeClass('basel-act-icon').parent().find('> ul').slideUp(time).removeClass('child-open');
					} else {
						$this.addClass('basel-act-icon').parent().find('> ul').slideDown(time).addClass('child-open');
					}
				});

				baselThemeModule.$body.on('click', '.basel-show-categories', function(e) {
					e.preventDefault();

					if (isOpened()) {
						closeCats();
					} else {
						openCats();
					}
				});

				baselThemeModule.$body.on('click', '.basel-product-categories a', function() {
					closeCats();
					categories.stop().attr('style', '');
				});

				var isOpened = function() {
					return $('.basel-product-categories').hasClass('categories-opened');
				};

				var openCats = function() {
					$('.basel-product-categories').addClass('categories-opened').stop().slideDown(time);
					$('.basel-show-categories').addClass('button-open');

				};

				var closeCats = function() {
					$('.basel-product-categories').removeClass('categories-opened').stop().slideUp(time);
					$('.basel-show-categories').removeClass('button-open');
				};
			},

			categoriesMenuBtns: function() {
				if (baselThemeModule.windowWidth > 991) {
					return;
				}

				var categories    = $('.basel-product-categories'),
				    subCategories = categories.find('li > ul'),
				    iconDropdown  = '<span class="icon-drop-category"></span>';

				categories.addClass('responsive-cateogires');
				subCategories.parent().addClass('has-sub').prepend(iconDropdown);
			},

			categoriesAccordion: function() {
				if (basel_settings.categories_toggle === 'no') {
					return;
				}

				var $widget  = $('.widget_product_categories'),
				    $list    = $widget.find('.product-categories'),
				    $openBtn = $('<div class="basel-cats-toggle" />'),
				    time     = 300;

				$list.find('.cat-parent').each(function() {
					var $this = $(this);

					if ($this.find(' > .basel-cats-toggle').length > 0) {
						return;
					}
					if ($this.find(' > .children').length === 0 || $this.find(' > .children > *').length === 0) {
						return;
					}

					$this.append('<div class="basel-cats-toggle"></div>');
				});

				$('body').on('click', '.basel-cats-toggle', function() {
					var $btn     = $(this),
					    $subList = $btn.prev();

					if ($subList.hasClass('list-shown')) {
						$btn.removeClass('toggle-active');
						$subList.stop(true, true).slideUp(time).removeClass('list-shown');
					} else {
						$subList.parent().parent().find('> li > .list-shown').slideUp().removeClass('list-shown');
						$subList.parent().parent().find('> li > .toggle-active').removeClass('toggle-active');
						$btn.addClass('toggle-active');
						$subList.stop(true, true).slideDown(time).addClass('list-shown');
					}
				});

				if ($list.find('li.current-cat.cat-parent, li.current-cat-parent').length > 0) {
					$list.find('li.current-cat.cat-parent, li.current-cat-parent').find('> .basel-cats-toggle').click();
				}

			},

			woocommercePriceSlider: function() {
				var $products = $('.products');
				var $minPrice = $('.price_slider_amount #min_price');
				if (typeof woocommerce_price_slider_params === 'undefined' || $minPrice.length < 1 || !$.fn.slider) {
					return false;
				}

				var $slider = $('.price_slider');
				if ($slider.slider('instance') !== undefined) {
					return;
				}

				// Get markup ready for slider
				$('input#min_price, input#max_price').hide();
				$('.price_slider, .price_label').show();

				// Price slider uses jquery ui
				var min_price         = $minPrice.data('min'),
				    max_price         = $('.price_slider_amount #max_price').data('max'),
				    current_min_price = parseInt(min_price, 10),
				    current_max_price = parseInt(max_price, 10);

				if ($products.attr('data-min_price') && $products.attr('data-min_price').length > 0) {
					current_min_price = parseInt($products.attr('data-min_price'), 10);
				}
				if ($products.attr('data-max_price') && $products.attr('data-max_price').length > 0) {
					current_max_price = parseInt($products.attr('data-max_price'), 10);
				}

				$slider.slider({
					range  : true,
					animate: true,
					min    : min_price,
					max    : max_price,
					values : [
						current_min_price,
						current_max_price
					],
					create : function() {
						$('.price_slider_amount #min_price').val(current_min_price);
						$('.price_slider_amount #max_price').val(current_max_price);

						baselThemeModule.$body.trigger('price_slider_create', [
							current_min_price,
							current_max_price
						]);
					},
					slide  : function(event, ui) {
						$('input#min_price').val(ui.values[0]);
						$('input#max_price').val(ui.values[1]);

						baselThemeModule.$body.trigger('price_slider_slide', [
							ui.values[0],
							ui.values[1]
						]);
					},
					change : function(event, ui) {
						baselThemeModule.$body.trigger('price_slider_change', [
							ui.values[0],
							ui.values[1]
						]);
					}
				});

				setTimeout(function() {
					baselThemeModule.$body.trigger('price_slider_create', [
						current_min_price,
						current_max_price
					]);
					if ($slider.find('.ui-slider-range').length > 1) {
						$slider.find('.ui-slider-range').first().remove();
					}
				}, 10);
			},

			filtersArea: function() {
				var filters = $('.filters-area'),
				    time    = 200;

				baselThemeModule.$body.on('click', '.open-filters', function(e) {
					e.preventDefault();

					if (isOpened()) {
						closeFilters();
					} else {
						baselThemeModule.openFilters();
						setTimeout(function() {
							baselThemeModule.shopLoader();
						}, time);
					}
				});

				if (basel_settings.shop_filters_close === 'no') {
					baselThemeModule.$body.on('click', baselTheme.ajaxLinks, function() {
						if (isOpened()) {
							closeFilters();
						}
					});
				}

				var isOpened = function() {
					filters = $('.filters-area');
					return filters.hasClass('filters-opened');
				};

				var closeFilters = function() {
					filters = $('.filters-area');
					filters.removeClass('filters-opened');
					filters.stop().slideUp(time);
					$('.open-filters').removeClass('btn-opened');
				};
			},

			openFilters: function(time) {
				var filters = $('.filters-area');
				filters.addClass('filters-opened');
				filters.stop().slideDown(time);
				$('.open-filters').addClass('btn-opened');
				setTimeout(function() {
					filters.addClass('filters-opened');
					baselThemeModule.$body.removeClass('body-filters-opened');
					baselThemeModule.$document.trigger('basel-images-loaded');
				}, time);
			},

			ajaxSearch: function() {
				var escapeRegExChars = function(value) {
					return value.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&');
				};

				$('form.basel-ajax-search').each(function() {
					var $this         = $(this),
					    number        = parseInt($this.data('count')),
					    thumbnail     = parseInt($this.data('thumbnail')),
					    symbols_count = parseInt($this.data('symbols_count')),
					    productCat    = $this.find('[name="product_cat"]'),
					    $results      = $this.parent().find('.basel-search-results'),
					    price         = parseInt($this.data('price')),
					    url           = basel_settings.ajaxurl + '?action=basel_ajax_search',
					    postType      = $this.data('post_type'),
					    sku           = $this.data('sku');

					if (number > 0) {
						url += '&number=' + number;
					}

					url += '&post_type=' + postType;

					$results.on('click', '.view-all-result', function() {
						$this.submit();
					});

					if (productCat.length && productCat.val() !== '') {
						url += '&product_cat=' + productCat.val();
					}

					$this.find('[type="text"]').on('focus keyup', function() {
						var $input = $(this);

						if ($input.hasClass('basel-search-inited')) {
							return;
						}

						$input.devbridgeAutocomplete({
							serviceUrl      : url,
							appendTo        : $results,
							minChars        : symbols_count,
							deferRequestBy  : basel_settings.ajax_search_delay,
							onSelect        : function(suggestion) {
								if (suggestion.permalink.length > 0) {
									window.location.href = suggestion.permalink;
								}
							},
							onSearchStart   : function() {
								$this.addClass('search-loading');
							},
							beforeRender    : function(container) {
								$(container).find('.suggestion-divider-text').parent().addClass('suggestion-divider');
								if (container[0].childElementCount > 2) {
									$(container).append('<div class="view-all-result"><span>' + basel_settings.all_results + '</span></div>');
								}

							},
							onSearchComplete: function() {
								$this.removeClass('search-loading');

								baselThemeModule.$document.trigger('basel-images-loaded');
							},
							formatResult    : function(suggestion, currentValue) {
								if (currentValue === '&') {
									currentValue = '&#038;';
								}
								var pattern     = '(' + escapeRegExChars(currentValue) + ')',
								    returnValue = '';

								if (suggestion.divider) {
									returnValue += ' <h5 class="suggestion-divider-text">' + suggestion.divider + '</h5>';
								}

								if (thumbnail && suggestion.thumbnail) {
									returnValue += ' <div class="suggestion-thumb">' + suggestion.thumbnail + '</div>';
								}

								if (suggestion.value) {
									returnValue += '<h4 class="suggestion-title result-title">' + suggestion.value
										.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>')
										.replace(/&lt;(\/?strong)&gt;/g, '<$1>') + '</h4>';
								}

								if (sku && suggestion.sku) {
									returnValue += ' <div class="suggestion-sku">' + suggestion.sku + '</div>';
								}

								if (price && suggestion.price) {
									returnValue += ' <div class="suggestion-price price">' + suggestion.price + '</div>';
								}

								return returnValue;
							}
						});

						if (productCat.length) {
							var searchForm = $this.find('[type="text"]').devbridgeAutocomplete(),
							    serviceUrl = basel_settings.ajaxurl + '?action=basel_ajax_search';

							if (number > 0) {
								serviceUrl += '&number=' + number;
							}
							serviceUrl += '&post_type=' + postType;

							productCat.on('cat_selected', function() {
								if (productCat.val()) {
									searchForm.setOptions({
										serviceUrl: serviceUrl + '&product_cat=' + productCat.val()
									});
								} else {
									searchForm.setOptions({
										serviceUrl: serviceUrl
									});
								}

								searchForm.hide();
								searchForm.onValueChange();
							});
						}

						$input.addClass('basel-search-inited');
					});

					baselThemeModule.$document.on('click', function(e) {
						var target = e.target;

						if (!$(target).is('.search-extended') && !$(target).parents().is('.search-extended')) {
							$this.find('[type="text"]').devbridgeAutocomplete('hide');
						}
					});

					$('.basel-search-results').on('click', function(e) {
						e.stopPropagation();
					});
				});
			},

			searchFullScreen: function() {
				var body          = baselThemeModule.$body,
				    searchWrapper = $('.basel-search-wrapper');

				body.on('click', '.search-button > a', function(e) {
					e.preventDefault();

					if (!searchWrapper.find('.searchform').hasClass('basel-ajax-search') && $('.search-button').hasClass('basel-search-dropdown') || baselThemeModule.windowWidth < 1024) {
						return;
					}

					if ($('.sticky-header.act-scroll').length > 0) {
						searchWrapper = $('.sticky-header .basel-search-wrapper');
					} else {
						searchWrapper = $('.main-header .basel-search-wrapper');
					}
					if (isOpened()) {
						closeWidget();
					} else {
						setTimeout(function() {
							openWidget();
						}, 10);
					}
				});

				body.on('click', '.basel-close-search, .main-header, .sticky-header, .topbar-wrapp, .main-page-wrapper, .header-banner', function(event) {
					if (!$(event.target).is('.basel-close-search') && $(event.target).closest('.basel-search-wrapper').length) {
						return;
					}

					if (isOpened()) {
						closeWidget();
					}
				});

				var closeWidget = function() {
					baselThemeModule.$body.removeClass('basel-search-opened');
					searchWrapper.removeClass('search-overlap');
				};

				var openWidget = function() {
					var $bar = $('#wpadminbar');
					var $mainHeader = $('.main-header');
					var $topBar = $('.topbar-wrapp');
					var $spacing = $('.header-spacing');
					var $stickyHeader = $('.sticky-header');
					var bar = $bar.length > 0 ? $bar.outerHeight() : 0;
					var banner = $('.header-banner').outerHeight();
					var offset = $mainHeader.outerHeight() + bar;

					if (!$mainHeader.hasClass('act-scroll')) {
						offset += $topBar.length > 0 ? $topBar.outerHeight() : 0;
						if (baselThemeModule.$body.hasClass('header-banner-display')) {
							offset += banner;
						}
					}

					if ($stickyHeader.hasClass('header-clone') && $stickyHeader.hasClass('act-scroll')) {
						offset = $stickyHeader.outerHeight() + bar;
					}

					if ($mainHeader.hasClass('header-menu-top') && $spacing) {
						offset = $spacing.outerHeight() + bar;
						if (baselThemeModule.$body.hasClass('header-banner-display')) {
							offset += banner;
						}
					}

					if ($('.header-menu-top').hasClass('act-scroll')) {
						offset = $('.header-menu-top.act-scroll .navigation-wrap').outerHeight() + bar;
					}

					searchWrapper.css('top', offset);

					baselThemeModule.$body.addClass('basel-search-opened');
					searchWrapper.addClass('search-overlap');
					setTimeout(function() {
						searchWrapper.find('input[type="text"]').focus();
						baselThemeModule.$window.one('scroll', function() {
							if (isOpened()) {
								closeWidget();
							}
						});
					}, 300);
				};

				var isOpened = function() {
					return baselThemeModule.$body.hasClass('basel-search-opened');
				};
			},

			loginTabs: function() {
				var tabs               = $('.basel-register-tabs'),
				    btn                = tabs.find('.basel-switch-to-register'),
				    title              = $('.col-register-text h2'),
				    loginText          = tabs.find('.login-info'),
				    classOpened        = 'active-register',
				    loginLabel         = btn.data('login'),
				    registerLabel      = btn.data('register'),
				    loginTitleLabel    = btn.data('login-title'),
				    registerTitleLabel = btn.data('reg-title');

				btn.on('click', function(e) {
					e.preventDefault();

					if (isShown()) {
						hideRegister();
					} else {
						showRegister();
					}

					if (baselThemeModule.windowWidth < 768) {
						$('html, body').stop().animate({
							scrollTop: tabs.offset().top - 50
						}, 400);
					}
				});

				var showRegister = function() {
					tabs.addClass(classOpened);
					btn.text(loginLabel);
					if (loginText.length > 0) {
						title.text(loginTitleLabel);
					}
				};

				var hideRegister = function() {
					tabs.removeClass(classOpened);
					btn.text(registerLabel);
					if (loginText.length > 0) {
						title.text(registerTitleLabel);
					}
				};

				var isShown = function() {
					return tabs.hasClass(classOpened);
				};
			},

			productAccordion: function() {
				var $accordion = $('.tabs-layout-accordion');
				var time = 300;
				var hash = window.location.hash;
				var url = window.location.href;

				if (hash.toLowerCase().indexOf('comment-') >= 0 || hash === '#reviews' || hash === '#tab-reviews') {
					$accordion.find('.tab-title-reviews').addClass('active');
				} else if (url.indexOf('comment-page-') > 0 || url.indexOf('cpage=') > 0) {
					$accordion.find('.tab-title-reviews').addClass('active');
				} else {
					$accordion.find('.basel-accordion-title').first().addClass('active');
				}

				$('.woocommerce-review-link').on('click', function() {
					$('.basel-accordion-title.tab-title-reviews').click();
				});

				$accordion.on('click', '.basel-accordion-title', function(e) {
					e.preventDefault();

					var $this  = $(this),
					    $panel = $this.siblings('.woocommerce-Tabs-panel');

					if ($this.hasClass('active')) {
						$this.removeClass('active');
						$panel.stop().slideUp(time);
					} else {
						$accordion.find('.basel-accordion-title').removeClass('active');
						$accordion.find('.woocommerce-Tabs-panel').slideUp();
						$this.addClass('active');
						$panel.stop().slideDown(time);
					}

					baselThemeModule.$window.trigger('resize');

					setTimeout(function() {
						baselThemeModule.$window.trigger('resize');
					}, time);

					baselThemeModule.$document.trigger('basel-images-loaded');
				});
			},

			countDownTimer: function() {
				$('.basel-timer').each(function() {
					var $this = $(this);
					var timeZone = $this.data('timezone');
					dayjs.extend(window.dayjs_plugin_utc);
					dayjs.extend(window.dayjs_plugin_timezone);
					var time = dayjs.tz($this.data('end-date'), timeZone);
					$this.countdown(time.toDate(), function(event) {
						$this.html(event.strftime(''
							+ '<span class="countdown-days">%-D <span>' + basel_settings.countdown_days + '</span></span> '
							+ '<span class="countdown-hours">%H <span>' + basel_settings.countdown_hours + '</span></span> '
							+ '<span class="countdown-min">%M <span>' + basel_settings.countdown_mins + '</span></span> '
							+ '<span class="countdown-sec">%S <span>' + basel_settings.countdown_sec + '</span></span>'));
					});
				});
			},

			mobileFastclick: function() {
				if ('addEventListener' in document) {
					document.addEventListener('DOMContentLoaded', function() {
						FastClick.attach(document.body);
					}, false);
				}
			},

			woocommerceComments: function() {
				var hash = window.location.hash;
				var url = window.location.href;

				if (hash.toLowerCase().indexOf('comment-') >= 0 || hash === '#reviews' || hash === '#tab-reviews' || url.indexOf('comment-page-') > 0 || url.indexOf('cpage=') > 0 || hash === '#tab-basel_additional_tab' || hash === '#tab-basel_custom_tab') {

					setTimeout(function() {
						window.scrollTo(0, 0);
					}, 1);

					setTimeout(function() {
						if ($(hash).length > 0) {
							$('html, body').stop().animate({
								scrollTop: $(hash).offset().top - 100
							}, 400);
						}
					}, 10);
				}
			},

			woocommerceQuantity: function() {
				if (!String.prototype.getDecimals) {
					String.prototype.getDecimals = function() {
						var num   = this,
						    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
						if (!match) {
							return 0;
						}
						return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
					};
				}

				baselThemeModule.$document.on('click', '.plus, .minus', function() {
					// Get values
					var $this = $(this);
					var $qty       = $this.closest('.quantity').find('.qty'),
					    currentVal = parseFloat($qty.val()),
					    max        = parseFloat($qty.attr('max')),
					    min        = parseFloat($qty.attr('min')),
					    step       = $qty.attr('step');

					// Format values
					if (!currentVal || currentVal === '' || currentVal === 'NaN') {
						currentVal = 0;
					}
					if (max === '' || max === 'NaN') {
						max = '';
					}
					if (min === '' || min === 'NaN') {
						min = 0;
					}
					if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') {
						step = '1';
					}

					// Change the value
					if ($this.is('.plus')) {
						if (max && (currentVal >= max)) {
							$qty.val(max);
						} else {
							$qty.val((currentVal + parseFloat(step)).toFixed(step.getDecimals()));
						}
					} else {
						if (min && (currentVal <= min)) {
							$qty.val(min);
						} else if (currentVal > 0) {
							$qty.val((currentVal - parseFloat(step)).toFixed(step.getDecimals()));
						}
					}

					$qty.trigger('change');
				});
			}
		};
	}());
})(jQuery);

jQuery(document).ready(function() {
	baselThemeModule.init();
});

window.onpopstate = function() {
	baselThemeModule.sortByWidget();
}

jQuery(window).on('baselEventStarted', function() {
	baselThemeModule.fixedHeaders();
	baselThemeModule.menuSetUp();
	baselThemeModule.btnsToolTips();
	baselThemeModule.shopLoader();
	baselThemeModule.productLoaderPosition();
	baselThemeModule.menuOffsets();
	baselThemeModule.ajaxSearch();
	baselThemeModule.productsLoadMore();
});

window.onload = function() {
	var events = [
		'keydown',
		'scroll',
		'mouseover',
		'touchmove',
		'touchstart',
		'mousedown',
		'mousemove'
	];

	var triggerListener = function(e) {
		jQuery(window).trigger('baselEventStarted');
		removeListener();
	};

	var removeListener = function() {
		events.forEach(function(eventName) {
			window.removeEventListener(eventName, triggerListener);
		});
	};

	var addListener = function(eventName) {
		window.addEventListener(eventName, triggerListener);
	};

	events.forEach(function(eventName) {
		addListener(eventName);
	});
};