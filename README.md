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


## Todo list.

1. Theme assets management
2. Custom and customizedable/extendable header and footer
3. User roles and permissions
4. Dashboard/Widgets
5. Dynamic head titles
6. Head meta tags
7. Head share tags
8. Helper commands


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

	* `_theme_bundle` : Your theme bundle with namespace.
	* `_theme_namespaces` : Add bundles namespaces for collect blocks for theme regions

2. The themes directories will placed in AppFrontBundle. Here is directory tree.
	
	* `themes` All themes will place inside this directory

```
	[AppFrontBundle]->Resources->views->themes
```


## Themes Configuration file

For handling themes you need to create a theme configuration file with name of 'layouts.xml' inside
`themes` directory:

```
    [AppFrontBundle]->Resources->views->themes->layouts.xml
```

In `layouts.xml` file you can define your theme rules. Here is the structure of `layouts.xml` file:

```xml
<themes>
    <theme name="bluestar">
        <layouts url="/" template="default.html.twig" >
            <templates>
                <index url="/" template="front.html.twig"></index>
                <about url="/about" template="content.html.twig" ></about>
                <terms url="/terms-and-conditions" template="content.html.twig"></terms>
            </templates>
        </layouts>
    </theme>
</themes>    
```

1. `<themes>` : This is main tag of layouts.xml file. All themes will wrap in this tag.
2. `<theme>`  : This tag have one attribute that is theme name, like
    
    ```
        [AppFrontBundle]->Resources->views->themes->bluestar
    ```
3. `<layouts>` : This tag have two attributes:
    * `url`: This attribute defines the prefix of url like '/', this means all root level urls will go inside this tag.
    * `template`: This is the default template from your theme, if you leave to define the template attribute blow, your theme will use default template.     
4. `<templates>` : All url rules will come inside this tag.
    * `<any_unique_tagname>` : This tag is url rule for your theme template, it have two attributes:
        * `url` : Your url
        * `template` : template will used for defined url


#### Nested Urls in layouts.xml

Here are example layouts.xml file for nested urls

```xml
<themes>
    <theme name="bluestar">
        <layouts url="/" template="default.html.twig" >
            <templates>
                <login url="/login"></login>
                <dashboard url="/" template="dashboard.html.twig"></dashboard>
                <contact url="/contact" template="contact.html.twig" >
                    <templates>
                        <add url="/add"></add>
                        <edit url="/modify" ></edit>
                        <search url="/search">
                            <templates>
                                <show url="/show"></show>
                            </templates>
                        </search>
                        <remove url="/remove" ></remove>
                    </templates>
                </contact>
                <help url="/help"></help>
            </templates>
        </layouts>
    </theme>
</themes>    
```

#### Use multiple themes 

Let's suppose, you have more than one theme. This is the way how you implement these themes.

```
    [AppFrontBundle]->Resources->views->themes->bluestar_frontend
    [AppFrontBundle]->Resources->views->themes->bluestar_backend
```

```xml
<themes>
    <theme name="bluestar_frontend">
        <layouts url="/" template="default.html.twig" >
            <templates>
                <index url="/" template="front.html.twig"></index>
                <about url="/about" template="content.html.twig" ></about>
                <terms url="/terms-and-conditions" template="content.html.twig"></terms>
            </templates>
        </layouts>
    </theme>
    <theme name="bluestar_backend">
        <layouts url="/administrator" template="default.html.twig" >
            <templates>
                <login url="/login"></login>
                <dashboard url="/" template="dashboard.html.twig"></dashboard>
                <contact url="/contact" template="contact.html.twig" >
                    <templates>
                        <add url="/add"></add>
                        <edit url="/modify" ></edit>
                        <search url="/search">
                            <templates>
                                <show url="/show"></show>
                            </templates>
                        </search>
                        <remove url="/remove" ></remove>
                    </templates>
                </contact>
                <help url="/help"></help>
            </templates>
        </layouts>
    </theme>
</themes>    
```

## Themes Templates

In your themes you can define parent templates using url rules which you define in `layouts.xml` file.
Here is a simple theme parent template:

```
    [AnyBundle]->Resources->views->themes->bluestar->default.html.twig
```

```twig
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Themes default page</title>
</head>
<body>

    <!--body-->
    {% block body %}{% endblock %}
    <!--@body-->

</body>
</html>
```

Theme parent template is ready, now you need to implement this template with your project. 
For this you need to add this line in your child template :

```twig
{% extends themes %}

{% block body %}
    .... child content
{% endblock %}

```


## Template Regions & Blocks

A theme templates may have many regions and inline blocks. Region is the collection of blocks. 
In `layouts.xml` file you defined all regions which you want to use in your theme template.


#### Define regions in layouts.xml

```xml
<themes>
    <theme name="undp_frontend">
        <layouts url="/" template="main-default.html.twig" >
            <regions>
                <sidebar></sidebar>
                <header></header>
            </regions>
            <templates>
                <index url="/" template="front.html.twig"></index>
                <about url="/about"></about>
                <terms url="/terms-and-conditions"></terms>
            </templates>
        </layouts>
    </theme>
</themes>    
```

`<regions>` : All regions will define in this tag.
    * `<unique_regionname>` : Define regions



#### Use regions in template file

```twig
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Theme template</title>
</head>
<body>

<div class="header">
    {{ region('header') }}
</div>

<div class="left">
    {{ region('sidebar') }}
</div>

<div class="content">
    <!--body-->
    {% block body %}{% endblock %}
    <!--@body-->
</div>

</body>
</html>
```


#### Add blocks in regions

In different bundles you can create any number of blocks for theme regions.

1. Every bundle which share blocks & inline blocks with themes, thats need to create a 
sub configuration file. Here is the pattern for creating sub configuration file
    * `[bundlename]_layout.xml` : The file name starts with bundlename as prefix. Use lowercase letter for file name.

    ```
        [FrontBundle]->Resources->views->config->[frontbundle]_layout.xml
    ```

2. Here is the structure of '[frontbundle]_layout.xml' file.

```xml
<layout>
    <regions>
        <header>
            <logo template="logo.html.twig"></logo>
            <topmenu template="topmenu.html.twig"></topmenu>
        </header>
        <sidebar>
            <sidemenu template="sidemenu.html.twig"></sidemenu>
        </sidebar>
    </regions>
</layout>    
```

3. Create blog template file: All block template are placed in blocks directory.
    
    ```
        [FrontBundle]->Resources->views->blocks->logo.html.twig
        [FrontBundle]->Resources->views->blocks->topmenu.html.twig
        [FrontBundle]->Resources->views->blocks->sidemenu.html.twig
    ```
    block template example:

    ```twig
        <div class="topmenu">
            .... block content
        </div>    
    ```









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




## Usefull links:

1. [Concept behind LayoutBundle](http://kamranshahzad.github.io/blog/the-concept-behind-layoutbundle.html)


## Reporting an issue or feature request.

Issues and feature requests are tracked in the 
[Github issue tracker](https://github.com/kamranshahzad/LayoutBundle/issues).


How to contribute?
------------------------------------
The contribution for this bundle for public is open, anybody could help me to participate 
bugs, documentation and code.



## License.
This software is licensed under the MIT license. See the complete license file in the bundle:
```
Resources/meta/LICENSE
```
[Read the License](https://github.com/kamranshahzad/LayoutBundle/blob/master/Resources/meta/LICENSE)