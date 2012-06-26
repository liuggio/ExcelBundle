Symfony2 Excel bundle
============

This Bundle permits to create easly Excel object.
This is just a dependency injection that links

3 Objects:

- The container in this bundle, 

- The StreamWrapper in the n3bStreamresponse

- A Writer.
 

You could create your own writer extending  ``n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamWriterInterface`` or you could use the Huge Xls library called PHPExcel.

With PHPExcel you can create: xls, ods, pdf and more,

you have to know that csv is pretty faster so I encourage you to use the built-in function for csv  http://it.php.net/manual-lookup.php?pattern=csv&lang=en&scope=quickref

## Migration

In order to follow the naming convention  https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md  all the liuggio namespaces are migrated to Liuggio.

This master is up-to-date to the symfony/symfony master actually on 2.1


## INSTALLATION with COMPOSER 

1  Add to composer.json to the `require` key  

``` 
"liuggio/excelbundle": "dev-master",
``` 

and add the repositories:

```
    "repositories": {
        "n3bStreamresponse": {
            "type": "package",
            "package": {
                "name": "n3bStreamresponse",
                "version": "master",
                "source": {
                    "url": "git://github.com/liuggio/Symfony2-StreamResponse.git",
                    "type": "git",
                    "reference": "master"
                },
                "autoload": {
                    "psr-0": { "n3b\\Bundle\\Util\\HttpFoundation\\StreamResponse": "n3b/src" }
                },
                "target-dir": "n3b/src/n3b/Bundle/Util/HttpFoundation/StreamResponse"
            }
        },
        "phpExcel": {
            "type": "package",
            "package": {
                "name": "phpExcel",
                "version": "master",
                "source": {
                    "url": "git://github.com/liuggio/PHPExcel.git",
                    "type": "git",
                    "reference": "master"
                },
                "autoload": {
                    "classmap": ["lib/"]
                }
            }
        }
    },

```
 

2 Register the bundle in ``app/AppKernel.php``

``` php
    $bundles = array(
        // ...
        new Liuggio\ExcelBundle\LiuggioExcelBundle(),
    );
```
 


## AVAILABLE SERVICES

If you want write

``` php
   // create MS Excel5
   $xls_service =  $this->get('xls.service_xls5');
   // create pdf
   $this->get('xls.service_pdf');
   // create MS Excel 2007
   $this->get('xls.service_xls2007');

```


If you want read xls

``` php
    $exelObj = $this->get('xls.load_xls5')->load($filename);

```




## USAGE

create a controller in your bundle


``` php

namespace YOURNAME\YOURBUNDLE\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        // ask the service for a Excel5
        $xls_service =  $this->get('xls.service_xls5');
        // or $this->get('xls.service_pdf');
        // or create your own is easy just modify services.yml


        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->excelObj->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("Office 2005 XLSX Test Document")
                            ->setSubject("Office 2005 XLSX Test Document")
                            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                            ->setKeywords("office 2005 openxml php")
                            ->setCategory("Test result file");
        $xls_service->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'world!');
        $xls_service->excelObj->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $xls_service->excelObj->setActiveSheetIndex(0);
 
        //create the response
        $response = $xls_service->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stdream2.xls');
        
        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;        
    }
}

```




## ADVANCED USE

if you need see and modify ``Liuggio\ExcelBundle\Resources\config\services.yml``


## Contributors

@pivasyk

@dirkbl

@DerStoffel

@artturi

@isqad88

@mazenovi