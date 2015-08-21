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
All themes will placed inside any bundles 'view' directory.
Create a directory with themes
```
	[AnyBundle]->Resources->views->themes
```

CREATE TEMPLATE FILE
create templte files, and add regions and inline blocks in that template.
How to add region:
```
{{ region('tabmenus') }}
```

How to add inline block in template file.
```
{{ inlineblock('notification-menu') }}
```

How to add blocks from bundles?
For adding blocks from bundles you create a config file in that bundles.
Like you want to add Blocks from FrontBundle, you create the file:
[BundleName]Bundle--> Resorces--> config--> [BundleName]Bundle_layout.xml

'_layout' is postfix for config file. with all lower letters.
In our example, the config file will frontbundle_layout.xml.
Here is the bundles config code:
```
<layout>

    <inlineblocks>
        <sidemenus template="sidemenus.html.twig">\Cogilent\FrontBundle\Helper\Blocks::sideMenu</sidemenus>
        <notification-menu template="notifications-menu.html.twig">\Cogilent\FrontBundle\Helper\Blocks::notificationMenu</notification-menu>
    </inlineblocks>

    <regions>
        <tabmenus>
            <tabmenu-admin role="ROLE_ADMIN" template="sidemenus.html.twig">\Cogilent\FrontBundle\Helper\Blocks::sideAdminMenu</tabmenu-admin>
            <tabmenu-user role="ROLE_USER" template="sidemenus.html.twig">\Cogilent\FrontBundle\Helper\Blocks::sideUserMenu</tabmenu-user>
        </tabmenus>
        <sidebar>
            <front_links rule="/" template="front-sidebar.html.twig">FOOTER_CLASS</front_links>
        </sidebar>
    </regions>

</layout>
```
There are two main blocks of the bundle config file.
One is inlineblocks, that inculdes the inline blocks in template.
The other one is regions, in every region you can add any no of blocks, with unique names.
Every block have two attributes role and template.
Role: In this case your Symfony2 authendication must be enables and you have role.
If you assign any role to a block like ROLE_ADMIN that means this block is only visible for that role.




Learning Links:
------------------------------------




Todo list:
------------------------------------
** Assets management
** Custom and customizedable Header and footer
** Roles and Permissions
** Dashboard
** Dynamic Titles
** Meta tags
** Share Tags
** Covert Commands



How to contribute?
------------------------------------
The contribution for this bundle for public is open, anybody could help me to participate 
bugs, documentation and code.



ThemeBundle
--------------
The themes directories will placed in ThemeBundle. You can used any bundle for this purpose.
here is the theme directory structure.
->[ThemeBundle]->Resources->views->themes


Twig
--------------

``` twig
```
