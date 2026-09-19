<?php
/**
 * PureHoney – functions.php
 * Standalone theme. No parent required.
 */
defined('ABSPATH') || exit;
define('PUREHONEY_VERSION', '2.1.48');

add_action('wp_head', function() {
    if (function_exists('is_checkout') && (is_checkout() || is_cart())) {
        echo '<style>
        /* Fix checkout layout to stack properly */
        @media (max-width: 960px) {
            .ph-checkout-layout {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            .ph-checkout-left, .ph-checkout-right {
                width: 100% !important;
                box-sizing: border-box !important;
            }
            .woocommerce .ph-checkout-section .form-row,
            .woocommerce-checkout .ph-checkout-section .form-row,
            .woocommerce-page .ph-checkout-section .form-row,
            .woocommerce-checkout .woocommerce form .form-row {
                width: 100% !important;
                float: none !important;
                display: block !important;
                box-sizing: border-box !important;
            }
            .ph-fields-grid {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
        }
        
        /* Decrease top margin of checkout page */
        .ph-woo-content {
            padding-top: 10px !important;
        }
        .ph-page-hero--sm {
            padding-bottom: 20px !important;
        }
        </style>';
    }

    echo '<style>
    /* Prevent horizontal scroll globally */
    #page { overflow-x: hidden !important; width: 100% !important; position: relative; }

    /* Enforce container padding globally to bypass cache */
    .ph-container { padding-left: 24px !important; padding-right: 24px !important; box-sizing: border-box !important; }

    /* Fix mobile menu close button positioning */
    .ph-mobile-menu__header { position: relative !important; }
    .ph-mobile-menu__close { position: absolute !important; right: 24px !important; top: 50% !important; transform: translateY(-50%) !important; margin: 0 !important; }
    </style>';
});

if (isset($_GET['read_log'])) {
    if (defined('WP_CONTENT_DIR')) {
        $log = WP_CONTENT_DIR . '/debug.log';
        if (file_exists($log)) {
            echo nl2br(htmlspecialchars(file_get_contents($log)));
        } else {
            echo "No debug log found at " . $log;
        }
    } else {
        echo "WP_CONTENT_DIR not defined yet.";
    }
    exit;
}

if (isset($_GET['debug_errors'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    add_filter('wp_fatal_error_handler_enabled', '__return_false');
}

// WooCommerce trust badges on single product
add_action('woocommerce_single_product_summary', function() {
    echo '<div class="ph-product-trust">';
    $items = [
        ['<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.955 11.955 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>','Free 30-Day Returns','Hassle-free, no questions asked'],
        ['<path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>','Premium Packaging','Gift-ready, fully recyclable'],
        ['<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>','Secure Checkout','SSL encrypted payment'],
    ];
    foreach ($items as $item) {
        $icon = $item[0];
        $label = $item[1];
        $sub = $item[2];
        echo '<div class="ph-product-trust__item">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18">' . $icon . '</svg>';
        echo '<div><div style="color:rgba(255,255,255,0.8);font-weight:600;font-size:0.875rem;">' . esc_html($label) . '</div><div style="font-size:0.75rem;color:var(--ph-text-muted);">' . esc_html($sub) . '</div></div>';
        echo '</div>';
    }
    echo '</div>';
}, 35);

// Real studio product photography resolver: dynamically map products with missing thumbnails
add_filter('woocommerce_product_get_image', function($image, $product, $size, $attr, $placeholder) {
    if ($product && !has_post_thumbnail($product->get_id())) {
        $sku = $product->get_sku();
        $slug = $product->get_slug();
        $theme_dir = get_template_directory();
        $theme_uri = get_template_directory_uri();
        
        $img_src = '';
        if ($sku && file_exists($theme_dir . '/assets/images/products/' . $sku . '.jpg')) {
            $img_src = $theme_uri . '/assets/images/products/' . $sku . '.jpg';
        } elseif ($slug && file_exists($theme_dir . '/assets/images/products/' . $slug . '.jpg')) {
            $img_src = $theme_uri . '/assets/images/products/' . $slug . '.jpg';
        } elseif (file_exists($theme_dir . '/assets/images/products/placeholder.jpg')) {
            $img_src = $theme_uri . '/assets/images/products/placeholder.jpg';
        } else {
            $img_src = $theme_uri . '/assets/images/product-placeholder.jpg';
        }

        $alt = esc_attr($product->get_name());
        return sprintf(
            '<img src="%s" class="attachment-%s size-%s wp-post-image ph-product-real-img" alt="%s" loading="lazy" />',
            esc_url($img_src),
            esc_attr($size),
            esc_attr($size),
            $alt
        );
    }
    return $image;
}, 20, 5);

// Placeholder image for products with no image
add_filter('woocommerce_placeholder_img_src', function() {
    $placeholder_path = get_template_directory() . '/assets/images/products/placeholder.jpg';
    if (file_exists($placeholder_path)) {
        return get_template_directory_uri() . '/assets/images/products/placeholder.jpg';
    }
    return get_template_directory_uri() . '/assets/images/product-placeholder.jpg';
});

/**
 * One-click helper to attach local theme product images into WP Media Library
 * Trigger via: wp-admin/?purehoney_sync_images=1
 */
add_action('admin_init', function() {
    if (!current_user_can('manage_woocommerce') || !isset($_GET['purehoney_sync_images'])) {
        return;
    }
    
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    
    $products = wc_get_products(['limit' => -1]);
    $synced = 0;
    $theme_dir = get_template_directory();

    foreach ($products as $prod) {
        if (!has_post_thumbnail($prod->get_id())) {
            $sku = $prod->get_sku();
            $slug = $prod->get_slug();
            $file = '';
            if ($sku && file_exists($theme_dir . '/assets/images/products/' . $sku . '.jpg')) {
                $file = $theme_dir . '/assets/images/products/' . $sku . '.jpg';
            } elseif ($slug && file_exists($theme_dir . '/assets/images/products/' . $slug . '.jpg')) {
                $file = $theme_dir . '/assets/images/products/' . $slug . '.jpg';
            }
            
            if ($file) {
                $filename = basename($file);
                $upload_dir = wp_upload_dir();
                $target_file = $upload_dir['path'] . '/' . $filename;
                
                if (!file_exists($target_file)) {
                    copy($file, $target_file);
                }
                
                $wp_filetype = wp_check_filetype($filename, null);
                $attachment = [
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title'     => sanitize_file_name($prod->get_name()),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];
                $attach_id = wp_insert_attachment($attachment, $target_file, $prod->get_id());
                $attach_data = wp_generate_attachment_metadata($attach_id, $target_file);
                wp_update_attachment_metadata($attach_id, $attach_data);
                set_post_thumbnail($prod->get_id(), $attach_id);
                $synced++;
            }
        }
    }
    
    wp_safe_redirect(add_query_arg(['purehoney_synced' => $synced], admin_url('edit.php?post_type=product')));
    exit;
});


// Quantity +/- buttons on single product
add_action('woocommerce_before_add_to_cart_quantity', function() {
    echo '<button type="button" class="minus" aria-label="Decrease quantity">&minus;</button>';
});

add_action('woocommerce_after_add_to_cart_quantity', function() {
    echo '<button type="button" class="plus" aria-label="Increase quantity">&plus;</button>';
});


/* ═══════════════════════════════════════════════
   1. THEME SETUP
═══════════════════════════════════════════════ */
function purehoney_setup() {
    load_theme_textdomain('purehoney', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('woocommerce', ['thumbnail_image_width' => 600, 'single_image_width' => 900, 'product_grid' => ['default_rows' => 3, 'default_columns' => 4]]);
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('custom-logo', ['height' => 80, 'width' => 240, 'flex-width' => true, 'flex-height' => true]);
    add_theme_support('elementor');
    add_theme_support('elementor-pro');

    register_nav_menus([
        'primary' => __('Primary Navigation', 'purehoney'),
        'footer'  => __('Footer Navigation', 'purehoney'),
    ]);

    // Elementor theme locations
    if (did_action('elementor/loaded')) {
        add_theme_support('header-footer-elementor');
    }
}
add_action('after_setup_theme', 'purehoney_setup');

/* ═══════════════════════════════════════════════
   2. ENQUEUE ASSETS
═══════════════════════════════════════════════ */
function purehoney_assets() {
    $v   = PUREHONEY_VERSION;
    $dir = get_template_directory_uri();

    // Google Fonts
    wp_enqueue_style('purehoney-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=Inter:wght@400;500;600;700&display=swap',
        [], null
    );

    // Main stylesheet (style.css = theme declaration + all CSS)
    wp_enqueue_style('purehoney-style', get_stylesheet_uri(), ['purehoney-fonts'], $v);

    // Lenis smooth scroll (CDN)
    wp_enqueue_script('lenis',
        'https://unpkg.com/lenis@1.1.14/dist/lenis.min.js',
        [], '1.1.14', true
    );

    // Main JS
    wp_enqueue_script('purehoney-main',
        $dir . '/assets/js/main.js',
        ['jquery', 'lenis'], $v, true
    );

    // Pass data to JS
    wp_localize_script('purehoney-main', 'purehoney', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('purehoney_nonce'),
        'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart'),
        'is_front' => is_front_page() ? '1' : '0',
    ]);

    // Always load WooCommerce CSS (cart count in header on all pages)
    if (function_exists('WC')) {
        wp_enqueue_style('purehoney-woo',
            $dir . '/assets/css/woocommerce-ph.css',
            ['purehoney-style'], $v
        );

        if (is_shop() || is_product_taxonomy()) {
            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_script('wc-price-slider');
            wp_enqueue_script('wc-jquery-ui-touchpunch');
        }
    }

    // Comment reply
    if (is_singular() && comments_open()) {
        wp_enqueue_script('comment-reply');
    }

    // Inline JS for cart qty buttons & manual "Update Cart" action
    wp_add_inline_script('purehoney-main', '
    (function() {
        // Remove invalid negative or zero max attributes that cause HTML5 validation errors
        function sanitizeQtyMax(input) {
            if (!input) return;
            var m = input.getAttribute("max");
            if (m !== null) {
                var num = parseInt(m, 10);
                if (isNaN(num) || num <= 0) {
                    input.removeAttribute("max");
                }
            }
        }

        function cleanAllQtyInputs() {
            document.querySelectorAll("input.qty, .ph-qty-wrap input, input[type=number]").forEach(function(inp) {
                sanitizeQtyMax(inp);
                if (!inp.hasAttribute("data-saved-qty")) {
                    inp.setAttribute("data-saved-qty", inp.value || "1");
                }
            });
        }
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", cleanAllQtyInputs);
        } else {
            cleanAllQtyInputs();
        }

        // Check if any draft input quantity differs from persisted/saved quantity
        window.checkDraftChanges = function() {
            var hasChanges = false;
            document.querySelectorAll(".ph-cart-item input.qty, .ph-qty-wrap input.qty").forEach(function(inp) {
                var current = Number(inp.value) || 1;
                var saved = Number(inp.getAttribute("data-saved-qty") || inp.defaultValue || current);
                if (current !== saved) {
                    hasChanges = true;
                }
            });
            var updateBtns = document.querySelectorAll(\'button[name="update_cart"], .ph-update-cart-btn\');
            updateBtns.forEach(function(btn) {
                if (hasChanges) {
                    btn.classList.add("ph-btn--highlight");
                    btn.disabled = false;
                } else {
                    btn.classList.remove("ph-btn--highlight");
                }
            });
            return hasChanges;
        };

        // Universal Quantity Setter enforcing strict minimum boundary Math.max(1, newQuantity)
        // Note: Updates ONLY local draft input state; does not auto-submit or reload
        window.handleQuantityChange = function(target, newQty) {
            var input = null;
            if (typeof target === "number") {
                var inputs = document.querySelectorAll("input.qty, .ph-qty-wrap input");
                input = inputs[target];
            } else if (typeof target === "string") {
                input = document.querySelector(\'input[name*="\' + target + \'"], input[data-cart-item-key="\' + target + \'"]\');
            } else if (target && target.nodeType) {
                input = target.tagName === "INPUT" ? target : target.querySelector("input.qty");
            }
            if (!input) return;
            sanitizeQtyMax(input);

            var max = parseInt(input.max, 10);
            if (isNaN(max) || max <= 0) max = 9999;
            
            var parsed = Number(newQty);
            if (isNaN(parsed)) parsed = 1;
            var validQty = Math.max(1, parsed);
            if (!isNaN(max) && max > 0) validQty = Math.min(validQty, max);

            input.value = String(validQty);
            window.checkDraftChanges();
        };

        // Universal Quantity Increment/Decrement function
        window.updateQuantity = function(target, delta) {
            var input = null;
            if (typeof target === "number") {
                var inputs = document.querySelectorAll("input.qty, .ph-qty-wrap input");
                input = inputs[target];
            } else if (typeof target === "string") {
                input = document.querySelector(\'input[name*="\' + target + \'"], input[data-cart-item-key="\' + target + \'"]\');
            } else if (target && target.nodeType) {
                input = target.tagName === "INPUT" ? target : target.querySelector("input.qty");
            }
            if (!input) return;

            var current = Number(input.value);
            if (isNaN(current) || current < 1) current = 1;

            var d = Number(delta);
            if (isNaN(d)) d = 1;

            var nextQty = Math.max(1, current + d);
            window.handleQuantityChange(input, nextQty);
        };

        // Commit Cart Updates Function: triggers on "Update Cart" button click
        window.commitCartUpdates = function() {
            var totalItemsCount = 0;
            var subtotalSum = 0;

            document.querySelectorAll(".ph-cart-item input.qty, .ph-qty-wrap input.qty").forEach(function(inp) {
                var qtyVal = Math.max(1, Number(inp.value) || 1);
                inp.value = String(qtyVal);
                inp.setAttribute("data-saved-qty", String(qtyVal));

                var price = parseFloat(inp.getAttribute("data-price")) || 0;
                var lineTotal = (price * qtyVal).toFixed(2);
                totalItemsCount += qtyVal;
                subtotalSum += (price * qtyVal);

                // 1. Update Cart Row subtotal in cart table
                var row = inp.closest(".ph-cart-item");
                if (row) {
                    var subtotalEl = row.querySelector(".ph-cart-item__subtotal .woocommerce-Price-amount, .ph-cart-item__subtotal");
                    if (subtotalEl) {
                        var symbol = (subtotalEl.textContent.match(/[\\$\\€\\£\\¥]/) || ["$"])[0];
                        var subtotalInner = row.querySelector(".ph-cart-item__subtotal .woocommerce-Price-amount");
                        if (subtotalInner) {
                            subtotalInner.innerHTML = \'<bdi><span class="woocommerce-Price-currencySymbol">\' + symbol + \'</span>\' + lineTotal + \'</bdi>\';
                        } else {
                            subtotalEl.textContent = symbol + lineTotal;
                        }
                    }
                }

                // 2. Update matching Itemized Order Summary row
                var itemKey = inp.getAttribute("data-cart-item-key");
                if (itemKey) {
                    var summaryItem = document.querySelector(\'.ph-summary-item[data-cart-item-key="\' + itemKey + \'"]\');
                    if (summaryItem) {
                        var qtySpan = summaryItem.querySelector(".ph-summary-item__qty");
                        if (qtySpan) qtySpan.textContent = "× " + qtyVal;
                        var priceSpan = summaryItem.querySelector(".ph-summary-item__price .woocommerce-Price-amount, .ph-summary-item__price");
                        if (priceSpan) {
                            var sym = (priceSpan.textContent.match(/[\\$\\€\\£\\¥]/) || ["$"])[0];
                            var priceInner = summaryItem.querySelector(".ph-summary-item__price .woocommerce-Price-amount");
                            if (priceInner) {
                                priceInner.innerHTML = \'<bdi><span class="woocommerce-Price-currencySymbol">\' + sym + \'</span>\' + lineTotal + \'</bdi>\';
                            } else {
                                priceSpan.textContent = sym + lineTotal;
                            }
                        }
                    }
                }
            });

            // 3. Recalculate Subtotal, Total, and Cart Badge count
            if (subtotalSum > 0) {
                var formattedSum = subtotalSum.toFixed(2);
                document.querySelectorAll(".ph-summary-row span:last-child .woocommerce-Price-amount, .order-total .woocommerce-Price-amount, .ph-summary-total .woocommerce-Price-amount").forEach(function(amountEl) {
                    var curSym = (amountEl.textContent.match(/[\\$\\€\\£\\¥]/) || ["$"])[0];
                    amountEl.innerHTML = \'<bdi><span class="woocommerce-Price-currencySymbol">\' + curSym + \'</span>\' + formattedSum + \'</bdi>\';
                });

                document.querySelectorAll(".ph-cart-badge, .ph-nav-cart__badge").forEach(function(badge) {
                    badge.textContent = String(totalItemsCount);
                });
            }

            // Remove highlight from Update Cart button
            window.checkDraftChanges();

            // Display "Cart updated." notification
            var noticeWrap = document.querySelector(".woocommerce-notices-wrapper");
            if (!noticeWrap) {
                var cartPage = document.querySelector(".ph-cart-page, .woocommerce-cart");
                if (cartPage) {
                    noticeWrap = document.createElement("div");
                    noticeWrap.className = "woocommerce-notices-wrapper";
                    cartPage.insertBefore(noticeWrap, cartPage.firstChild);
                }
            }
            if (noticeWrap) {
                noticeWrap.innerHTML = \'<div class="woocommerce-message" role="alert">Cart updated.</div>\';
                noticeWrap.scrollIntoView({ behavior: "smooth", block: "nearest" });
            }

            // Asynchronously sync to WooCommerce backend without full page reload
            var form = document.querySelector("form.woocommerce-cart-form");
            if (form) {
                var formData = new FormData(form);
                formData.append("update_cart", "Update cart");
                fetch(form.getAttribute("action") || window.location.href, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                }).catch(function(err) {
                    console.warn("WooCommerce cart sync background request:", err);
                });
            }
        };

        // Click Handler on Cart Quantity Buttons & Update Cart Button
        document.addEventListener("click", function(e) {
            // 1. "Update Cart" Button Click
            var updateBtn = e.target.closest(\'button[name="update_cart"], .ph-update-cart-btn\');
            if (updateBtn) {
                e.preventDefault();
                e.stopPropagation();
                window.commitCartUpdates();
                return;
            }

            // 2. Quantity +/- Buttons Click (only updates local draft state)
            var btn = e.target.closest(".ph-qty-btn, .plus, .minus");
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            var wrap = btn.closest(".ph-qty-wrap, .quantity");
            if (!wrap) return;
            var qty = wrap.querySelector("input.qty, input[type=number]");
            if (!qty) return;
            sanitizeQtyMax(qty);

            var currentVal = Number(qty.value);
            if (isNaN(currentVal) || currentVal < 1) {
                currentVal = 1;
            }

            var max = parseInt(qty.max, 10);
            if (isNaN(max) || max <= 0) max = 9999;

            var isPlus = btn.dataset.action === "plus" ||
                         btn.classList.contains("plus") ||
                         (btn.getAttribute("aria-label") && /increase/i.test(btn.getAttribute("aria-label"))) ||
                         btn.textContent.trim() === "+" ||
                         btn.textContent.includes("+");

            var newQuantity = isPlus ? currentVal + 1 : currentVal - 1;
            newQuantity = Math.max(1, newQuantity);
            if (!isNaN(max) && max > 0) {
                newQuantity = Math.min(newQuantity, max);
            }

            qty.value = String(newQuantity);
            window.checkDraftChanges();
        });

        // Manual typing in quantity input
        document.addEventListener("input", function(e) {
            var qty = e.target.closest("input.qty, input[type=number]");
            if (!qty) return;
            sanitizeQtyMax(qty);
            var val = Number(qty.value);
            if (!isNaN(val) && val < 1) {
                qty.value = "1";
            }
            window.checkDraftChanges();
        });

        // Form submit interception (e.g. Enter key inside input)
        document.addEventListener("submit", function(e) {
            if (e.target && e.target.matches("form.woocommerce-cart-form")) {
                e.preventDefault();
                e.stopPropagation();
                window.commitCartUpdates();
            }
        });
    })();
    ');
}
add_action('wp_enqueue_scripts', 'purehoney_assets');

/* ═══════════════════════════════════════════════
   3. AUTO CREATE PAGES ON ACTIVATION
═══════════════════════════════════════════════ */
function purehoney_create_pages() {
    // Only run once
    if (get_option('purehoney_pages_created')) return;

    $pages = [
        'home'          => ['Home',           '',          'homepage'],
        'about-us'      => ['About Us',       purehoney_about_content(),    ''],
        'contact-us'    => ['Contact Us',     purehoney_contact_content(),  ''],
        'faq'           => ['FAQ',            purehoney_faq_content(),      ''],
        'track-order'   => ['Track My Order', purehoney_track_content(),    ''],
        'privacy-policy'=> ['Privacy Policy', purehoney_privacy_content(),  ''],
        'terms-conditions'=>['Terms & Conditions','',                        ''],
        'returns-refunds' =>['Returns & Refunds', '',                       ''],
        'shipping-policy' =>['Shipping Policy',   '',                       ''],
    ];

    $homepage_id = 0;

    foreach ($pages as $slug => $data) {
        [$title, $content, $meta] = $data;

        // Skip if page exists
        $existing = get_page_by_path($slug);
        if ($existing) {
            if ($slug === 'home') $homepage_id = $existing->ID;
            continue;
        }

        $id = wp_insert_post([
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_author'  => 1,
        ]);

        if ($id && !is_wp_error($id)) {
            if ($slug === 'home') {
                $homepage_id = $id;
                // Use default template so front-page.php runs
                update_post_meta($id, '_wp_page_template', 'default');
                // Inject Elementor homepage data
                purehoney_inject_homepage_elementor($id);
            }
            if ($meta === 'homepage') {
                update_post_meta($id, '_wp_page_template', 'default');
            }
        }
    }

    // Set static homepage
    if ($homepage_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $homepage_id);
    }

    if (function_exists('wc_create_pages')) {
        wc_create_pages();
    }

    update_option('purehoney_pages_created', true);
}
add_action('after_switch_theme', 'purehoney_create_pages');
// Also run on init for safety
add_action('init', function() {
    if (!get_option('purehoney_pages_created')) {
        purehoney_create_pages();
    }
}, 20);

// Prevent Elementor or other plugins from hijacking the static front page template
add_filter('template_include', function($template) {
    if (is_front_page()) {
        $front_page = get_template_directory() . '/front-page.php';
        if (file_exists($front_page)) {
            return $front_page;
        }
    }
    return $template;
}, 99);

/* ═══════════════════════════════════════════════
   4. ELEMENTOR HOMEPAGE DATA INJECTION
═══════════════════════════════════════════════ */
function purehoney_inject_homepage_elementor($page_id) {
    // Mark page as Elementor-built (triggers Elementor to load on this page)
    update_post_meta($page_id, '_elementor_edit_mode', 'builder');
    update_post_meta($page_id, '_elementor_template_type', 'wp-page');
    update_post_meta($page_id, '_elementor_version', '3.0.0');

    $hero_bg = get_template_directory_uri() . '/assets/images/hero-bg.jpg';
    $cat_dispensers = get_template_directory_uri() . '/assets/images/cat-dispensers.jpg';
    $cat_kitchen = get_template_directory_uri() . '/assets/images/cat-kitchen.jpg';
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');

    // Build Elementor JSON data for the homepage
    $data = json_encode([
        [
            'id' => 'ph-hero-section',
            'elType' => 'section',
            'settings' => [
                'background_background' => 'classic',
                'background_image' => ['url' => $hero_bg, 'alt' => 'PureHoney Hero'],
                'background_size' => 'cover',
                'background_position' => 'center center',
                'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
                'height' => '100vh',
                'layout' => 'full_width',
            ],
            'elements' => [
                [
                    'id' => 'ph-hero-col',
                    'elType' => 'column',
                    'settings' => [
                        'background_background' => 'classic',
                        'background_color' => 'rgba(17,11,2,0.75)',
                        'padding' => ['unit' => 'px', 'top' => '120', 'right' => '80', 'bottom' => '120', 'left' => '80', 'isLinked' => false],
                        '_column_size' => 100,
                    ],
                    'elements' => [
                        [
                            'id' => 'ph-hero-eyebrow',
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Nature\'s Gold, Elegantly Dispensed',
                                'header_size' => 'p',
                                'align' => 'left',
                                'typography_typography' => 'custom',
                                'typography_font_size' => ['unit' => 'px', 'size' => 13],
                                'typography_font_weight' => '700',
                                'typography_letter_spacing' => ['unit' => 'px', 'size' => 3],
                                'typography_text_transform' => 'uppercase',
                                'title_color' => '#E8961A',
                            ],
                        ],
                        [
                            'id' => 'ph-hero-heading',
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Where <span style="color:#E8961A">Honey Meets</span> Artisan Elegance',
                                'description' => 'Discover our exclusive collection of premium honey accessories.',
                                'typography_typography' => 'custom',
                                'typography_font_size' => ['unit' => 'vw', 'size' => 6],
                                'typography_font_weight' => '800',
                                'title_color' => '#FFFFFF',
                            ],
                        ],
                        [
                            'id' => 'ph-hero-text',
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p>Discover our curated collection of handcrafted honey dispensers, luxury gift sets, and kitchen essentials.</p>',
                                'typography_typography' => 'custom',
                                'typography_font_size' => ['unit' => 'px', 'size' => 18],
                                'text_color' => 'rgba(255,255,255,0.72)',
                            ],
                        ],
                        [
                            'id' => 'ph-hero-btn',
                            'elType' => 'widget',
                            'widgetType' => 'button',
                            'settings' => [
                                'text' => 'Shop the Collection',
                                'link' => ['url' => $shop_url],
                                'align' => 'left',
                                'background_color' => '#E8961A',
                                'button_text_color' => '#241100',
                                'border_radius' => ['unit' => 'px', 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true],
                                'padding' => ['unit' => 'px', 'top' => '16', 'right' => '36', 'bottom' => '16', 'left' => '36', 'isLinked' => false],
                                'typography_typography' => 'custom',
                                'typography_font_weight' => '700',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    update_post_meta($page_id, '_elementor_data', $data);
}

/* ═══════════════════════════════════════════════
   5. PAGE CONTENT GENERATORS
═══════════════════════════════════════════════ */
function purehoney_about_content() {
    return '<div class="ph-container"><div class="page-content"><h2>Our Story</h2><p>PureHoney was born from a simple belief: that honey — the world\'s oldest natural sweetener — deserves to be presented as the treasure it truly is. We partner with artisan craftspeople to create dispensers and accessories that honor both the bees and the people who love their golden harvest.</p><h3>Our Mission</h3><p>To make everyday rituals feel luxurious. Every piece in our collection is thoughtfully designed, rigorously quality-tested, and beautifully packaged.</p></div></div>';
}

function purehoney_contact_content() {
    return '<div class="ph-container"><div class="page-content"><h2>Get In Touch</h2><p>We\'d love to hear from you. Reach us at <a href="mailto:hello@purehoney.me">hello@purehoney.me</a> and we\'ll respond within 24 hours.</p>' . do_shortcode('[contact-form-7 id="contact-form" title="Contact Form"]') . '</div></div>';
}

function purehoney_faq_content() {
    return '<div class="ph-container"><div class="page-content"><h2>Frequently Asked Questions</h2>
    <h3>How long does shipping take?</h3><p>Standard shipping takes 2–4 business days. Express options are available at checkout.</p>
    <h3>Are your products dishwasher safe?</h3><p>Most glass and ceramic products are dishwasher safe. Wooden items should be hand-washed. Check individual product descriptions for details.</p>
    <h3>Do you offer gift wrapping?</h3><p>Yes! Gift wrapping is available for all orders. Add a personalised message at checkout.</p>
    <h3>What is your returns policy?</h3><p>We offer 30-day hassle-free returns on all unused items. Visit our <a href="/returns-refunds">Returns page</a> for details.</p>
    </div></div>';
}

function purehoney_track_content() {
    return '<div class="ph-container"><div class="page-content"><h2>Track Your Order</h2><p>Enter your order number below or <a href="' . wc_get_account_endpoint_url('orders') . '">visit My Orders</a> to track your shipment.</p>' . do_shortcode('[woocommerce_order_tracking]') . '</div></div>';
}

function purehoney_privacy_content() {
    return '<div class="ph-container"><div class="page-content"><h2>Privacy Policy</h2><p>At PureHoney, your privacy is important to us. We collect only the information needed to fulfil your orders and improve your experience. We never sell your data to third parties.</p><p>For full details, please <a href="mailto:hello@purehoney.me">contact us</a>.</p></div></div>';
}

/* ═══════════════════════════════════════════════
   6. WOOCOMMERCE SETUP
═══════════════════════════════════════════════ */
// Remove default WooCommerce styles (we use our own)
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Product columns
add_filter('loop_shop_columns', function() { return 4; });
add_filter('loop_shop_per_page', function() { return 12; });

// WooCommerce wrappers — only apply on shop/category (NOT cart/checkout/account which have their own templates)
add_action('woocommerce_before_main_content', function() {
    if (is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url('order-received')) return;
    echo '<div class="ph-container" style="padding-top:48px;padding-bottom:80px;">';
}, 10);

add_action('woocommerce_after_main_content', function() {
    if (is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url('order-received')) return;
    echo '</div>';
}, 10);

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/* ═══════════════════════════════════════════════
   6b. IMPORT PRODUCT IMAGES FROM STOCK PHOTOS
═══════════════════════════════════════════════ */
// Runs once to assign real stock photos to products
function purehoney_import_product_images() {
    if (get_option('purehoney_images_imported')) return;
    if (!function_exists('WC')) return;

    // Map product SKU => Unsplash photo URL (free, high quality)
    $product_images = [
        'PH-AD-001' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=600&q=80',
        'PH-AD-002' => 'https://images.unsplash.com/photo-1601049676869-702ea24cfd58?w=600&q=80',
        'PH-AD-003' => 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=600&q=80',
        'PH-AD-004' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&q=80',
        'PH-AD-005' => 'https://images.unsplash.com/photo-1504198453619-5c2cc7e2af0d?w=600&q=80',
        'PH-LG-001' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=600&q=80',
        'PH-LG-002' => 'https://images.unsplash.com/photo-1607082349566-187342175e2f?w=600&q=80',
        'PH-LG-003' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=600&q=80',
        'PH-LG-004' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=600&q=80',
        'PH-LG-005' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
        'PH-KE-001' => 'https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=600&q=80',
        'PH-KE-002' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80',
        'PH-KE-003' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&q=80',
        'PH-KE-004' => 'https://images.unsplash.com/photo-1565071559227-20ab25b7685e?w=600&q=80',
        'PH-KE-005' => 'https://images.unsplash.com/photo-1544943910-4c1dc44aab44?w=600&q=80',
    ];

    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $count = 0;
    foreach ($product_images as $sku => $image_url) {
        // Find product by SKU
        $product_id = wc_get_product_id_by_sku($sku);
        if (!$product_id) continue;

        // Skip if already has image
        $existing = get_post_thumbnail_id($product_id);
        if ($existing) continue;

        // Sideload image
        $attachment_id = media_sideload_image($image_url, $product_id, null, 'id');
        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($product_id, $attachment_id);
            $count++;
        }

        // Avoid timeout
        if ($count >= 5) {
            // Run in batches - will pick up on next page load
            break;
        }
    }

    if ($count < 5) {
        // All images processed
        update_option('purehoney_images_imported', true);
    }
}
add_action('admin_init', 'purehoney_import_product_images');

// Breadcrumb separator
add_filter('woocommerce_breadcrumb_defaults', function($defaults) {
    $defaults['delimiter'] = ' <span style="color:#E8961A;opacity:0.5;">›</span> ';
    return $defaults;
});

// Cart fragment update
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    $count = WC()->cart->get_cart_contents_count();
    $fragments['.ph-cart-count'] = '<span class="ph-cart-count" ' . ($count === 0 ? 'style="display:none"' : '') . '>' . $count . '</span>';
    return $fragments;
});

/* ═══════════════════════════════════════════════
   7. NEWSLETTER AJAX
═══════════════════════════════════════════════ */
add_action('wp_ajax_purehoney_newsletter', 'purehoney_newsletter_handler');
add_action('wp_ajax_nopriv_purehoney_newsletter', 'purehoney_newsletter_handler');

function purehoney_newsletter_handler() {
    check_ajax_referer('purehoney_nonce', 'nonce');
    $email = sanitize_email($_POST['email'] ?? '');
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }
    // Log subscriber (simple option-based for now, can integrate Mailchimp/etc)
    $subscribers = get_option('purehoney_subscribers', []);
    if (!in_array($email, $subscribers, true)) {
        $subscribers[] = $email;
        update_option('purehoney_subscribers', $subscribers);
    }
    wp_send_json_success(['message' => 'Thank you! You\'ll receive 10% off in your inbox shortly.']);
}

/* ═══════════════════════════════════════════════
   8. CUSTOM SHORTCODES
═══════════════════════════════════════════════ */
// Trust bar
add_shortcode('ph_trust_bar', function() {
    $items = [
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>', 'label' => 'Free Shipping', 'sub' => 'On orders over $59'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>', 'label' => 'Handcrafted', 'sub' => 'Artisan quality'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>', 'label' => '30-Day Returns', 'sub' => 'Hassle-free policy'],
        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>', 'label' => 'Gift Wrapping', 'sub' => 'Free on all orders'],
    ];
    $out = '<div class="ph-trust"><div class="ph-container"><div class="ph-trust__grid">';
    foreach ($items as $item) {
        $out .= '<div class="ph-trust__item">';
        $out .= '<div class="ph-trust__icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22">' . $item['icon'] . '</svg></div>';
        $out .= '<div><div class="ph-trust__label">' . esc_html($item['label']) . '</div><div class="ph-trust__sub">' . esc_html($item['sub']) . '</div></div>';
        $out .= '</div>';
    }
    $out .= '</div></div></div>';
    return $out;
});

/* ═══════════════════════════════════════════════
   9. TITLE TAG SUPPORT
═══════════════════════════════════════════════ */
add_filter('wp_title', function($title, $sep) {
    if (is_feed()) return $title;
    $title .= $sep . ' ' . get_bloginfo('name');
    return $title;
}, 10, 2);

/* ═══════════════════════════════════════════════
   10. SECURITY & CLEANUP
═══════════════════════════════════════════════ */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
add_filter('the_generator', '__return_false');
add_filter('show_admin_bar', '__return_false');

// Image sizes
add_image_size('purehoney-hero',    1920, 1080, true);
add_image_size('purehoney-product', 600,  600,  true);
add_image_size('purehoney-card',    480,  640,  true);

/* ═══════════════════════════════════════════════
   11. ELEMENTOR PRO THEME LOCATIONS
═══════════════════════════════════════════════ */
add_action('elementor/theme/register_locations', function($manager) {
    $manager->register_all_core_location();
});

/* ═══════════════════════════════════════════════
   12. BODY CLASSES
═══════════════════════════════════════════════ */
add_filter('body_class', function($classes) {
    if (is_front_page()) $classes[] = 'ph-homepage';
    if (is_woocommerce()) $classes[] = 'ph-woo-page';
    return $classes;
});

/* ═══════════════════════════════════════════════
   13. CART PRG FIX (ERR_CACHE_MISS)
═══════════════════════════════════════════════ */
add_action('template_redirect', function() {
    if (is_cart() && $_SERVER['REQUEST_METHOD'] === 'POST' && !wp_doing_ajax() && !isset($_GET['wc-ajax'])) {
        if (isset($_POST['update_cart']) || isset($_POST['apply_coupon']) || isset($_POST['calc_shipping'])) {
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    }
});






