# LayoutBundle


## Description:

LayoutBundle help users build layout with pace and provide support for fully customized multi-themes.
This bundle provide regions(header, footer, sidebar) and blocks to build compact layout.
this bundle provide all components necesssary for layout building e.g : Regions (Header, Footer, Sidebar) and Blocks

## Features.

LayoutBundle Provides the following features:

1. Regions and blocks
2. Xml based layout config file
3. Multi-theme 
4. Inline blocks
5. Fully customizable


## Todo list.

1. Theme assets management
2. Fully customizable header and footer
3. Role/permission base layout
4. Dashboard/Widgets
5. Dynamic Page titles
6. Meta tags, Meta keywords, Meta Description
7. Social Media sharing tags
8. Quick Guide (commands list)


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

1. Add the `kamran_layout` service in symfony config:
	
		# application/config/config.yml
			kamran_layout:
    			_theme_bundle: 'AppFrontBundle'
    			_theme_namespaces: ['App','Systems']

	* `_theme_bundle` : Your theme bundle with namespace.
	* `_theme_namespaces` : Add bundles namespaces for collect blocks for theme regions

2. The themes directories will placed in AppFrontBundle. Here is directory tree.
Now create a themes directory in anyone of your bundle as specified below	
	* `themes` All themes will be placed inside this directory

```
	[YourBundleName]->Resources->views->themes
```


## Themes Configuration file

For handling themes you need to create a theme configuration file with name of 'layouts.xml' inside
`themes` directory:

```
    [YourBundleName]->Resources->views->themes->layouts.xml
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

1. `<themes>` : This is main tag of layouts.xml file. All theme tags be will wrapped in this tag. so we can have multiple themes in this layout configuration file
2. `<theme>`  : Every theme will be wrapped inside its own theme tag
    
    ```
        [YourBundleName]->Resources->views->themes->bluestar
    ```
3. `<layouts>` : Inside every theme there is a layout tag. This tag has two attributes.
    * `url`: This attribute defines the prefix of url like '/', this means all root level urls will go inside this tag.
    * `template`: This is the default template for your theme, if you leave this attribute blank then default template will be used.     
4. `<templates>` : templates tag contains all url rules tag.
    * `<any_unique_tagname>` : This tag will be a unique, it will have two attributes:
        * `url` : This url can be prefix or page url
        * `template` : The defined template name will be used. If left blank it will inherit template from parent tag


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

If you want to implement more then one theme follow the syntax below.

```
    [YourBundleName]->Resources->views->themes->bluestar_frontend
    [YourBundleName]->Resources->views->themes->bluestar_backend
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

In your themes you must define parent template using url rules. This parent template is defined in `layouts.xml` file.
Here is a simple theme parent template:

```
    [YourBundleName]->Resources->views->themes->bluestar->default.html.twig
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
Now add this line in your child template :

```twig
{% extends themes %}

{% block body %}
    .... child content
{% endblock %}

```


## Template Regions & Blocks

A theme templates may have many regions(Header, Footer, Sidebar) and inline blocks. Region is collection of blocks. 
All regions that are to be used in theme are defined in `layouts.xml` file.


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

`<regions>` : All regions are defined in this tag.
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

A region consists of many blocks. You can define any number of blocks in 'layout.xml'

1. A sub configuration file is created for every bundle that is included in the layout
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


## Use inline block in template file

If you want to insert a block direct in theme template file, then you can use inline block option.

1. Regiter a inline block in '[frontbundle]_layout.xml' file. 

```xml
<layout>
    <inlineblocks>
        <loginform template="sidemenus.html.twig"></loginform>
    </inlineblocks>
    <regions>
        <header>
            <logo template="logo.html.twig"></logo>
            <topmenu template="topmenu.html.twig"></topmenu>
        </header>
    </regions>
</layout>    
```
    `<inlineblocks>` : All regions are defined in this tag.
        * `<unique_inlineblock>` : Define your bundle inline blocks for theme.


2. Use inline block in theme template.

```twig
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Theme template</title>
</head>
<body>

    {{ inlineblock('loginform') }}

<div class="content">
    <!--body-->
    {% block body %}{% endblock %}
    <!--@body-->
</div>

</body>
</html>
```        


## Passing data to block templates

1. If you want to pass some data to your block, then you need to pass a static function which returns the data.

```php
class FrontHelper{
    public static function getMenuOption(){
        return array(
            'menu'=>array(
                'home'=> array(
                    'label'=>'Home',
                    'link'=> 'front_index',
                ),
                'user'=> array(
                    'label'=>'Users',
                    'link'=> 'user_index',
                ),
                'organization' => array(
                    'label' => 'Organization',
                    'link' => 'organizations_index',
                ),
            )
        );
    }
}
```

2. Add data class into your block configuration file.
    ```
        [FrontBundle]->Resources->views->config->[frontbundle]_layout.xml
    ```
    
```xml
    <layout>
        <regions>
            <header>
                <topmenu template="topmenu.html.twig">\Namespace\FrontBundle\Helper\FrontHelper::getMenuOption</topmenu>
            </header>
        </regions>
    </layout>    
```

3. Block template `topmenu.html.twig`

```xml
<!--nav-->
<ul id="large-nav" class="">
{% for k,v in menu %}
    <li class="">
        <a href="{{ path(v.link) }}">
                <span>{{ v.label }}</span>
        </a>
    </li>
{% endfor %}
</ul>
<!--@nav-->
```



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