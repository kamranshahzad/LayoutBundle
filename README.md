# LayoutBundle
===================

LayoutBundle using symfony2

Installation
------------

Using composer

```
	composer require kamran/layout-bundle dev-master

```
Then add in AppKernel.php

``` php
// ...other bundles ...
$bundles[] = new Kamran\LayoutBundle\KamranLayoutBundle();
```
Done.


How to use?
--------------
After installing LayoutBundle, now you need to create a directory for themes.
You can placed your themes directory in any Bundle.
```
	[AnyBundle]->Resources->views->themes
```


ThemeBundle
--------------
The themes directories will placed in ThemeBundle. You can used any bundle for this purpose.
here is the theme directory structure.
->[ThemeBundle]->Resources->views->themes




Twig
--------------

``` twig
```
