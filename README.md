# ACF Filters Field

This is a simple WordPress plugin that adds a a new type of ACF field; filter-field. This doesn't do much by itself, but combined with custom WP_Queries this provides a very flexible way of adding different "collections" into your pages. The main purpose is to create a single layout/block etc. that you can dynamically use in different places. For example, you could show blog posts on one page and news on another without the need of defining multiple field groups.

TLDR; this is sort of ACF interface for WP_Query.

## Requirements
* WordPress 5.5.0 on newer
* PHP 7.2 or newer
* Advanced Custom Fields 5.0 or newer
* (optional) Composer
    * You can install this wihtout composer too, but thats on you

## Installation
1. Use (Composer-Dropin-Installer)[https://github.com/Koodimonni/Composer-Dropin-Installer] to define your installer paths
2. Add this repository;
    ```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Urbanproof/acf-filters.git"
        },
    ],
    ```
3. And require the package; `composer require urbanproof/acf-filters`

## TODO:
* This documentation
    * What this does
    * How it looks
    * How to use
    * Example with WP_Query
* Internationalization
* More options:
    * limits
    * exclusions
    * search
    * author
