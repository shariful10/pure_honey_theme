<?php
/**
 * Single Product Image & Interactive Thumbnail Gallery
 * PureHoney Luxury WooCommerce Theme
 */
defined('ABSPATH') || exit;

global $product;

if (empty($product)) {
    return;
}

$product_id = $product->get_id();
$sku        = $product->get_sku();
$slug       = $product->get_slug();
$name       = $product->get_name();

$theme_dir = get_template_directory();
$theme_uri = get_template_directory_uri();

// 1. Resolve Primary Image
$primary_url = '';
if (has_post_thumbnail($product_id)) {
    $primary_url = wp_get_attachment_image_url(get_post_thumbnail_id($product_id), 'full');
} elseif ($sku && file_exists($theme_dir . '/assets/images/products/' . $sku . '.jpg')) {
    $primary_url = $theme_uri . '/assets/images/products/' . $sku . '.jpg';
} elseif ($slug && file_exists($theme_dir . '/assets/images/products/' . $slug . '.jpg')) {
    $primary_url = $theme_uri . '/assets/images/products/' . $slug . '.jpg';
} else {
    $primary_url = $theme_uri . '/assets/images/products/placeholder.jpg';
}

// 2. Resolve Gallery Items
$gallery_items = [];
$seen_urls = [];

// Item 1: Main Hero Studio View
$gallery_items[] = [
    'full'  => $primary_url,
    'thumb' => $primary_url,
    'alt'   => $name . ' - Main Studio View',
    'label' => 'Main View'
];
$seen_urls[$primary_url] = true;

// Check WooCommerce Native Gallery Attachments from DB
$attachment_ids = $product->get_gallery_image_ids();
if (!empty($attachment_ids)) {
    foreach ($attachment_ids as $attachment_id) {
        $full_url  = wp_get_attachment_image_url($attachment_id, 'full');
        $thumb_url = wp_get_attachment_image_url($attachment_id, 'woocommerce_gallery_thumbnail') ?: $full_url;
        if ($full_url && !isset($seen_urls[$full_url])) {
            $seen_urls[$full_url] = true;
            $gallery_items[] = [
                'full'  => $full_url,
                'thumb' => $thumb_url,
                'alt'   => get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: ($name . ' - Gallery View'),
                'label' => 'Gallery View'
            ];
        }
    }
}

// Check SKU-specific Angle Crops / Variants ({sku}-detail.jpg, {sku}-angle.jpg, etc.)
$variant_definitions = [
    ['detail',    'Craft Detail',     'Craftsmanship Detail'],
    ['angle',     'Angle View',       'Alternate Angle'],
    ['lifestyle', 'Lifestyle Context', 'Kitchen Lifestyle Setting'],
    ['pairing',   'Honey Pairing',    'Honey Jar Pairing']
];

if ($sku) {
    foreach ($variant_definitions as $v) {
        $sfx = $v[0];
        $lbl = $v[1];
        $alt = $v[2];
        $v_path = $theme_dir . '/assets/images/products/' . $sku . '-' . $sfx . '.jpg';
        if (file_exists($v_path)) {
            $v_url = $theme_uri . '/assets/images/products/' . $sku . '-' . $sfx . '.jpg';
            if (!isset($seen_urls[$v_url])) {
                $seen_urls[$v_url] = true;
                $gallery_items[] = [
                    'full'  => $v_url,
                    'thumb' => $v_url,
                    'alt'   => $name . ' - ' . $alt,
                    'label' => $lbl
                ];
            }
        }
    }
}

// 3. Fallback: If fewer than 4-5 items, supply curated lifestyle & artisan pairing angles
if (count($gallery_items) < 5) {
    $fallbacks = [
        [
            'file'  => '/assets/images/products/hexagonal-glass-honey-jar-with-bamboo-lid.jpg',
            'label' => 'Honey Pairing',
            'alt'   => 'Pure Honey Hexagonal Jar Pairing'
        ],
        [
            'file'  => '/assets/images/cat-kitchen.jpg',
            'label' => 'Artisan Kitchen',
            'alt'   => 'Pure Honey Artisan Kitchen Setting'
        ],
        [
            'file'  => '/assets/images/cat-dispensers.jpg',
            'label' => 'Artisan Display',
            'alt'   => 'Pure Honey Artisan Dispensers'
        ],
        [
            'file'  => '/assets/images/products/crystal-clear-honeycomb-jar-dipper-set.jpg',
            'label' => 'Honeycomb Set',
            'alt'   => 'Pure Honey Crystal Honeycomb'
        ]
    ];

    foreach ($fallbacks as $fb) {
        if (count($gallery_items) >= 5) {
            break;
        }
        if (file_exists($theme_dir . $fb['file'])) {
            $fb_url = $theme_uri . $fb['file'];
            if (!isset($seen_urls[$fb_url])) {
                $seen_urls[$fb_url] = true;
                $gallery_items[] = [
                    'full'  => $fb_url,
                    'thumb' => $fb_url,
                    'alt'   => $name . ' - ' . $fb['alt'],
                    'label' => $fb['label']
                ];
            }
        }
    }
}

