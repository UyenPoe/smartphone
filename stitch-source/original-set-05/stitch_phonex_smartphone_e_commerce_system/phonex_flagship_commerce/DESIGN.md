---
name: PhoneX Flagship Commerce
colors:
  surface: '#f8f9fb'
  surface-dim: '#d9dadc'
  surface-bright: '#f8f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#edeef0'
  surface-container-high: '#e7e8ea'
  surface-container-highest: '#e1e2e4'
  on-surface: '#191c1e'
  on-surface-variant: '#5f3f3b'
  inverse-surface: '#2e3132'
  inverse-on-surface: '#f0f1f3'
  outline: '#946e69'
  outline-variant: '#e9bcb6'
  surface-tint: '#c0000d'
  primary: '#b7000c'
  on-primary: '#ffffff'
  primary-container: '#e60012'
  on-primary-container: '#fff7f6'
  inverse-primary: '#ffb4aa'
  secondary: '#5f5e5e'
  on-secondary: '#ffffff'
  secondary-container: '#e5e2e1'
  on-secondary-container: '#656464'
  tertiary: '#595a5a'
  on-tertiary: '#ffffff'
  tertiary-container: '#727272'
  on-tertiary-container: '#faf8f8'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdad5'
  primary-fixed-dim: '#ffb4aa'
  on-primary-fixed: '#410001'
  on-primary-fixed-variant: '#930007'
  secondary-fixed: '#e5e2e1'
  secondary-fixed-dim: '#c8c6c5'
  on-secondary-fixed: '#1c1b1b'
  on-secondary-fixed-variant: '#474646'
  tertiary-fixed: '#e4e2e2'
  tertiary-fixed-dim: '#c7c6c6'
  on-tertiary-fixed: '#1b1c1c'
  on-tertiary-fixed-variant: '#464747'
  background: '#f8f9fb'
  on-background: '#191c1e'
  surface-variant: '#e1e2e4'
  primary-hover: '#C90010'
  text-main: '#222222'
  border-subtle: '#E5E7EB'
  surface-pure: '#FFFFFF'
typography:
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
  headline-xl-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 36px
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  title-product:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  price-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 22px
    fontWeight: '700'
    lineHeight: 28px
  price-card:
    fontFamily: Plus Jakarta Sans
    fontSize: 18px
    fontWeight: '700'
    lineHeight: 24px
  price-strikethrough:
    fontFamily: Plus Jakarta Sans
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
  body-regular:
    fontFamily: Plus Jakarta Sans
    fontSize: 15px
    fontWeight: '400'
    lineHeight: 22px
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
  label-badge:
    fontFamily: Plus Jakarta Sans
    fontSize: 11px
    fontWeight: '700'
    lineHeight: 14px
    letterSpacing: 0.02em
  label-button:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.25rem
  gutter-mobile: 0.75rem
  margin: 1.5rem
  margin-desktop: 3.5rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
  space-2xl: 4rem
---

## Brand & Style

This design system establishes an authoritative, high-conversion retail presence specialized strictly in modern smartphones. Grounded in a modern, premium corporate aesthetic, it blends crisp structural precision with high-impact kinetic accents.

### Target Audience & Core Experience
- **Audience:** Discerning tech buyers, mobile power users, and everyday consumers seeking genuine devices, zero-interest installment options, and reliable trade-in programs.
- **Emotional Mandate:** Uncompromised trust, instant scannability, device-first excitement, and effortless checkout momentum.
- **Visual Stance:** Restrained minimalism that allows high-resolution hardware photography to anchor the page. Avoids marketplace clutter, neon gradient excess, and decorative noise in favor of stark contrast, rational grids, and purposeful red focal triggers.

## Colors

The color palette operates on high-contrast hierarchy tailored for decisive retail transactions:

- **Primary (`#E60012`):** Reserved exclusively for conversion drivers, immediate promotion callouts, active price tags, and primary transactional triggers. Hover shifts to `#C90010`.
- **Secondary (`#111111`):** Deep carbon black used for brand headers, navigation anchor bars, top-level headings, and secondary contrast elements.
- **Tertiary (`#666666`):** Balanced neutral gray for secondary metadata, previous retail prices (rendered with strikethrough), review counts, and specifications.
- **Neutral Surface System:**
  - `surface-pure` (`#FFFFFF`): The primary plane for product cards, modal surfaces, and content sheets.
  - `neutral` (`#F6F7F9`): The foundational canvas backdrop providing soft contrast against white cards.
  - `border-subtle` (`#E5E7EB`): Structural containment lines for card bounds, search boxes, and grid dividers.

## Typography

The typographic hierarchy utilizes Plus Jakarta Sans throughout for clean geometry, distinct letterforms, and high legibility across product grids:

- **Headlines & Sections:** Heavy weights (700) guarantee scan-friendly separation between store departments and flash sales.
- **Product Titles:** Set at 16px semibold (600) with a maximum two-line clamp to enforce grid alignment across variable phone names.
- **Price Stacks:** Emphasizes numerical weight with `price-card` in bold Primary Red, directly paired with reduced, strike-through previous pricing in Tertiary Gray.
- **Badges & Micro-Copy:** High tracking (+0.02em) with all-caps or title-case bold treatments for trade-in, 0% installment, and discount chips.

