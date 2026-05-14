![GitHub release](https://img.shields.io/github/v/release/willderazevedo/simple-glossary)
![License](https://img.shields.io/github/license/willderazevedo/simple-glossary)

# Simple Glossary

An extremely simple WordPress plugin that transforms specific words from your content into interactive popovers.

No indexing.
No automatic glossary pages.
No global scanning.
No unnecessary overhead.

Just a simple text-based glossary.

---

## Purpose

Most glossary plugins for WordPress try to do everything:

- term pages
- internal SEO
- automatic indexes
- archive pages
- global detection
- analytics
- complex shortcodes
- widgets
- builders

Simple Glossary takes the opposite approach.

It only:

1. searches for specific words in the content
2. transforms those words into links
3. displays a popover with the term description

Nothing more.

---

## Features

- Custom Post Type for terms
- Categories for organization
- Bootstrap popovers
- Optional automatic content injection
- Configurable wrapper class
- No dependency on builders
- No automatic glossary pages
- No unnecessary URL generation
- Lightweight and simple

---

## Installation

1. Upload the plugin to:

/wp-content/plugins/simple-glossary

2. Activate it from the WordPress admin panel.

3. Go to:

Settings → Simple Glossary

4. Configure:
   - Wrapper class
   - Auto injection

---

## Usage

### Automatic Mode

Enable:

Auto Injection

The plugin will automatically wrap the `the_content` output with:

<div class="glossary-wrapper">

or with your custom configured wrapper class.

---

### Manual Mode

Disable auto injection and manually add:

<div class="glossary-wrapper">
    Your content here
</div>

or:

<div class="my-custom-class">
    Your content here
</div>

Then configure this class inside the plugin settings.

---

## Creating Terms

After activating the plugin, a new menu will appear:

Glossary

Create a new term:

- Title → detected word
- Content → description shown inside the popover

Example:

### Title

API

### Content

Application Programming Interface

---

## How It Works

When the plugin finds the word:

API

inside the monitored content, it automatically transforms it into:

<a class="term-link">API</a>

Hovering the term will display a popover.

---

## Structure

simple-glossary/
├── assets/
│ ├── main.js
│ └── style.css
├── libs/
│ ├── bootstrap/
│ └── he/
└── simple-glossary.php

---

## Settings

### Wrapper Class

CSS class used to identify where the plugin should search for terms.

Default:

glossary-wrapper

---

### Auto Injection

When enabled, the plugin automatically wraps the rendered `the_content` output.

---

## Plugin Philosophy

The goal is to keep the plugin:

- simple
- predictable
- lightweight
- easy to modify
- free from invasive automations

---

## Requirements

- WordPress 5+
- PHP 7.4+

---

## 💖 Support This Project

If you like this project, consider making a donation to support development.

[![Sponsor via GitHub Sponsors](https://img.shields.io/badge/Sponsor-GitHub-blue?style=flat&logo=github)](https://github.com/sponsors/willderazevedo)
