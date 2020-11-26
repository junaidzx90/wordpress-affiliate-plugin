(function ($) {
	/**
	 * "WORDPRESS AFFILIATE PLUGIN" all javaScript code is here please don't change any of code without understanding that working process.
	 */
	'use strict';
	$(document).ready(function () {
		$('.js-example-basic-single').select2();
		// links list table searchbox
		$(".link_s").on("keyup", function () {
			var value = $(this).val().toLowerCase();
			$(".link_tbl tr").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		// Shortcode hide in small screen
		if ($('.add_form').css("display") == "block") {
			$('.shortcode').hide();
			$('.product_s').hide();
		}
		// Popup for creating product	
		$('.close_product_btn').click(function () {
			$('.add_form').hide();
			$('.shortcode').show();
			$('.product_s').show();
			$('.p_table').addClass('col-sm-9');
			$('.open_product_form').show();
		});
		
		$('.open_product_form').click(function () {
			$('.open_product_form').hide();
			$('.add_form').show();
			$('.shortcode').hide();
			$('.product_s').hide();
			$('.p_table').removeClass('col-sm-9');
			$('.p_table').addClass('col-sm-6');
		});
		
		// Popup for creating links	
		$('.open_link_form').click(function () {
			$('.add_link_form').show();
			$('.open_link_form').hide();
		});
		$('.close_link_btn').click(function () {
			$('.add_link_form').hide();
			$('.open_link_form').show();
		});
		// Popup for creating provider	
		$('.open_provider_form').click(function () {
			$('.provider_add_form').show();
			$('.open_provider_form').hide();
		});
		$('.close_supplier_btn').click(function () {
			$('.provider_add_form').hide();
			$('.open_provider_form').show();
		});

		// Add products
		$('.add_product_btn').click(function (e) {
			e.preventDefault();
			let product_name = $('.add_products').val();
			if (product_name == "") {
				$('.add_products').css('box-shadow', '1px 1px 1px red');
			} else {
				$('.add_products').css('box-shadow', '1px 1px 1px #4EC6DE');
			}
			if (product_name != "") {
				$.ajax({
					type: "post",
					url: _ajax_url.ajax_url,
					data: {
						action: "add_product",
						product_name: product_name
					},
					dataType: "json",
					success: function (response) {
						if (response.status == false) {
							swal({
								title: response.title,
								text: response.text,
								icon: "warning"
							});
						}
						if (response.status == true) {
							$('.add_products').val('');
							swal({
								title: response.title,
								text: response.text,
								icon: "success"
							});
							products_data();
							select_product_opt();
						}
					}//End success
				});//End ajax
			}//End condition
		});//End add product

		// Add providers
		$('.add_supplier_btn').click(function (e) {
			e.preventDefault();
			let providers_name = $('.providers').val();

			if (providers_name == "") {
				$('.providers').css('box-shadow', '1px 1px 1px red');
			} else {
				$('.providers').css('box-shadow', '1px 1px 1px #4EC6DE');
			}
			if (providers_name != "") {
				$.ajax({
					type: "post",
					url: _ajax_url.ajax_url,
					data: {
						action: "add_providers",
						providers_name: providers_name
					},
					dataType: "json",
					success: function (response) {
						if (response.status == false) {
							swal({
								title: response.title,
								text: response.text,
								icon: "warning"
							})
						}
						if (response.status == true) {
							$('.providers').val('');
							swal({
								title: response.title,
								text: response.text,
								icon: "success"
							});
							suppliers_data();
							select_suppliers_opt();
						}
					}//End success
				});//End ajax
			}//End condition
		});//End add product

		// getting supplier data
		function suppliers_data() {
			$.ajax({
				type: "get",
				url: _ajax_url.ajax_url,
				data: {
					action: "supplier_data"
				},
				dataType: "json",
				success: function (supplier_) {
					if (supplier_.status == false) {
						$('.provider_data').html("");
						$('.provider_data').append('<span class="no_product">' + supplier_.text + '</span>');
					} else {
						$('.provider_data').html("");
						$('.provider_data').append('<label class="_header">Providers</label>' +
							'<table class="table">' +
							'<thead>' +
							'<tr>' +
							'<th>ID</th>' +
							'<th>Providers</th>'+
							'<th>' +
							'<input class="myInputs suppliers_s" type="text" placeholder="Search..">' +
							'</th>' +
							'</tr>' +
							'</thead>' +
							'<tbody class="suppliers_tbl">');
						$.each(supplier_, function (i, val) {
							$('.suppliers_tbl').append('<tr>' +
								'<td scope="row">' + val.supplier_ID + '</td>' +
								'<td>'+val.supplier_name+'</td>' +
								'<td>' +
								'<button data-value="'+val.supplier_ID+'" class="supplier_dlt_btn s-dlt">Delete</button>' +
								'</td>' +
								'</tr>');
						});
						$('.provider_data').append('</tbody></table>');
					}//data showing end
					// suppliers list table searchbox
					$(".suppliers_s").on("keyup", function () {
						var value = $(this).val().toLowerCase();
						$(".suppliers_tbl tr").filter(function () {
							$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
						});
					});
					// If data not adds popup will be visible
					if ($('.provider_data').children('.no_product').length > 0) {
						$('.open_provider_form').hide();
						$('.provider_table').removeClass("col-sm-6");
						$('.provider_table').addClass("col-sm-9");
						$('.provider_add_form').show();
						$('.close_supplier_btn').hide();
					} else {
						$('.open_provider_form').show();
						$('.provider_add_form').hide();
						$('.provider_table').removeClass("col-sm-9");
						$('.provider_table').addClass("col-sm-6");
						$('.close_supplier_btn').show();
					}
					// Delete supplier data
					$(document).on('click', '.s-dlt', function () {
						let data_id = $(this).attr('data-value');
						let delete_for = "supplier";
						swal({
							title: "Are you sure?",
							text: "Once deleted, you will not be able to recover this provider!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
							.then((willDelete) => {
								if (willDelete) {
									$.ajax({
										type: "post",
										url: _ajax_url.ajax_url,
										data: {
											action: "delete_data",
											data_id: data_id,
											delete_for: delete_for
										},
										success: function (response) {
											suppliers_data();
											select_suppliers_opt();
											get_links_data();
											swal("oof! This provider has been deleted!", {
												icon: "success",
											});
											return false;
										}
									});
								} else {
									swal("This provider is safe!");
								}
							});
					});//delete end
				}
			});
		}// End Supplier data getting
		suppliers_data();//supplier data callback

		// Getting product data
		function products_data() {
			$.ajax({
				type: "get",
				url: _ajax_url.ajax_url,
				data: {
					action: "get_product"
				},
				dataType:"json",
				success: function (response) {
					if (response.status == false) {
						$('.show_product').html("");
						$('.show_product').append('<span class="no_product">' + response.text + '</span>');
					} else {
						$('.show_product').html("");
						$('.show_product').append('<label class= "_header" >'+
							'Products</label > '+
							'<table class="table"><thead>' +
							'<tr>'+
							'<th>ID</th>' +
							'<th colspan="2">Products</th>'+
                                   ' <th><input class="myInputs product_s"' +'type="text" placeholder="Search..">'+
                                    '</th>'+
                                '</tr>'+
                           ' </thead>'+
                            '<tbody class="product_tbl">');
						$.each(response, function (index, data) {
								$('.product_tbl').append('<tr>'+
								'<td scope="row">' + data.product_ID + '</td>'+
								'<td>'+
									'<span class="p-name">' + data.product_name + '</span>' +
									'<span class="info_popup"></span>'+
								'</td>'+
								'<td>'+
									'<span class="push_suc">'+
										'<span data-value="'+data.product_ID+'" class="shortcode">'+
											'No links found'+
										'</span>'+
									'</span>'+
								'</td>'+
								'<td>'+
									'<button data-value="'+data.product_ID+'" class="product_dlt_btn p-dlt">Delete</button>'+
								'</td>'+
									'</tr>');
								$('.show_product').append('</tbody></table>');
						});
						
							// Get product information
						$('.p-name').on('click', function (e) {
							$(this).next('.info_popup').html("");
							$('td').siblings().children('.info_popup').hide();
							$(this).next('.info_popup').show();
							
								let product_name = $(this).text();
								$.ajax({
									type: "post",
									url: _ajax_url.ajax_url,
									data: {
										action: "product_details",
										product_name: product_name
									},
									dataType: "json",
									success: function (info) {
										if (info.status == false) {
											$('.info_popup').append('<span class="info_product">No record found</span>').fadeOut(1000);
										} else {
											$('.info_popup').append('<span class="clss">+</span><table class="table"><thead><th>SL/ID</th><th>Providers</th></thead><tbody class="info_tbl">');
											let x = 1;
											$.each(info, function (i, val) {
												$('.info_tbl').append('<tr>' +
													'<td>' + x + '/' + val.supplier_ID + '</td>' +
													'<td>' + val.supplier_name + '</td>' +
													'</tr>');
												x++;
											});
											$('.info_popup').append('</tbody></table>');
											$('.clss').click(function () {//info popup close
												$('.info_popup').hide();
											});
										}
									}
								});
							});
						// ShortCodes check and controll
						$.ajax({
							type: "get",
							url: _ajax_url.ajax_url,
							data: {
								action: "get_affiliate_data_for_product"
							},
							dataType: "json",
							success: function (links) {
								$.each(links, function (i,val) {
									$('.shortcode[data-value="' + val.product_ID + '"]').html('[wpa productid="' + val.product_ID + '"]');
									$('.shortcode[data-value="' + val.product_ID + '"]').addClass('shortCode_event');
								});
								// Shortcode copy with click
								$('.shortCode_event').on('click', function() {
									let $temp = $("<input/>");
									$("body").append($temp);
									$temp.val($(this).text()).select();
									document.execCommand("copy");
									$(this).parent().css('position', 'relative');
									$(this).parent().append('<span class="copy">Copied</span>');
									$('.copy').fadeOut(1000);
									$temp.remove();
								});
							}
						});
					}

					// Delete product data
					$(document).on('click', '.p-dlt', function () {
						let data_id = $(this).attr('data-value');
						let delete_for = "product";
						swal({
							title: "Are you sure?",
							text: "Once deleted, you will not be able to recover this product!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
							.then((willDelete) => {
								if (willDelete) {
									$.ajax({
										type: "post",
										url: _ajax_url.ajax_url,
										data: {
											action: "delete_data",
											data_id: data_id,
											delete_for: delete_for
										},
										success: function (response) {
											products_data();
											select_product_opt();
											get_links_data();
											swal("oof! This product has been deleted!", {
												icon: "success",
											});
											return false;
										}
									});
								} else {
									swal("Your product is safe!");
								}
							});
					});//delete end

					// Display property controll
					if ($('.add_form').css("display") == "block") {
						$('.shortcode').hide();
						$('.product_s').hide();
					}

					// If data not adds popup will be visible
					if ($('.show_product').children('.no_product').length > 0) {
						$('.open_product_form').hide();
						$('.add_form').show();
						$('.close_product_btn').hide();
					} else {
						$('.open_product_form').show();
						$('.p_table').removeClass("col-sm-6");
						$('.p_table').addClass("col-sm-9");
						$('.add_form').hide();
						$('.close_product_btn').show();
						$('.shortcode').show();
						$('.product_s').show();
					}
					// Product search
					$(".product_s").on("keyup", function () {
						var value = $(this).val().toLowerCase();
						$(".product_tbl tr").filter(function () {
							$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
						});
					});
				}//success end
			});//ajax end
		}//end products_data
		products_data();//product data callback

		// Getting product data
		function get_links_data() {
			$.ajax({
				type: "get",
				url: _ajax_url.ajax_url,
				data: {
					action: "get_affiliate_data"
				},
				dataType:"json",
				success: function (response) {
					if (response.status == false) {
						$('.links_data').html("");
						$('.links_data').append('<span class="no_product">' + response.text + '</span>');
					} else {
						$('.links_data').html("");
						$('.links_data').append('<label class="_header">Providers</label>' +
							'<table class="table">' +
							'<thead>' +
							'<tr>' +
							'<th>ID</th>' +
							'<th>Products</th>'+
							'<th colspan="3">Providers' +
							'<input class="myInputs link_s" type="text" placeholder="Search..">' +
							'</th>' +
							'</tr>' +
							'</thead>' +
							'<tbody class="link_tbl">');
						$.each(response, function (index, data) {
							$('.link_tbl').append(
								'<tr>' +
								'<td scope="row">'+data.productLink_ID+'</td>' +
								'<td>'+data.product_name+'</td>' +
								'<td>'+data.supplier_name+'</td>' +
								'<td><input disabled class="url" value="'+data.affiliate_link+'"></td>' +
								'<td>' +
								'<button data-value="'+data.productLink_ID+'"  class="product_dlt_btn link_dlt l-dlt">Delete</button>' +
								'</td>' +
								'</tr>');
						});
						$('.links_data').append('</tbody></table>');
						// Product search
						$(".link_s").on("keyup", function () {
							var value = $(this).val().toLowerCase();
							$(".link_tbl tr").filter(function () {
								$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
							});
						});
					}//end inserting

					// If data not adds popup will be visible
					if ($('.links_data').children('.no_product').length > 0) {
						$('.open_link_form').hide();
						$('.add_link_form').show();
						$('.close_link_btn').hide();
					} else {
						$('.open_link_form').show();
						$('.add_link_form').hide();
						$('.close_link_btn').show();
					}

					// Delete supplier data
					$(document).on('click', '.l-dlt', function () {
						let data_id = $(this).attr('data-value');
						let delete_for = "links";
						swal({
							title: "Are you sure?",
							text: "Once deleted, This shortcode will not work!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
							.then((willDelete) => {
								if (willDelete) {
									$.ajax({
										type: "post",
										url: _ajax_url.ajax_url,
										data: {
											action: "delete_data",
											data_id: data_id,
											delete_for: delete_for
										},
										success: function (response) {
											products_data();
											get_links_data();
											swal("oof! Your shortcode has been deleted!", {
												icon: "success",
											});
											return false;
										}
									});
								} else {
									swal("This provider is safe!");
								}
							});
					});//delete end

				}//end success
			});
		}//End get_links_data
		get_links_data();//link data callback

		// Add affiliate link
		function add_aff_link() {
			$('.add_link_btn').click(function (e) {
				let product_id = $('#product_id').val();
				let provider_id = $('#provider_id').val();
				let price = $('#price').val();
				let links = $('.links').val();

				if (product_id == "") {
					$('#product_id').css('box-shadow', '1px 1px 1px red');
				} else {
					$('#product_id').css('box-shadow', '1px 1px 1px #4EC6DE');
				}
				if (provider_id == "") {
					$('#provider_id').css('box-shadow', '1px 1px 1px red');
				} else {
					$('#provider_id').css('box-shadow', '1px 1px 1px #4EC6DE');
				}
				if (links == "") {
					$('.links').css('box-shadow', '1px 1px 1px red');
				} else {
					$('.links').css('box-shadow', '1px 1px 1px #4EC6DE');
				}

				if (product_id != "" && provider_id != "" && links != "") {
					$.ajax({
						type: "post",
						url: _ajax_url.ajax_url,
						data: {
							action: "add_aff_link",
							product_id: product_id,
							provider_id: provider_id,
							price: price,
							links: links
						},
						dataType: "json",
						success: function (response) {
							if (response.status == false) {
								swal({
									title: response.title,
									text: response.text,
									icon: "warning"
								})
							} else {
								swal({
									title: response.title,
									text: response.text,
									icon: "success"
								})
								get_links_data();//link data callback
								products_data();//product data callback
								select_product_opt();
								select_suppliers_opt();
								$('#price').val("");
								$('.links').val("");
							}
						}
					});
					return false;
				}
			});//click event ending
		}
		add_aff_link();//add link callback

		// GETTING PRODUCT MENU
		function select_product_opt() {
			$.ajax({
				type: "get",
				url: _ajax_url.ajax_url,
				data: { action: "select_product_opt" },
				dataType: "json",
				success: function (data) {
					$('#product_id').html("");
					$('#product_id').append('<option class="defaultVal" value="">None Selected</option>');
					
					$.each(data, function (i, val) {
						$('#product_id').append('<option value="' + val.product_id + '">' + val.product_name + '</option>');
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					alert("Status: " + textStatus); alert("Error: " + errorThrown); 
				}     
			});
		}
		select_product_opt();

		// GETTING SUPPLIER MENU
		function select_suppliers_opt() {
			$.ajax({
				type: "get",
				url: _ajax_url.ajax_url,
				data: { action: "select_supplier" },
				dataType: "json",
				success: function (data) {
					$('#provider_id').html("");
					$('#provider_id').append('<option class="defaultVal" value="">None Selected</option>');
					
					$.each(data, function (i, val) {
						$('#provider_id').append('<option value="' + val.supplier_id + '">' + val.supplier_name + '</option>');
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					alert("Status: " + textStatus); alert("Error: " + errorThrown); 
				}     
			});
		}
		select_suppliers_opt();


		// SUBMENU SEARCH INPUT
		// Product search
		$(".product_stats_s").on("keyup", function () {
			var value = $(this).val().toLowerCase();
			$(".product_stats tr").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		// Productlink search
		$(".productlink_stats_s").on("keyup", function () {
			var value = $(this).val().toLowerCase();
			$(".productlink_stats tr").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		return false;
	});
})(jQuery);