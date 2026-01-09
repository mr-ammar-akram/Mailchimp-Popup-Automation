# Mailchimp Popup Automation (WordPress)

## Overview
Mailchimp Popup Automation is a lightweight WordPress plugin designed to solve common UX issues when using popup-based Mailchimp signup forms.

It prevents repeat popups after successful signup and automatically triggers a thank-you popup—without modifying third-party plugin files.

---

## Key Benefits
- Improves conversion flow
- Eliminates redundant popups
- Works with AJAX Mailchimp forms
- Fully configurable via WordPress admin
- Agency-safe and reusable

---

## Requirements
- WordPress 5.5+
- WP Popup Plugin
- Mailchimp for WordPress (MC4WP)

---

## Installation
1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin
3. Go to **Settings → Mailchimp Popup Automation**

---

## Configuration
### Settings Options
- **Enable Subscription Popup Logic**
  Controls Mailchimp signup detection and popup suppression

- **Enable Thank-You Popup**
  Automatically triggers thank-you popup after successful signup

- **Subscription Popup ID**
  Target a specific popup (example: `spu-53`)

---

## Required Markup
Add a hidden thank-you trigger anywhere on the site:

```html
<div class="thankyou-popup"></div>
