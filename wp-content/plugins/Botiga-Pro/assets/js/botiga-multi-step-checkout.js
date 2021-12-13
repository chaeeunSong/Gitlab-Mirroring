(function($){

    'use strict';

    botiga.mstepc = {

        // Defaults
        // The purpose is the ability to change the fields with custom javascript
        customerDetailsFields: [
            {
                title: botiga_mstepc.i18n.customer_details_phone,
                field_id: 'billing_phone'
            },
            {
                title: botiga_mstepc.i18n.customer_details_email,
                field_id: 'billing_email'
            }
        ],
        billingDetailsFields: [
            {
                title: botiga_mstepc.i18n.billing_details_name,
                field_id: 'billing_first_name'
            },
            {
                title: botiga_mstepc.i18n.billing_details_last_name,
                field_id: 'billing_last_name'
            },
            {
                title: botiga_mstepc.i18n.billing_details_company,
                field_id: 'billing_company'
            },
            {
                title: botiga_mstepc.i18n.billing_details_address_1,
                field_id: 'billing_address_1'
            },
            {
                title: botiga_mstepc.i18n.billing_details_address_2,
                field_id: 'billing_address_2'
            },
            {
                title: botiga_mstepc.i18n.billing_details_city,
                field_id: 'billing_city'
            },
            {
                title: botiga_mstepc.i18n.billing_details_state,
                field_id: 'billing_state'
            },
            {
                title: botiga_mstepc.i18n.billing_details_postcode,
                field_id: 'billing_postcode'
            },
            {
                title: botiga_mstepc.i18n.billing_details_country,
                field_id: 'billing_country'
            }
        ],
        shippingDetailsFields: [
            {
                title: botiga_mstepc.i18n.shipping_details_name,
                field_id: 'shipping_first_name'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_last_name,
                field_id: 'shipping_last_name'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_company,
                field_id: 'shipping_company'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_address_1,
                field_id: 'shipping_address_1'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_address_2,
                field_id: 'shipping_address_2'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_city,
                field_id: 'shipping_city'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_state,
                field_id: 'shipping_state'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_postcode,
                field_id: 'shipping_postcode'
            },
            {
                title: botiga_mstepc.i18n.shipping_details_country,
                field_id: 'shipping_country'
            }
        ],

        init: function() {
            var _self = this;

            this.initialized = false;

            // Initialize after 1 second
            setTimeout(function(){
                $('.botiga-mstepc-tabs-nav-item:first-child > a').trigger( 'click' );
                
                // Add required attr in the woocommerce inputs to make it work with jquery validate
                $( 'form.checkout .required, form.woocommerce-form-login .required' ).each(function(){
                    $( this ).closest( '.form-row' ).find( 'input' ).attr( 'required', true );
                    $( this ).closest( '.form-row' ).find( 'select' ).attr( 'required', true );
                });

                _self.initialized = true;
            }, 1000);
            
            // Register events
            this.events();

            return this;
        },

        events: function() {
            var _self = this;

            // Add required attr in the payment inputs to make it work with jquery validate
            $( document ).on( 'updated_checkout', function() {
                $( '.woocommerce-checkout-payment input' ).each(function(){
                    $( this ).attr( 'required', true );
                });
            });

            // Handle some elements when submit checkout has an error
            $( document ).on( 'checkout_error', function() {
                $( '.botiga-mstepc-place-order' ).removeClass( 'loading disabled' );
            });
            
            // Tabs Navigation
            $( '.botiga-mstepc-tabs-nav-item > a' ).on( 'click', function(e){
                e.preventDefault();

                var current_step   = $( this ).data( 'step' ), 
                    selectors_to_validate = $( this ).data( 'validate-selector' ).split( ',' ),
                    selectors_to_show = $( this ).data( 'content-selector' ).split( ',' ),
                    tabs           = $( '.botiga-mstepc-tabs-nav-item' ),
                    current_tab    = $( this ).parent(),
                    prev_tab       = $( this ).parent().prev(),
                    prev_step      = prev_tab.find( '> a' ).data( 'step' ),
                    next_tab       = $( this ).parent().next(),
                    next_step      = next_tab.find( '> a' ).data( 'step' );

                // Scroll and focus invalid fields
                setTimeout(function(){
                    $( 'form.woocommerce-checkout .woocommerce-input-wrapper .error:not(label), .woocommerce-form__input-checkbox[required].error' ).each(function(){
                        $( 'html' ).animate({
                            scrollTop: $( this ).offset().top - 200
                        }, 100);
                        
                        $( this ).focus();
                        return false;
                    });
                }, 500);
                    
                // Check if fields are valid before changing to next step
                var is_valid = _self.validateBeforeNext( selectors_to_validate );

                // Skip validation, except when the "login" step isn't rendered
                if( ! is_valid && ! prev_tab.hasClass( 'no-validation' ) ) {
                    if( $( '.botiga-mstepc-tabs-nav-item > a[data-step="billiing-shipping"]' ).parent().index === 0 ) {
                        return false;
                    }
                } else {
                    $( this ).parent().prev().addClass( 'completed' );
                }

                // Check if step is completed
                if( ! $( this ).parent().prev().hasClass( 'completed' ) && $( this ).parent().index() !== 0 ) {
                    return false;
                }

                // Show next step
                _self.showNextStep( selectors_to_show );

                // Define current, previous and next classes in the tab navigation
                tabs.removeClass( 'previous-step current-step next-step' );
                current_tab.addClass( 'current-step' );
                prev_tab.addClass( 'previous-step' );
                next_tab.addClass( 'next-step' );

                // Toggle current step in the multi step checkout wrapper
                $( '.botiga-mstepc-wrapper' ).removeClass( 'login billing-shipping order-payment order-review' ).addClass( current_step );

                // Remove woocommerce messages on each tab change
                if( _self.initialized === true ) {
                    $( '.botiga-mstepc-wrapper .woocommerce-error' ).remove();
                    $( '.botiga-mstepc-wrapper .woocommerce-message' ).remove();
                }

                // Mount "Order Review" tab content
                $( '.botiga-mstep-order-review .botiga-mstep-order-review__table' ).html( '' );

                if( current_step === 'order-review' ) {
                    var $review_step    = $( '.botiga-mstep-order-review' ),
                        order_table     = $( '.woocommerce-checkout-review-order-table' ).clone();

                    // Remove coupon "remove" link
                    if( order_table.find( '.woocommerce-remove-coupon' ).length ) {
                        order_table.find( '.woocommerce-remove-coupon' ).remove();
                    }
                    
                    // Display shipping method
                    order_table.find( '.woocommerce-shipping-methods .shipping_method' ).each(function(){
                        if( $( this ).is( ':checked' ) ) {
                            $( this ).remove();
                        } else {
                            $( this ).parent().remove();
                        }
                    });

                    // Order table
                    $review_step.find( '.botiga-mstep-order-review__table' ).html( order_table[0].outerHTML );

                    // Customer Details
                    var output = '<ul class="botiga-mstep-order-review__customer-details-list">';
                    _self.customerDetailsFields.forEach(function( obj ){
                        var field_value = $( '#' + obj.field_id ).val();

                        if( field_value ) {
                            output += '<li>'+ obj.title +': '+ field_value +'</li>';
                        }
                    });
                    output += '</div>';

                    $review_step
                        .find( '.botiga-mstep-order-review__customer-details' )
                        .html( output );

                    // Billing Address Details
                    var output = '<ul class="botiga-mstep-order-review__address-billing-details-list">';
                    _self.billingDetailsFields.forEach(function( obj ){
                        var field_value = $( '#' + obj.field_id ).val();

                        if( field_value ) {
                            output += '<li>'+ obj.title +': '+ field_value +'</li>';
                        }
                    });
                    output += '</div>';

                    $review_step
                        .find( '.botiga-mstep-order-review__address-billing' )
                        .html( output );

                    // Shipping Address Details
                    if( $( '#ship-to-different-address-checkbox' ).is( ':checked' ) ) {
                        $( '.botiga-mstep-order-review__address-shipping-title' ).css( 'display', 'block' );

                        var output = '<ul class="botiga-mstep-order-review__address-shipping-details-list">';
                        _self.shippingDetailsFields.forEach(function( obj ){
                            var field_value = $( '#' + obj.field_id ).val();
    
                            if( field_value ) {
                                output += '<li>'+ obj.title +': '+ field_value +'</li>';
                            }
                        });
                        output += '</div>';
    
                        $review_step
                            .find( '.botiga-mstep-order-review__address-shipping' )
                            .html( output );
                    } else {
                        $( '.botiga-mstep-order-review__address-shipping-title' ).css( 'display', 'none' );

                        if( $( '.botiga-mstep-order-review__address-shipping-details-list' ).length ) {
                            $( '.botiga-mstep-order-review__address-shipping-details-list' ).remove();
                        }
                    }
                }

                // Define next step in the "Next" button
                $( '.botiga-mstepc-next' ).data( 'to', next_step );

                // Define previous step in the "Prev" button
                $( '.botiga-mstepc-prev' ).data( 'to', prev_step );
            } );

            // Skip Login Button
            $( '.botiga-mstepc-skip-login' ).on( 'click', function(e){
                e.preventDefault();
                $( '.botiga-mstepc-next' ).trigger( 'click' );
            } );

            // Next Step Button
            $( '.botiga-mstepc-next' ).on( 'click', function(e){
                e.preventDefault();

                var to = $( this ).data( 'to' );

                $( 'html' ).animate({
                    scrollTop: 0
                }, 300, function(){
                    setTimeout(function(){
                        $( '.botiga-mstepc-tabs-nav-item > a[data-step="'+ to +'"]' ).trigger( 'click' );
                        $( window ).trigger( 'botiga.mstepc.next' );
                    }, 600);
                });
            } );

            // Previous Step Button
            $( '.botiga-mstepc-prev' ).on( 'click', function(e){
                e.preventDefault();

                var to = $( this ).data( 'to' );

                $( 'html' ).animate({
                    scrollTop: 0
                }, 300, function(){
                    setTimeout(function(){
                        $( '.botiga-mstepc-tabs-nav-item > a[data-step="'+ to +'"]' ).trigger( 'click' );
                        $( window ).trigger( 'botiga.mstepc.prev' );
                    }, 600);
                });
            } );

            // Place Order Button
            $( '.botiga-mstepc-place-order' ).on( 'click', function(e){
                e.preventDefault();
                $( '#place_order' ).trigger( 'click' );
                $( this ).addClass( 'loading disabled' );
            } );
            
            return this;
        },

        validateBeforeNext: function( selectors ) {
            var is_valid = false;

            selectors.forEach(function( selector, index ){
                if( $( selector ).is( 'form' ) ) {
                    is_valid = $( selector ).valid();
                }
            });

            return is_valid;
        },

        showNextStep: function( selectors ) {
            $( '.woocommerce-form-coupon-toggle,.woocommerce-form-login,form.woocommerce-checkout #customer_details,.checkout-wrapper,.woocommerce-form-coupon' ).removeClass( 'show showEffect' );

            selectors.forEach(function( selector, index ){
                $( selector ).addClass( 'show' );
                setTimeout(function(){
                    $( selector ).addClass( 'showEffect' );
                }, 300);
            });
        }
    }

    $( document ).ready(function(){
        botiga.mstepc.init();
    });

})(jQuery);