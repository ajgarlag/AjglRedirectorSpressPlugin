AjglRedirectorSpressPlugin
==========================

The AjglRedirectorSpressPlugin component allows you to seamlessly specify multiple redirections URLs for your pages and posts with [Spress]

[![Latest Stable Version](https://poser.pugx.org/ajgl/redirector-spress-plugin/v/stable.png)](https://packagist.org/packages/ajgl/redirector-spress-plugin)
[![Latest Unstable Version](https://poser.pugx.org/ajgl/redirector-spress-plugin/v/unstable.png)](https://packagist.org/packages/ajgl/redirector-spress-plugin)
[![Total Downloads](https://poser.pugx.org/ajgl/redirector-spress-plugin/downloads.png)](https://packagist.org/packages/ajgl/redirector-spress-plugin)
[![Montly Downloads](https://poser.pugx.org/ajgl/redirector-spress-plugin/d/monthly.png)](https://packagist.org/packages/ajgl/redirector-spress-plugin)
[![Daily Downloads](https://poser.pugx.org/ajgl/redirector-spress-plugin/d/daily.png)](https://packagist.org/packages/ajgl/redirector-spress-plugin)
[![License](https://poser.pugx.org/ajgl/redirector-spress-plugin/license.png)](https://packagist.org/packages/ajgl/redirector-spress-plugin)


Installation
------------

To install the latest stable version of this component, open a console and execute the following command:
```
$ composer require ajgl/redirector-spress-plugin
```


Usage
-----

Add a `redirect_from` attribute to an item with the old URL path that you want to redirect to the current item URL.

```yml
---
layout: "post"
title: "Welcome to Spress"
redirect_from: /old/url.html
---
```

### Clean URLs

If the `redirect_from` value ends with a slash `/`, it will generate a directory with an index.html file inside.

```yml
---
layout: "post"
title: "Welcome to Spress"
redirect_from: /old/url/
---
```

This will generate rederize the redirect page in `/old/url/index.html`.

### Multiple redirections

You can add multiple `redirect_from` values if you want to generate multiple redirections..

```yml
---
layout: "post"
title: "Welcome to Spress"
redirect_from:
  - /old/url/
  - /other/old/url/
---
```



License
-------

This component is under the MIT license. See the complete license in the [LICENSE] file.


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker].


Author Information
------------------

Developed with ♥ by [Antonio J. García Lagar].

If you find this component useful, please add a ★ in the [GitHub repository page] and/or the [Packagist package page].

[Spress]: http://spress.yosymfony.com/
[LICENSE]: LICENSE
[Github issue tracker]: https://github.com/ajgarlag/AjglRedirectorSpressPlugin/issues
[Antonio J. García Lagar]: http://aj.garcialagar.es
[GitHub repository page]: https://github.com/ajgarlag/AjglRedirectorSpressPlugin
[Packagist package page]: https://packagist.org/packages/ajgl/redirector-spress-plugin
