# PureHoney – Complete Setup Guide
# https://purehoney.me

## What's In This Package

```
purehoney/
├── theme/purehoney-child/     ← Upload this as a ZIP to WordPress
│   ├── style.css              ← Child theme styles (design system)
│   ├── functions.php          ← Theme logic, WooCommerce hooks
│   ├── front-page.php         ← Homepage template
│   ├── header.php             ← Header with transparent sticky nav
│   ├── footer.php             ← Footer with social/links/newsletter
│   └── assets/
│       ├── css/header.css     ← Header + UI component styles
│       ├── js/purehoney.js    ← Lenis scroll, animations, interactions
│       └── images/            ← Hero + category images
│           ├── hero-bg.jpg
│           ├── cat-dispensers.jpg
│           └── cat-kitchen.jpg
├── woocommerce/
│   └── products.csv           ← 15 products ready to import
└── README.md                  ← This file
```

---

## STEP 1 — Upload the Child Theme

1. Zip the `theme/purehoney-child/` folder → name it `purehoney-child.zip`
   (Already zipped at `d:\projects\purehoney\purehoney-child.zip`)

2. In WordPress Admin → **Appearance → Themes → Add New → Upload Theme**

3. Upload `purehoney-child.zip` → **Install Now** → **Activate**

---

## STEP 2 — Configure Astra (Required!)

Go to **Appearance → Customize** and set:

### Typography
- Body Font: **Inter** (Google Fonts)
- Headings Font: **Playfair Display** (Google Fonts)

### Colors (Global Palette)
- Color 1 (Primary): `#D4AF37` (Gold)
- Color 2 (Secondary): `#1a1a1a` (Charcoal)
- Color 3 (Text): `#333333`

### Header
- Go to **Header → Primary Header**
- Set "Transparent Header" → **Enable on Homepage**
- Header height: **90px**
- Logo width: **160px**

### Buttons
- Background: `#D4AF37`
- Text color: `#1a1a1a`
- Hover background: `#B8960A`

---

## STEP 3 — Import Products (15 Products)

1. Go to **WooCommerce → Products → Import**
2. Upload `woocommerce/products.csv`
3. Map columns → **Run Import**
4. All 15 products across 3 categories will be created

---

## STEP 4 — Set Up Homepage in Elementor

1. Go to **Pages → Add New**
2. Title: **Home** → Set template to **Elementor Canvas** (full width)
3. Click **Edit with Elementor**
4. Build the homepage using Elementor widgets:

### Homepage Sections to Build:

**Section 1: Hero**
- Widget: Section with background image → upload `hero-bg.jpg`
- Overlay: `rgba(17,11,2,0.55)`
- Add Heading: "Where Honey Meets Artisan Elegance"
- Add Text: "Nature's Gold, Elegantly Dispensed"
- Add 2 buttons: "Shop the Collection" + "Our Story"
- Height: 100vh
- Enable: Elementor Motion Effects → Scroll → Parallax

**Section 2: Trust Bar**
- 4-column layout with icons + text
- Background: `#1a1a1a`
- Items: Free Shipping | Handcrafted | 30-Day Returns | Gift Wrapping

**Section 3: Featured Products**
- Widget: **WooCommerce → Products** (Featured = Yes, limit 5)
- Title: "Top Picks This Season"

**Section 4: Categories (3 columns)**
- Widget: **WooCommerce → Product Categories**
- Or use Image Box widgets with category images

**Section 5: Story Section (2 columns)**
- Left: Image (story-bg)
- Right: Text + stats (2000+ customers, 15+ products, 98% satisfaction)

**Section 6: Best Sellers**
- Widget: **WooCommerce → Products** (Best Selling, limit 8)

**Section 7: Features (4 icons)**
- Pure Materials | Crafted with Love | Eco Packaging | Fast Delivery

**Section 8: Newsletter**
- Background: `#1a0d00` (dark honey)
- Email opt-in form

5. **Publish** the page

6. Go to **Settings → Reading**:
   - Homepage displays: **A static page**
   - Homepage: **Home** (the page you just created)

---

## STEP 5 — Smooth Scroll Setup

The Lenis smooth scroll is automatically loaded by the child theme.
No extra configuration needed — it activates on all pages automatically.

To verify it's working:
- Open `https://purehoney.me` in browser
- Open DevTools Console — you should see no errors
- Scroll should feel buttery smooth

---

## STEP 6 — Configure Elementor Global Settings

Go to **Elementor → Settings → Style**:

- Primary Color: `#D4AF37`
- Secondary Color: `#1a1a1a`  
- Body Font: Inter
- Heading Font: Playfair Display

Go to **Elementor → Settings → Advanced**:
- CSS Print Method: Internal Embedding
- Optimized DOM Output: Enable

---

## STEP 7 — Essential Pages to Create

Create these pages (can be simple text pages for now):
- `/about-us` — Our Story
- `/contact-us` — Contact form (use Contact Form 7)
- `/track-order` — Order tracking
- `/faq` — Frequently Asked Questions

---

## Color Reference

```css
Gold:          #D4AF37
Gold Light:    #F0D060
Gold Dark:     #B8960A
Charcoal:      #1a1a1a
Ivory:         #FFF8E7
Cream:         #FAF3E0
Text:          #333333
Text Light:    #777777
Dark BG:       #111111
```

---

## Plugin Requirements

| Plugin | Version | Purpose |
|--------|---------|---------|
| Astra | 4.x+ | Parent theme |
| Elementor Pro | 3.x+ | Page builder |
| WooCommerce | 8.x+ | E-commerce |
| Astra Starter Templates | Latest | Template library |

---

## Support

Site: https://purehoney.me  
Admin: https://purehoney.me/wp-admin/