// Cap to 5 thumbnails for compact, elegant horizontal row alignment
$gallery_items = array_slice($gallery_items, 0, 5);
$columns_count = count($gallery_items);
?>

<div class="woocommerce-product-gallery ph-product-gallery-wrapper images" data-columns="<?php echo esc_attr($columns_count); ?>">
  <div class="ph-product-gallery" id="ph-product-gallery-<?php echo esc_attr($product_id); ?>" style="--gallery-cols: <?php echo esc_attr($columns_count); ?>;">
    
    <!-- Main Hero Image Display -->
    <div class="ph-product-gallery__main">
      <img 
        id="ph-gallery-main-img-<?php echo esc_attr($product_id); ?>" 
        class="ph-gallery-hero-img wp-post-image" 
        src="<?php echo esc_url($gallery_items[0]['full']); ?>" 
        alt="<?php echo esc_attr($gallery_items[0]['alt']); ?>" 
        width="800" 
        height="800"
        loading="eager"
      />
      <div class="ph-gallery-badge">
        <span class="ph-gallery-badge__dot"></span>
        <span class="ph-gallery-badge__label" id="ph-gallery-badge-label-<?php echo esc_attr($product_id); ?>">
          <?php echo esc_html($gallery_items[0]['label']); ?>
        </span>
      </div>
    </div>

    <!-- Thumbnail Gallery Row directly beneath Hero Image -->
    <div class="ph-product-gallery__thumbs" role="tablist" aria-label="<?php esc_attr_e('Product gallery thumbnails', 'purehoney'); ?>">
      <?php foreach ($gallery_items as $index => $item): ?>
        <button 
          type="button" 
          class="ph-gallery-thumb <?php echo $index === 0 ? 'is-active' : ''; ?>" 
          data-index="<?php echo esc_attr($index); ?>"
          data-full-src="<?php echo esc_url($item['full']); ?>"
          data-alt="<?php echo esc_attr($item['alt']); ?>"
          data-label="<?php echo esc_attr($item['label']); ?>"
          role="tab"
          aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
          aria-label="<?php echo esc_attr($item['label']); ?>"
        >
          <img 
            src="<?php echo esc_url($item['thumb']); ?>" 
            alt="<?php echo esc_attr($item['alt']); ?>" 
            loading="lazy" 
            width="120" 
            height="120"
          />
        </button>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<script>
(function() {
  function initGallery() {
    var gallery = document.getElementById('ph-product-gallery-<?php echo esc_js($product_id); ?>');
    if (!gallery) return;

    var mainImg = document.getElementById('ph-gallery-main-img-<?php echo esc_js($product_id); ?>');
    var badgeLabel = document.getElementById('ph-gallery-badge-label-<?php echo esc_js($product_id); ?>');
    var thumbs = gallery.querySelectorAll('.ph-gallery-thumb');

    // Preload all gallery images for instantaneous swapping with zero lag
    thumbs.forEach(function(thumb) {
      var src = thumb.getAttribute('data-full-src');
      if (src) {
        var img = new Image();
        img.src = src;
      }
    });

    function activateThumb(thumb) {
      if (thumb.classList.contains('is-active')) return;

      var fullSrc = thumb.getAttribute('data-full-src');
      var altText = thumb.getAttribute('data-alt');
      var label   = thumb.getAttribute('data-label');

      // Update active classes and aria states
      thumbs.forEach(function(t) {
        t.classList.remove('is-active');
        t.setAttribute('aria-selected', 'false');
      });
      thumb.classList.add('is-active');
      thumb.setAttribute('aria-selected', 'true');

      // Seamless instantaneous crossfade
      if (mainImg && fullSrc) {
        mainImg.style.opacity = '0.35';
        mainImg.style.transform = 'scale(0.99)';
        setTimeout(function() {
          mainImg.src = fullSrc;
          if (altText) mainImg.alt = altText;
          mainImg.style.opacity = '1';
          mainImg.style.transform = 'scale(1)';
        }, 50);
      }

      if (badgeLabel && label) {
        badgeLabel.textContent = label;
      }
    }

    thumbs.forEach(function(thumb) {
      // Swaps on hover
      thumb.addEventListener('mouseenter', function() {
        activateThumb(thumb);
      });
      // Swaps on click
      thumb.addEventListener('click', function(e) {
        e.preventDefault();
        activateThumb(thumb);
      });
      // Keyboard support
      thumb.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          activateThumb(thumb);
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGallery);
  } else {
    initGallery();
  }
})();
</script>
