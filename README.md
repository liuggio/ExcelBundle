Symfony2 Excel bundle
============
This Bundle permit to create easly Excel object.

## INSTALLATION

1. Add the following entry to ``deps`` the run ``php bin/vendors install``.

``` yaml 
[n3bStreamresponse]
    git=https://github.com/liuggio/Symfony2-StreamResponse.git
	target=n3b/src/n3b/Bundle/Util/HttpFoundation/

[phpExcel]
    git=https://github.com/liuggio/PHPExcel.git
	target=phpexcel/lib/

[liuggioExcelBundle]
    git=http://github.com/liuggio/ExcelBundle.git
    target=/bundles/liuggio/ExcelBundle
```

2. Register the bundle in ``app/AppKernel.php``


    $bundles = array(
        // ...
        new liuggio\ExcelBundle\liuggioExcelBundle(),
    );


3. Register namespace in ``app/autoload.php``


     $loader->registerNamespaces(array(
         // ...
         'liuggio'              => __DIR__.'/../vendor/bundles',
     ));


4. Register the prefix for the library

     $loader->registerPrefixes(array(
         'Twig_Extensions_' => __DIR__.'/../vendor/twig-extensions/lib',
         'Twig_'            => __DIR__.'/../vendor/twig/lib',
          // ...
         'PHPExcel'         => __DIR__.'/../vendor/phpexcel/lib/PHPExcel/Classes',
     ));


## USAGE




## TEST

