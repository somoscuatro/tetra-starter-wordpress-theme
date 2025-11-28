# TetraStarter WordPress Theme

Welcome to the official repository of the TetraStarter theme, designed
specifically for WordPress projects.

This theme leverages the power of [Advanced Custom Fields
(ACF)](https://www.advancedcustomfields.com/) to craft custom Gutenberg Blocks,
integrates [Twig](https://twig.symfony.com/) via
[Timber](https://upstatement.com/timber/) for efficient template management, and
utilizes [Tailwind CSS](https://tailwindcss.com/) for its modern and responsive
styling capabilities. Additionally, it incorporates [Laravel
Mix](https://laravel-mix.com/), a wrapper for easily defining
[Webpack](https://webpack.js.org/) build steps and efficiently compile assets.
Furthermore, the theme supports [Storybook](https://storybook.js.org/), a tool
for developing UI components in isolation, which enhances the design system and
facilitates a more interactive component library.

> [!IMPORTANT]
> This is an opinionated starter theme for WordPress created by [somoscuatro team](https://somoscuatro.es).
> While PRs are welcome, this is designed to fit the needs of our team.

**Key Features:**

- Custom Gutenberg Blocks: Build unique and complex content layouts with ease
	using ACF.
- Twig Templating: Write maintainable and cleaner code with the power of Twig
	and Timber.
- Responsive Design: Achieve a consistent look across all devices with Tailwind
	CSS.
- TypeScript Integration: Enhance code reliability and maintainability with
	strong typing through TypeScript support.
- Assets Compilation: Simplify your assets management with Laravel Mix's
	straightforward Webpack wrapper.
- Storybook Integration: Develop and test UI components in isolation and
	checking them using Storybook interactive environment.

## Prerequisites

To ensure a seamless installation and optimal functionality of this theme,
please ensure that your system meets the following requirements:

- [PHP](https://www.php.net/): Version 8.4 or higher
- [Composer](https://getcomposer.org/): Version 2.9 or higher
- [Node.js](https://nodejs.org/en): Version 24 or higher
- [bun](https://bun.sh/): Version 1.3 or higher
- [GitHub CLI](https://cli.github.com/): Version 2.83 or higher (optional, necessary
	for [deployment scripts](#automated-deployment) to work)

### Quick Start with Docker

For those looking to quickly and effortlessly set up a local WordPress
environment, we recommend exploring our
[tetra-docker-wordpress](https://github.com/somoscuatro/tetra-docker-wordpress)
repository. It provides a Docker-based solution to get your WordPress instance
up and running in no time.

## Setup

Follow these instructions to get the TetraStarter WordPress Theme up and running on
your WordPress site:

1. **Clone the Repository:**

	 Begin by cloning the repository into your WordPress themes directory. Open
	 your terminal, navigate to the `wp-content/themes` folder of your WordPress
	 installation, and run the following command:

	 `git clone git@github.com:somoscuatro/tetra-starter-wordpress-theme.git`

	 After cloning, switch to the theme's directory:

	 `cd tetra-starter-wordpress-theme`
1. **Install Dependencies:**

	 Install the required Node.js and PHP dependencies by running:

	 `bun install && composer install`

	 This will set up all necessary packages for the theme to function correctly.
1. **Build Assets:**

	 Compile the static assets such as CSS and JavaScript files with:

	 `bun run build`

	 This command processes your assets using Laravel Mix and prepares them for
	 production use.
1. **Activate the Theme:**

	 To activate the theme on your WordPress site, you can use the WP CLI with the
	 following command:

	 `wp theme activate tetra-starter-wordpress-theme`

	 Alternatively, you can activate the theme manually by going to the WordPress
	 admin dashboard, navigating to _Appearance_ > _Themes_, and clicking the
	 _Activate_ button for the TetraStarter WordPress Theme.

Enjoy your new theme! To learn how to further customize and extend it, keep on
reading.

## Understanding the Theme Structure

Our objective is to harness modern Object-Oriented Programming (OOP) practices
in PHP, adhering to recommended coding standards. This approach ensures a
well-organized and readable codebase without compromising on performance.

We structure our code by grouping related functionalities within classes. This
modular design promotes clean and maintainable code. To streamline the inclusion
of these classes, we implement class autoloading (see section [Class
Autoloading](#class-autoloading)).

Additionally, we utilize [methods
attributes](https://www.php.net/manual/en/class.attribute.php) to manage
WordPress hooks efficiently. This method allows us to keep our actions and
filters handlers organized and easily traceable within the class context. See
section [WordPress Hooks Usage](#wordpress-hooks-usage).

### Directories Organizations

The TetraStarter WordPress Theme is organized into several directories, each
serving a specific purpose in the theme's architecture:

- `assets`: This directory houses all the static resources used by the theme.
	- `fonts`: Contains custom fonts files. See [How to Customize
		Fonts](#how-to-customize-fonts) section.
	- `images`: Stores static images that are integral to the theme's
		construction. Place assets such as favicons or any other images that you
		prefer to manage directly within the theme, rather than through the WordPress
		Media Uploader, here.
	- `scripts`: Holds the JavaScript files that add interactive functionality to
		your theme.
	- `styles`: Contains all the Tailwind CSS and custom style files that define
		the visual appearance of your theme.
- `languages`: This directory contains the translation files. See
	[Translations](#translations) section.
- `patches`: Sometimes, third-party libraries require modifications to work
	seamlessly with our theme. This directory contains such modifications, or
	"patches." For example, we include a patch to ensure [WP CLI
	Stubs](https://github.com/php-stubs/wp-cli-stubs) are compatible with PHP 8.2.
	These patches are automatically applied when you run `composer install`. For
	details on how these patches are implemented, refer to the `post-install-cmd`
	script within the `composer.json` file.
- `src`: Serving as the primary namespace for the theme, this directory contains
	all the core logic, neatly organized into distinct classes.
	- `attributes`: This subdirectory houses the mechanism for registering
		WordPress hooks using PHP method attributes. Within, the `hooked-classes.php`
		file enumerates classes that have methods designed to handle WordPress hooks.
	- `blocks`: Custom Gutenberg blocks are stored here, each in its own dedicated
		folder for better organization. See [How to Create Gutenberg
		Blocks](#how-to-create-gutenberg-blocks) section.
	- `cli`: This is where we implement custom WP-CLI commands, extending the
		command-line interface capabilities for WordPress.
	- `custom-post-types`: Definitions and configurations for WordPress Custom
		Post Types are located in this subdirectory. See [How to Add Custom Post
		Types](#how-to-add-custom-post-types) section.
	- `custom-taxonomies`: Similarly, this subdirectory is dedicated to the
		definition of WordPress Custom Taxonomies. See [How to Add Custom
		Taxonomies](#how-to-add-custom-taxonomies) section.
	- `helpers`: A collection of generic utility methods implemented as PHP Traits
		can be found here. An example includes a method for retrieving the last
		modified time of a file.
- `templates`: This directory is home to the Twig templates used by the theme.
	- `parts`: Here, you'll find reusable template partials.

### Class Autoloading

The `autoloader.php` file is responsible for implementing a class autoloader
that adheres to [the WordPress naming conventions for classes and
files](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/#naming-conventions).

Additionally, this autoloader invokes the Composer autoloader, guaranteeing that
any third-party dependencies are also loaded automatically.

### Dependency Injection

The theme uses [PHP DI](https://php-di.org/) for Dependency Injection.

### WordPress Hooks Usage

We utilize [methods
attributes](https://www.php.net/manual/en/class.attribute.php) to manage
WordPress hooks efficiently. This approach allows us to keep our actions and
filters handlers organized and easily traceable within the class context.

Our inspiration came from an insightful article by Markus Kober: [How to
register WordPress hooks with PHP attributes: A step-by-step
guide](https://marcuskober.com/registering-wordpress-hooks-effectively-with-php-attributes/).

To use method attributes in your class methods, follow these steps:

1. **Define Your Class Method:**

	 Write the method that you intend to use as a hook handler. For instance:

	 ```php
		// src/class-my-beautiful-class.php

		namespace Somoscuatro\Starter_Theme;

		class My_Beautiful_Class {

			public function my_beautiful_method(): void {
				// Your code here
			}
		}
	 ```

1. **Register the Method as a Hook Handler:**

	 Apply the method attribute to register it as a handler for a WordPress action
	 or filter. Here's how you would register a method for the `after_setup_theme`
	 action:

	 ```php
		// src/class-my-beautiful-class.php

		namespace Somoscuatro\Starter_Theme;

		use Somoscuatro\Starter_Theme\Attributes\Action;

		class My_Beautiful_Class {

			#[Action('after_setup_theme')]
			public function my_beautiful_method(): void {
				// Your code here
			}
		}
	 ```

	 Similarly, for a filter like `body_class`, you would write:

	 ```php
		// src/class-my-beautiful-class.php

		namespace Somoscuatro\Starter_Theme;

		use Somoscuatro\Starter_Theme\Attributes\Filter;

		class My_Beautiful_Class {

			#[Filter('body_class')]
			public function my_beautiful_method(array $classes): array {
				// Your code here

				return $classes;
			}
		}
	 ```

1. **Specify Priority and Accepted Arguments (Optional):**

	 You can also define the priority of the hook and the number of accepted
	 arguments like this:

	 ```php
	 #[Filter('style_loader_tag', priority: 20, accepted_args: 2)]
	 ```

	 If not explicitly stated, the default priority is set to 10, and the number
	 of accepted arguments is 1.

	 Please note that class methods linked to hooks must be public to ensure
	 WordPress can call them correctly.

1. **Register Hooked Classes in hooked-classes.php:**

	 To activate the hooked methods, you must register the class containing them
	 in the `hooked-classes.php` file. This step is essential to automatically
	 attach your methods to the specified WordPress hooks. Add your class to the
	 list as shown below:

	 	```php
			 // hooked-classes.php

			 use Somoscuatro\Starter_Theme\My_Beautiful_Class;

			 return [
				 // Other classes
				 My_Beautiful_Class::class,
			 ];
		 ```

## How to Customize Fonts

The starter theme includes two example custom fonts,
[Jost](https://fonts.google.com/specimen/Jost?query=jost) and
[Syne](https://fonts.google.com/specimen/Syne?query=syne), to demonstrate how
you can incorporate your own font choices.

To integrate your custom fonts into the theme, follow these steps:

1. **Add Your Fonts:**

	 Download your chosen fonts and place them in the `assets/fonts` directory.
	 For the best balance of efficiency and compatibility, we recommend using the
	 WOFF2 format.

1. **Preload Your Fonts:**

	 Improve your site's performance by preloading your fonts. In the
	 `templates/partials/head.twig` file, insert a preload link for each font. For
	 example:

	  ```html
		<link rel="preload" href="{{ get_static_asset('dist/fonts/my-beautiful-font.woff2') }}" as="font" type="font/woff2" crossorigin="anonymous">
		```

	 For a deeper understanding of preloading strategies, consider reading [this
	 informative blog post by
	 Google](https://web.dev/articles/codelab-preload-web-fonts).

1. **Define Font-Face:**

	 Declare your font in `assets/styles/fonts.css` using the `@font-face` rule to
	 specify the font family, style, weight, and file source. Here's an example:

	  ```css
		@supports (font-variation-settings: normal) {
			@font-face {
				font-family: 'My Beautiful Font';
				font-style: normal;
				font-weight: 300 700;
				font-display: swap;
				src: url(/wp-content/themes/tetra-starter-wordpress-theme/dist/fonts/my-beautiful-font.woff2) format("woff2");
			}
		}
		```

1. **Configure Tailwind:**

	 Let Tailwind CSS know about your new font by updating the
	 `tailwind.config.js` file. Add your font to the `extend` section under
	 `fontFamily`. Here's how you can do it:

	 ```js
	 extend: {
		 fontFamily: {
			 'myBeautifulFont': ['My Beautiful Font', 'Helvetica Neue', 'Arial', 'sans-serif'],
		 },
	 }
	 ```

1. **Apply Your Font:**

	 Now you can use your custom font throughout the theme by applying the
	 Tailwind class `font-my-beautiful-font` wherever you want your font to
	 appear.

## How to Customize Color Palette

The starter theme includes a predefined color palette tailored to provide a
cohesive visual design. To personalize this palette to match your brand or
design preferences, follow these steps:

1. **Modify Tailwind Colors Palette:**

	 Update your custom color palette by adding your desired HEX codes to the
	 `tailwind.colors.json` file. This file dictates the color scheme used
	 throughout the theme via Tailwind CSS.

1. **Update ACF Color Picker Options (optional):**

	 If you wish to have your new colors available as options within the Advanced
	 Custom Fields (ACF) Color Picker, you'll need to edit the
	 `tailwind.bg-colors-safelist.json` file.

	 The contents of this file are automatically included in the Tailwind CSS
	 safelist to ensure that your custom colors are available for use in
	 Tailwind's utility classes. Additionally, these colors are utilized by [the
	 ACF
	 class](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/main/src/class-acf.php)
	 to populate the color picker options within the WordPress admin.

By customizing these JSON files, you can easily extend the theme's color palette
and ensure that your chosen colors are readily available for both your Tailwind
CSS classes and the ACF Color Picker.

## How to Create Gutenberg Blocks

To create a new Gutenberg Block using our ACF based implementation, follow the
steps outlined below:

1. **Initialize a New Block Directory:**

	 Begin by creating a new folder within the `src/blocks` directory. Name it to
	 reflect your block's purpose, such as `my-beautiful-block`.

1. **Create the ACF `block.json` File:**

	 The `block.json` file serves as the cornerstone for defining a Gutenberg
	 block's metadata. It provides essential details about the block, such as its
	 name, icon, category, and other characteristics. To gain a comprehensive
	 understanding of the `block.json` structure and its role in block creation,
	 consult [the WordPress Developer Resources page on
	 block.json](https://developer.wordpress.org/block-editor/getting-started/fundamentals/block-json/).

	 A critical attribute within `block.json` is the `renderCallback`. This
	 attribute should be set to reference the PHP class responsible for rendering
	 the block (see step 3 below).

	 Check [the block.json of the sample
	 block](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/main/src/blocks/sample/block.json)
	 included in the theme for guidance.

	 Please be aware that when naming your block, it is essential to use the
	 prefix `acf/` to ensure that Advanced Custom Fields correctly recognizes and
	 interprets your block. For example, if your block is named
	 `my-beautiful-block`, the full name in the `block.json` should be
	 `acf/my-beautiful-block`.

1. **Create the Block's Main Class:**

	 For our given example, you would create a PHP file named
	 `class-my-beautiful-block.php`. This file should define a class named
	 `My_Beautiful_Block`. This class acts as the foundation for your block's
	 functionality. It must include the `get_acf_fields` method, which is
	 responsible for specifying the ACF fields that will appear in the WordPress
	 admin interface for your block.

	 Check [the class-sample.php of the sample
	 block](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/main/src/blocks/sample/class-sample.php)
	 included in the theme for guidance.

	 You can use the ACF interface to design your custom fields group, and when
	 ready, export it as PHP code directly from the _ACF_ > _Tools_ section in
	 your WordPress dashboard. After exporting, integrate the PHP code into the
	 `get_acf_fields` method of your custom block or theme functions.

	 Remember to deactivate or delete the original field group in the ACF
	 interface. This will prevent the possibility of duplicate fields appearing
	 and ensures that your fields are managed solely through code.

	 For detailed guidance on registering your fields through PHP, read [this ACF
	 documentation
	 page](https://www.advancedcustomfields.com/resources/register-fields-via-php/).

1. **Create the Block's Template:**

	 Create your block's layout by creating a file named `template.twig`. As for
	 any other template in the theme, you can utilize Twig and Tailwind CSS in
	 block templates.

	 Within this template, you can access the ACF fields directly without the need
	 to include the block prefix. For instance, if you have a field defined with
	 the key `field_block_my_beautiful_block_heading`, it will be accessible in
	 the Twig template simply as `heading` (i.e. `<p>{{ heading }}</p>`).

To have a complete example of what explained above, have a look to [the sample
block included with the
theme](https://github.com/somoscuatro/tetra-starter-wordpress-theme/tree/main/src/blocks/sample).

### Include Block's Assets

Your block may need to include frontend assets.

To register these assets, implement a `register_assets` method within your block
class. This method will handle the registration of any scripts or styles your
block needs.

For instance, if you want to include Alpine.js, your method would look like
this:

```php
public function register_assets(): void {
  wp_register_script(
    'alpine',
    'https://unpkg.com/alpinejs@3.5.0/dist/cdn.min.js',
    array(),
    '3.5.0',
    array(
      'footer'   => false,
      'strategy' => 'defer',
    )
  );
}
```

You should enqueue your block asets them within it's `template.twig` file. Use the
Twig function `enqueue_script` to do so. For example, to enqueue Alpine.js for
your block you would write: `{{ enqueue_script('alpine') }}`.

By enqueuing the script in the template file, you guarantee that it's only
loaded when the block is actually being used, optimizing your site's
performance.

### Override Context

In certain scenarios, you might find it necessary to augment or modify the
global context of your block with additional data or to alter the information
provided by Advanced Custom Fields (ACF).

To achieve this, you should define a method within your block class and
[register it with filter](#wordpress-hooks-usage)
`{theme_prefix}_block_context`, where `{theme_prefix}` is the machine name of
your theme. This method will be responsible for receiving and processing the
block's context along with any other settings from ACF. Here's a basic outline
of how you can implement this method:

```php
#[Filter('my_beautiful_theme_block_context', accepted_args:2)]
public static function set_custom_context( array $context, array $block ): array {
  // Ensure we modify context just for this specific block.
  if ( 'acf/my-beautiful-block' !== $block['name'] ) {
    return $context;
  }

  // Manipulate the block context as you wish here.

  // Return the updated context.
  return $context;
}
```

### Export ACF Block Fields JSON

The theme includes a custom WP CLI command, `export-acf-blocks-fields`, which
allows you to export the field definitions for ACF Blocks into a JSON file. This
command is particularly useful for backing up your fields.

To learn more about the command's options and how to use it effectively, simply
run `wp export-acf-blocks-fields --help` in your terminal.

Once you have the generated JSON file for your block field group, you can easily
import it into the ACF interface to make additional modifications. Navigate to
_ACF_ > _Tools_ > _Import_ within your WordPress dashboard. From there, you can
upload the JSON file, which will seamlessly integrate your field group back into
the ACF system. This allows you to adjust and refine your fields directly
through the ACF interface with ease.

## How to Add Custom Post Types

To introduce new Custom Post Types (CPTs) to your WordPress theme, you should
create a dedicated class within the `src/custom-post-types/post-types`
directory. Ensure that the class name reflects the CPT's purpose and is
consistent with its naming convention.

Within your CPT class, it's essential to define the singular and plural labels
for the CPT. Additionally, you may want to customize various attributes of your
CPT, such as its admin dashboard icon, the features it supports (e.g., title,
editor, thumbnails), and its visibility in the WordPress REST API, among others.
These customizations can be configured in the constructor of your CPT class. The
possible arguments are those accepted by WordPress method `register_post_type`.
See [WordPress documentation for method
register_post_type](https://developer.wordpress.org/reference/functions/register_post_type/).

The theme includes [the implementation of a
CPT](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/main/src/custom-post-types/post-types/class-sample.php)
named `Sample` you can use as reference.

## How to Add Custom Taxonomies

To introduce new Custom Taxonomies to your WordPress theme, you should create a
dedicated class within the `src/custom-taxonomies/taxonomies` directory. Ensure
that the class name reflects the taxonomy purpose and is consistent with its
naming convention.

Within your taxonomy class, it's essential to define the singular and plural
labels for the taxonomy. Additionally, you may want to customize various
attributes of your taxonomy, such as its admin dashboard icon, the features it
supports (e.g., title, editor, thumbnails), and its visibility in the WordPress
REST API, among others. These customizations can be configured in the
constructor of your taxonomy class. The possible arguments are those accepted by
WordPress method `register_taxonomy`. See [WordPress documentation for method
register_post_type](https://developer.wordpress.org/reference/functions/register_taxonomy/).

The theme includes [the implementation of a
taxonomy](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/main/src/custom-taxonomies/taxonomies/class-sample-category.php)
named `Sample` you can use as reference.

## Translations

Translations file are stored in the `languages` folder.

To create the necessary .po/.mo files for your theme's supported languages, we
recommend using a tool like [POEdit](https://poedit.net/).

This theme includes translations for Catalan, Italian and Spanish.

## Performance Improvements

This theme applies several improvements to ensure top performance, implemented
in `src/class-performance.php`:

- [Possibility of preloading
	assets](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/44b164f1d500e48760bc9a10a546016bf8bb8e1a/src/class-performance.php#L57C2-L63C3).
	To use it, simply add a `-preload` suffix to your assets handle name. For
	example:

	```php
	wp_enqueue_style( 'tetra-starter-wordpress-theme-fonts-preload', $this->get_base_url() . '/dist/styles/fonts.css', false, $this->get_filemtime( 'styles/fonts.css' ) );
	```

- [Remove non-essential WordPress default
	assets](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/44b164f1d500e48760bc9a10a546016bf8bb8e1a/src/class-performance.php#L24-L45)
- [Possibility of removing unused WordPress default
	blocks](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/44b164f1d500e48760bc9a10a546016bf8bb8e1a/src/class-gutenberg.php#L51C2-L63C1)
- Selective enqueueing of custom blocks assets, as explained in section [Include
	Block's Assets](#include-blocks-assets).

## Code Standards

Our code standards adhere to the guidelines established by the WordPress
community. To ensure these standards are consistently applied, we utilize a
suite of code quality tools:

- [PHPCS (PHP CodeSniffer)](https://github.com/squizlabs/PHP_CodeSniffer)
- [ESLint](https://eslint.org/)
- [Stylelint](https://stylelint.io/)
- [Prettier](https://prettier.io/)

Additionally, we use [PHPStan](https://phpstan.org/) for static analysis,
which significantly improves our code quality by detecting bugs and potential
issues before runtime.

## Automated Deployment

This theme features a `bun run deploy` command that automates version bumping,
code pushing to GitHub, and release creation with the specified project version.
Ensure you have the [GitHub CLI](https://cli.github.com/) installed to utilize
this functionality.

If your WordPress site is on WP Engine, you may consider using our GitHub Action
for automated deployments:
[action-deploy-to-wpengine](https://github.com/somoscuatro/action-deploy-to-wpengine)

## How to Contribute

Any kind of contribution is very welcome!

Please, be sure to read our Code of Conduct.

If you notice something wrong please open an issue or create a Pull Request or
just send an email to [tech@somoscuatro.es](mailto:tech@somoscuatro.es). If you
want to warn us about an important security vulnerability, please read our
Security Policy.

## License

All code is released under MIT license version. For more information, please
refer to
[LICENSE.md](https://github.com/somoscuatro/tetra-starter-wordpress-theme/blob/main/LICENSE.md)
file.
