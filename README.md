# Lao Super Lottery Theme (v1.0.0)

Production-ready WordPress theme for **หวยลาวซุปเปอร์.com** focused on informational content: lottery results, historical overview, articles, and FAQ.

## 1) Install as ZIP in WordPress
1. In repo root, create zip:
   ```bash
   cd wp-content/themes
   zip -r lao-super-lottery-1.0.0.zip lao-super-lottery
   ```
2. Open WordPress Admin → **Appearance → Themes → Add New → Upload Theme**
3. Upload `lao-super-lottery-1.0.0.zip`
4. Activate theme

## 2) Theme settings (WP Admin)
Open **Lao Super Theme** menu:
- Branding
- Homepage
- Lottery Result API
- SEO Settings
- On-page Content
- Mobile Menu
- Ads / CTA
- Performance
- Custom Code

All front-end text can be managed from settings and WP content editor.

## 3) API setup
In **Lottery Result API** section:
- `API Endpoint`: full URL that returns JSON
- `API Key`: optional, stored server-side in WP options
- `Timeout`: request timeout
- `Fallback*`: fallback dataset used when API fails

Supported response:

```json
{
  "date": "2026-04-24",
  "name": "หวยลาวซุปเปอร์",
  "results": {
    "four_digits": "1234",
    "three_digits": ["123", "456"],
    "two_digits": ["12", "34"]
  }
}
```

Implementation includes `wp_remote_get()`, timeout, error handling, and transient cache.

## 4) Available shortcodes
- `[lao_super_result]`
- `[lao_super_history]`
- `[lao_super_faq]`

## 5) SEO features
- Meta description + Open Graph tags from settings
- JSON-LD schema:
  - Organization
  - WebSite
  - BreadcrumbList
  - Article
  - FAQPage
- Breadcrumb output in theme templates

## 6) Performance features
- Lazy-load image handling in content
- Optional deferred theme JS
- Preload logo/hero image URLs
- Disable WP emoji scripts/styles
- Safe asset enqueue without jQuery dependency

## 7) Security controls
- Sanitized settings inputs
- Escaped output in templates
- `current_user_can()` checks in admin page
- WordPress settings nonce (`settings_fields`)
- API key not rendered on frontend

## 8) Post-install checklist
- [ ] Set site title/tagline
- [ ] Configure menu in Appearance → Menus
- [ ] Enter API endpoint and key
- [ ] Fill fallback values
- [ ] Configure SEO title/description/OG image
- [ ] Add FAQ JSON
- [ ] Create homepage and set as static front page
- [ ] Test mobile menu and result shortcodes
- [ ] Validate schema in Rich Results Test
- [ ] Verify Core Web Vitals using PageSpeed Insights

## 9) Policy & compliance notes
- Keep content informational only; do not guarantee winning outcomes
- Avoid language that encourages illegal gambling
- Provide clear disclaimer and responsible-use messaging
- Prioritize unique, useful analysis content to align with Google Helpful Content principles
