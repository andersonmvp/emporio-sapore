;( function( $ ) {
		
	'use strict';
	
	var WOOFC_ADMIN = {};

	WOOFC_ADMIN.notices = {
		
		init: function() {
			
			setTimeout(function() {
			
				$('.woofc-notice').each(function() {
					$(this).prependTo('#wpbody-content');
				});
				
			},10)
		}
	};
	

	// LICENSE FUNCTIONS ----------------------------------------------------------
	
	WOOFC_ADMIN.license = {
		
		init: function() {
			
			var self = this;
			var initLicenseFormEvent = function() {
			
				self.initLicenseForm($(this));
			};
			
			$('.woofc-license-activation').each(initLicenseFormEvent);	
		},
	
		initLicenseForm: function(wrapper) {
	
			var product_id = $(wrapper).data('id');	
			var homeurl = $(wrapper).data('homeurl');
			var domain = $(wrapper).data('domain');
			var ajaxurl = $(wrapper).data('ajaxurl');
			var forms = $(wrapper).find('.woofc-license-form');
			var activationForm = $(wrapper).find('#woofc-license-activation-form');
			var revokeForm = $(wrapper).find('#woofc-license-revoke-form');
			var localRevokeForm = $(wrapper).find('#woofc-license-local-revoke-form');
			var licenseActivated = $(wrapper).find('#woofc-license-activated');
			var licenseInvalid = $(wrapper).find('#woofc-license-invalid');
			var licenseInfo = $(wrapper).find('.woofc-license-info');
			var revokeInfo = $(wrapper).find('.woofc-license-revoke-info');
			var invalidTimer = $(wrapper).find('.woofc-license-timer');
			
			forms.each(function() {
				
				var form = $(this);
				
				form.find('input[type="submit"]').on('click', function(e) {
				
					e.preventDefault();
					
					var button = $(this);
					var defaultButtonValue = button.val();
					button.val('Processing...');
					button.attr('disabled', true);

					var action = form.find('input[name="action"]').val();
					
					if(action === 'woofc_license_activation_'+product_id) {
						
						var host = domain !== '' ? domain : location.host.replace('www.', '');
						var installation_url = homeurl;
						form.find('input[name="domain"]').val(host);
						form.find('input[name="installation_url"]').val(installation_url);			
					}					
					
					var postData = form.find(':input').serialize();
					
					$.ajax({
						cache		: false,
			            url         : ajaxurl, 
			            type        : 'POST', 
			            data        : postData,
			            dataType    : 'json', 
		  			})
		            // using the done promise callback
		            .done(function(data) {
						
						licenseResponse(data);
						button.val(defaultButtonValue);
						button.removeAttr('disabled');
		            })
		            .fail(function(data) {
						
						alert('Something went wrong! Please try again later!');
						button.val(defaultButtonValue);
						button.removeAttr('disabled');
		            });	
		        });    
			});
			
			revokeForm.find('.woofc-license-revoke-cancel').on('click', function(e) {
				
				e.preventDefault();
				
				showActivationForm();
			});
			

			function licenseResponse(data) {
				
				if(data.code === "valid") {
					
					onActivation(data);
					
				}else if(data.code === "exists") {
					
					showRevokeForm(data);
					
				}else if(data.code === "revoked") {
					
					onRevoked(data);
					
				}else{
					
					onInvalid(data);
				}
			}
			
			function showRevokeForm(data) {
				
				activationForm.hide();
				licenseActivated.hide();
				revokeInfo.hide();
				licenseInvalid.hide();
				localRevokeForm.hide();
				revokeForm.fadeIn();
				
				revokeForm.find('input[name="purchase_code"]').val(data.license.purchase_code);
				revokeForm.find('input[name="domain"]').val(data.license.domain);

				licenseInfo.html(data.license_summary).fadeIn();
			}
			
			function onRevoked(data) {
				
				showActivationForm();
				licenseInfo.empty().hide();
				revokeInfo.html(data.msg);
				revokeInfo.fadeIn();
				localRevokeForm.hide();
			}
			
			function showActivationForm() {
				
				licenseInfo.empty().hide();
				revokeForm.hide();
				localRevokeForm.hide();
				licenseActivated.hide();
				revokeInfo.hide();
				licenseInvalid.hide();
				activationForm.fadeIn();
			}
			
			function onActivation(data) {
				
				revokeForm.hide();
				activationForm.hide();
				revokeInfo.hide();
				licenseInvalid.hide();
				licenseActivated.fadeIn();
				localRevokeForm.fadeIn();

				licenseInfo.html(data.license_summary).fadeIn();
				
				localRevokeForm.find('[name="purchase_code"]').val(data.license.purchase_code);
				localRevokeForm.find('[name="domain"]').val(data.license.domain);
				
				$( document ).trigger( "woofc-license-activated", [ data.license, data.license_summary, licenseInfo ] );
			}
			
			function onInvalid() {
				
				revokeForm.hide();
				activationForm.hide();
				revokeInfo.hide();
				localRevokeForm.hide();
				licenseActivated.hide();
				licenseInvalid.fadeIn();
				
				var count = 3;
				invalidTimer.html(count);
				count--;
				var timer = setInterval(function() {
					
					if(count === 0) {
						
						invalidTimer.empty();
						clearInterval(timer);
						showActivationForm();
						
					}else{
					
						invalidTimer.html(count);
						count--;
					}
					
				}, 1000);
			}		
		}
	};

	
	$(document).ready(function() {
		
		WOOFC_ADMIN.notices.init();
		WOOFC_ADMIN.license.init();	
	});

})( jQuery );	