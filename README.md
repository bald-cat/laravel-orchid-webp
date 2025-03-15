# WebP Converter for Orchid Admin Panel

![Packagist Version](https://img.shields.io/packagist/v/vendor/package-name)
![License](https://img.shields.io/packagist/l/vendor/package-name)
![Downloads](https://img.shields.io/packagist/dt/vendor/package-name)

This package provides an easy way to convert images to WebP format within the Orchid Admin Panel on Laravel.

## Features

- Conversion of uploaded images to WebP format.
- Automatic conversion using event.
- Seamless integration with the Orchid Admin Panel.
- Configurable settings for image quality.
- Supports multiple image formats (JPEG, PNG, GIF).

## Installation

Require the package via Composer:

```sh
composer require baldcat/orchid-webp
```

## Configuration

Publish the package configuration:

```sh
php artisan vendor:publish --tag=webp-config
```

You can then configure the settings in `config/orchid-webp.php`.



