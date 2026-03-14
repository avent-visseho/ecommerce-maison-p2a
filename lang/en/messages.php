<?php

return [
    // ─── Authentication ──────────────────────────────────────────────
    'auth' => [
        'email_already_registered' => 'An account already exists with this email address.',
        'sign_in_instead' => 'Sign in with this email →',
        'config_error' => 'An internal configuration error occurred. Please contact the administrator.',
    ],

    // ─── Client Profile ──────────────────────────────────────────────
    'profile' => [
        'updated' => 'Your profile has been updated successfully.',
        'password_updated' => 'Your password has been updated successfully.',
        'current_password_incorrect' => 'The current password you entered is incorrect. Please try again.',
        'email_already_used' => 'This email address is already in use by another account.',
    ],

    // ─── Cart ────────────────────────────────────────────────────────
    'cart' => [
        'product_added' => 'The product has been added to your cart.',
        'product_removed' => 'The product has been removed from your cart.',
        'updated' => 'The quantity in your cart has been updated.',
        'cleared' => 'Your cart has been cleared successfully.',
        'empty' => 'Your cart is currently empty.',
        'out_of_stock' => 'This product is currently out of stock.',
        'variant_out_of_stock' => 'The selected variant is currently out of stock.',
        'insufficient_stock' => 'Insufficient stock for this product. Only :available in stock.',
        'variant_insufficient_stock' => 'Insufficient stock for this variant. Only :available in stock.',
        'invalid_variant' => 'The selected variant is not valid for this product.',
        'rental_added' => 'The rental item has been added to your cart.',
        'rental_min_days' => 'The minimum rental duration for this item is :days day(s).',
        'rental_max_days' => 'The maximum rental duration for this item is :days day(s).',
        'rental_insufficient_stock' => 'Requested quantity is unavailable. Only :available item(s) available.',
        'rental_error' => 'An error occurred while adding the item to your cart. Please try again.',
    ],

    // ─── Checkout ────────────────────────────────────────────────────
    'checkout' => [
        'cart_empty' => 'Your cart is empty. You cannot place an order without products.',
        'rental_not_found' => 'The rental item ":name" was not found. It may have been removed from the catalog.',
        'rental_unavailable' => 'The item ":name" is no longer available for the selected dates. Please choose different dates.',
        'product_not_found' => 'The product ":name" was not found. It may have been removed from the catalog.',
        'insufficient_stock' => 'Insufficient stock for ":name". Please reduce the quantity in your cart.',
        'error' => 'An unexpected error occurred while processing your order. Please try again or contact our team.',
    ],

    // ─── Contact ─────────────────────────────────────────────────────
    'contact' => [
        'sent' => 'Your message has been sent successfully. Our team will get back to you as soon as possible.',
    ],

    // ─── Newsletter ──────────────────────────────────────────────────
    'newsletter' => [
        'subscribed' => 'Thank you for subscribing! Please check your inbox to confirm your subscription.',
        'already_subscribed' => 'This email address is already subscribed to our newsletter. Check your inbox if you haven\'t received the confirmation email.',
        'verified' => 'Your newsletter subscription has been confirmed successfully!',
        'already_verified' => 'Your email has already been verified. You are subscribed to our newsletter.',
        'unsubscribed' => 'You have been successfully unsubscribed from our newsletter.',
    ],

    // ─── Comments ────────────────────────────────────────────────────
    'comment' => [
        'submitted' => 'Your comment has been received. It will be displayed after moderation by our team.',
        'disabled' => 'Comments are disabled for this article.',
        'invalid_parent' => 'The parent comment does not belong to this article.',
        'no_nested_reply' => 'You cannot reply directly to a reply. Please reply to the main comment.',
    ],

    // ─── Payment ─────────────────────────────────────────────────────
    'payment' => [
        'already_paid' => 'This order has already been paid.',
        'init_error' => 'An error occurred while initiating the payment. Please check your information and try again.',
    ],

    // ─── Rental (public) ─────────────────────────────────────────────
    'rental' => [
        'insufficient_quantity' => 'Sorry, only :available unit(s) available for these dates.',
    ],

    // ─── Administration ──────────────────────────────────────────────
    'admin' => [
        'product' => [
            'created' => 'Product created successfully.',
            'updated' => 'Product updated successfully.',
            'deleted' => 'Product deleted successfully.',
        ],
        'variant' => [
            'created' => 'Variant created successfully.',
            'created_many' => ':count variants created successfully.',
            'updated' => 'Variant updated successfully.',
            'deleted' => 'Variant deleted successfully.',
        ],
        'category' => [
            'created' => 'Category created successfully.',
            'updated' => 'Category updated successfully.',
            'deleted' => 'Category deleted successfully.',
        ],
        'brand' => [
            'created' => 'Brand created successfully.',
            'updated' => 'Brand updated successfully.',
            'deleted' => 'Brand deleted successfully.',
        ],
        'attribute' => [
            'created' => 'Attribute created successfully.',
            'updated' => 'Attribute updated successfully.',
            'deleted' => 'Attribute deleted successfully.',
        ],
        'attribute_value' => [
            'created' => 'Value added successfully.',
            'updated' => 'Value updated successfully.',
            'deleted' => 'Value deleted successfully.',
        ],
        'order' => [
            'status_updated' => 'Order status updated successfully.',
            'payment_status_updated' => 'Payment status updated successfully.',
        ],
        'blog_post' => [
            'created' => 'Article created successfully.',
            'updated' => 'Article updated successfully.',
            'deleted' => 'Article deleted successfully.',
        ],
        'blog_category' => [
            'created' => 'Blog category created successfully.',
            'updated' => 'Blog category updated successfully.',
            'deleted' => 'Blog category deleted successfully.',
        ],
        'blog_comment' => [
            'approved' => 'Comment approved successfully.',
            'rejected' => 'Comment marked as spam.',
            'deleted' => 'Comment deleted successfully.',
        ],
        'rental_item' => [
            'created' => 'Rental item created successfully.',
            'updated' => 'Rental item updated successfully.',
            'deleted' => 'Rental item deleted successfully.',
        ],
        'rental_category' => [
            'created' => 'Rental category created successfully.',
            'updated' => 'Rental category updated successfully.',
            'deleted' => 'Rental category deleted successfully.',
        ],
        'rental_reservation' => [
            'status_updated' => 'Reservation status updated successfully.',
        ],
    ],
];