## Layout & Spacing

Layout geometry conforms to a clean, fixed-width architectural constraint:

- **Desktop Framework:** Standard canvas target is 1440px wide, confining core content inside a centered 1200px to 1320px container block.
- **Column Grids:**
  - **Desktop (>= 1024px):** 12-column grid; product showcase grids uniformly scale across 4 or 5 columns with a 20px (`1.25rem`) gutter.
  - **Tablet (768px - 1023px):** 3-column product grid with 16px gutters.
  - **Mobile (< 768px):** Strict 2-column product grid with 12px (`0.75rem`) gutters to balance density and touch ergonomics.
- **Rhythm & Cadence:** Major home page sections are decoupled with wide `space-2xl` (64px) vertical separation, avoiding visual congestion while maintaining clean thematic blocks.

## Elevation & Depth

This design system avoids heavy drop shadows and dramatic skeuomorphic depth, relying instead on clean surface layering, hairline borders, and targeted hover responses:

- **Base Cards:** Elevated on a crisp `#FFFFFF` fill bounded by a 1px border in `#E5E7EB`. Ground elevation employs an ambient shadow: `0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02)`.
- **Card Hover State:** Elevates softly via `0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04)` alongside a subtle border color shift toward `#D1D5DB`, lifting the phone graphic toward the shopper.
- **Fixed & Sticky Chrome:** The sticky top header and mobile bottom bar sit at elevation level 3 (`0 4px 20px rgba(0, 0, 0, 0.06)`), maintaining crisp spatial separation from the scrolling catalog beneath.
- **Flyouts & Modals:** Deep floating overlays use sharp containment with `0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)` over a semi-translucent dark scrim (`rgba(0, 0, 0, 0.5)`).

## Shapes

The interface embraces a balanced modern radius level (`roundedness: 2`):

- **Core Elements (Buttons, Inputs, Badges):** 8px (`0.5rem`) corner radius delivers a contemporary, clean finish without appearing overly playful or toy-like.
- **Product Cards & Feature Blocks:** 12px to 16px (`rounded-lg` / `rounded-xl`) outer containment that comfortably frames high-resolution smartphone imagery.
- **Pill Accents:** Specific conversion components—such as storage capacity pills (e.g., 256GB), color selectors, and micro-badges (0% installment)—use full pill radials (9999px) to establish distinct interactive affordance.

## Components

### 1. Primary & Secondary Buttons
- **Primary CTA:** Background `#E60012`, pure white text, 8px border-radius, bold label font, minimum height 44px (48px for sticky mobile CTA). Hover transitions cleanly to `#C90010`.
- **Secondary CTA:** Background `#FFFFFF`, 1.5px solid `#E60012`, text color `#E60012`. Hover triggers a `#FFF5F5` tint transition.
- **Action Icons:** Wishlist and compare icon buttons feature circular or square 8px borders in `#E5E7EB` with dark icon glyphs transitioning to `#E60012` on hover/active.

### 2. Product Card Architecture
Each smartphone card adheres to an exact vertical flow:
1. **Top Utility Bar:** Discount badge (e.g., `-12%`) and 0% Installment chip pinned top-left; Wishlist heart and Quick Compare triggers pinned top-right.
2. **Hero Image Arena:** Generous centered image container with white background and subtle zoom on hover (scale 1.04).
3. **Specs & Variations:** Storage pills (e.g., 128GB | 256GB | 512GB) and circular color swatches directly below the visual.
4. **Product Naming:** Two-line fixed height title in `#222222` semibold.
5. **Price Stack:** Primary red highlighted current price alongside strike-through original price and percentage save indicator.
6. **Promotion & Incentive Snippet:** Compact tag detailing trade-in subsidies or bundle gifts.
7. **Social Proof & Action:** Star rating + review count adjacent to an instant "Mua ngay" (Buy Now) red action button.

### 3. Search & Header Navigation
- **Sticky Desktop Header:** Integrates PhoneX logotype, high-volume search bar bounded by `#E5E7EB` with active red focus outline, account module, wishlist counter, and badge-indicated mini-cart.
- **Category Track:** Clean horizontal utility bar displaying dedicated phone brands (iPhone, Samsung, Xiaomi, OPPO, vivo, realme, Google Pixel, Nothing Phone) followed by high-intent shortcuts (Thu cũ đổi mới, Khuyến mãi).

### 4. Input Fields & Selectors
- Text fields utilize an inner height of 44px, bordered by `#E5E7EB` on a `#FFFFFF` fill, shifting to 1.5px `#E60012` upon active focus. Placeholder text remains legible at `#9CA3AF`.

### 5. Sticky Mobile Commerce Bar
- Persistent bottom navigation bar on mobile screens containing 5 tactile touch points: Trang chủ (Home), Danh mục (Categories), Tìm kiếm (Search), Yêu thích (Wishlist), and Tài khoản (Account).
- Product detail views replace this bar with an immediate, high-priority sticky "Mua ngay" banner displaying current price and a full-width red checkout button.