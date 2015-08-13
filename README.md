# LayoutBundle
===================

LayoutBundle using symfony2

Installation
------------

Add requirements to composer.json:

``` json
{
  "require" : {
  }
}
```

ThemeBundle
--------------
The themes directories will placed in ThemeBundle. You can used any bundle for this purpose.
here is the theme directory structure.
->[ThemeBundle]->Resources->views->themes


Configurations
--------------

Register `ApnetAsseticImporterBundle` and `ApnetLayoutBundle` bundles in the `AppKernel.php` file

``` php
// ...other bundles ...
$bundles[] = new Kamran\LayoutBundle\KamranLayoutBundle();
```

Twig
--------------

``` twig
```
