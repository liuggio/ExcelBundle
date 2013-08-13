Symfony2 Excel bundle
============

[![Total Downloads](https://poser.pugx.org/liuggio/ExcelBundle/downloads.png)](https://packagist.org/packages/liuggio/ExcelBundle) [![Latest Stable Version](https://poser.pugx.org/liuggio/ExcelBundle/v/stable.png)](https://packagist.org/packages/liuggio/ExcelBundle)

This bundle permits you to create an easily modifiable excel object.
This is just a dependency injection that links


3 Objects:

- The container in this bundle, 

- The StreamWrapper in the n3bStreamresponse

- A Writer.
 

You could create your own writer extending  ``n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamWriterInterface`` or you could use the great PHPExcel library. With PHPExcel you can create xls, ods, pdf and more.

You have to know that csv is faster so I encourage you to use the built-in function for csv: http://it.php.net/manual-lookup.php?pattern=csv&lang=en&scope=quickref

## Migration

In order to follow the naming convention  https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md  all the liuggio namespaces are migrated to Liuggio.

This master is up-to-date to the symfony/symfony master actually on 2.1


## INSTALLATION with COMPOSER 

1  Add to composer.json to the `require` key  

``` 
    "require" : {
        "liuggio/excelbundle": ">=1.0.4",
    }
``` 
 

2 Register the bundle in ``app/AppKernel.php``

``` php
    $bundles = array(
        // ...
        new Liuggio\ExcelBundle\LiuggioExcelBundle(),
    );
```

## INSTALLATION with deps file

1  Add to the following to your `deps` file, then run `php bin/vendors install`

``` yaml
[PHPExcel]
    git=http://github.com/PHPOffice/PHPExcel.git
    target=/phpexcel
    version=origin/master

[n3bStreamresponse]
    git=git://github.com/liuggio/Symfony2-StreamResponse.git
    target=n3b/src/n3b/Bundle/Util/HttpFoundation/StreamResponse

[LiuggioExcelBundle]
    git=https://github.com/liuggio/ExcelBundle.git
    target=/bundles/Liuggio/ExcelBundle
``` 

2  Register the namespaces and prefixes in `app/autoload.php`:

``` php
    $loader->registerNamespaces(array(
        // ...
        'n3b\\Bundle\\Util\\HttpFoundation\\StreamResponse' => __DIR__.'/../vendor/n3b/src',
        'Liuggio'          => __DIR__.'/../vendor/bundles',
    ));
    $loader->registerPrefixes(array(
        // ...
        'PHPExcel'         => __DIR__.'/../vendor/phpexcel/Classes',
    ));

```
 

3 Enable the bundle in `app/AppKernel.php`

``` php
    $bundles = array(
        // ...
        new Liuggio\ExcelBundle\LiuggioExcelBundle(),
    );
```
 


## AVAILABLE SERVICES

If you want to write

``` php
   // create MS Excel5
   $excelService = $this->get('xls.service_xls5');
   // create pdf
   $this->get('xls.service_pdf');
   // create MS Excel 2007
   $this->get('xls.service_xls2007');

```


If you want to read xls

``` php
    $excelObj = $this->get('xls.load_xls5')->load($filename);

```




## USAGE

Create a controller in your bundle


``` php

namespace YOURNAME\YOURBUNDLE\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        // ask the service for a Excel5
        $excelService = $this->get('xls.service_xls5');
        // or $this->get('xls.service_pdf');
        // or create your own is easy just modify services.yml


        // create the object see http://phpexcel.codeplex.com documentation
        $excelService->excelObj->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("Office 2005 XLSX Test Document")
                            ->setSubject("Office 2005 XLSX Test Document")
                            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                            ->setKeywords("office 2005 openxml php")
                            ->setCategory("Test result file");
        $excelService->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'world!');
        $excelService->excelObj->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $excelService->excelObj->setActiveSheetIndex(0);
 
        //create the response
        $response = $excelService->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stdream2.xls');
        
        // If you are using a https connection, you have to set those two headers and use sendHeaders() for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->sendHeaders();
        return $response;        
    }
}

```

With the right writer (e.g. PHPExcel_Writer_Excel5) you could also write the output to a file:
``` php
    
	public function indexAction($name)
    {
        $excelService = $this->get('xls.service_xls5');	

        //...create php excel object

        $excelService->getStreamWriter()->write( $filename );
    }
```


## ADVANCED USE

If you need to, see and modify ``Liuggio\ExcelBundle\Resources\config\services.yml``


## Contributors

@pivasyk

@dirkbl

@DerStoffel

@artturi

@isqad88

@mazenovi

@jochenhilgers

@Squazic
