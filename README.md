# LayoutBundle


## Description:

LayoutBundle help users to build layout fast and provides the support for fully customized multi-themes.
This bundle provides the region and blocks to build compact layout.

## Features.

LayoutBundle Provides the following features:

1. Regions and blocks supported
2. Xml based layout config file
3. Multi-theme supported
4. Inline block support
5. Fully extendable



## Installation.

Using composer

``` bash
$ composer require kamran/layout-bundle dev-master
```
Add the KamranLayoutBundle to your AppKernel.php file:

```
new Kamran\LayoutBundle\KamranLayoutBundle();
```


## Configurations.

1. Configure the `kamran_layout` service in your config:
	
		# application/config/config.yml
			kamran_layout:
    			_theme_bundle: 'AppFrontBundle'
    			_theme_namespaces: ['App','Systems']




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




## Learning Links:

1. [Concept behind LayoutBundle](http://kamranshahzad.github.io/blog/the-concept-behind-layoutbundle.html)



## Todo list.

1. Theme assets management
2. Custom and customizedable/extendable header and footer
3. User roles and permissions
4. Dashboard/Widgets
5. Dynamic head titles
6. Head meta tags
7. Head share tags
8. Helper commands


## Reporting an issue or feature request.

Issues and feature requests are tracked in the 
[Github issue tracker](https://github.com/kamranshahzad/LayoutBundle/issues).


How to contribute?
------------------------------------
The contribution for this bundle for public is open, anybody could help me to participate 
bugs, documentation and code.



ThemeBundle
--------------
The themes directories will placed in ThemeBundle. You can used any bundle for this purpose.
here is the theme directory structure.
->[ThemeBundle]->Resources->views->themes



## License.
This software is licensed under the MIT license. See the complete license file in the bundle:
```
Resources/meta/LICENSE
```
[Read the License](https://github.com/kamranshahzad/LayoutBundle/blob/master/Resources/meta/LICENSE)