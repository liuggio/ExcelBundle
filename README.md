Symfony2 Excel bundle
============

[![Build Status](https://travis-ci.org/liuggio/ExcelBundle.png)](https://travis-ci.org/liuggio/ExcelBundle)
[![Total Downloads](https://poser.pugx.org/liuggio/ExcelBundle/downloads.png)](https://packagist.org/packages/liuggio/ExcelBundle)
[![Latest Stable Version](https://poser.pugx.org/liuggio/ExcelBundle/v/stable.png)](https://packagist.org/packages/liuggio/ExcelBundle)
[![Latest Unstable Version](https://poser.pugx.org/liuggio/ExcelBundle/v/unstable.png)](https://packagist.org/packages/liuggio/ExcelBundle)

This bundle permits you to create an easily modifiable excel object.

You should know that csv is faster so I encourage you to use the built-in function for csv: http://php.net/manual-lookup.php?pattern=csv&lang=en&scope=quickref

## Installation

**1**  Add to composer.json to the `require` key

``` yml
    "require" : {
        "liuggio/excelbundle": "2.0.x-dev",
    }
``` 

**2** Register the bundle in ``app/AppKernel.php``

``` php
    $bundles = array(
        // ...
        new Liuggio\ExcelBundle\LiuggioExcelBundle(),
    );
```

## Services

The list of the services are listed in `/Resources/config/services.yml`.

``` php
// create MS Excel5
$this->get('xls.excel5');
// create MS Excel 2007
$this->get('xls.excel2007');
// read file
$excelService = $this->get('xls.excel5')->load($filename);
```

## Example

Create a controller in your bundle,
there's a working example at `Tests/app/Controller/FakeController.php`.

``` php
namespace YOURNAME\YOURBUNDLE\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction($name)
    {
        // ask the service for a Excel5
        $excelService = $this->get('xls.excel5');
        // or $this->get('xls.excel5')->load($filename);
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

        return $response;        
    }
}
```

With the correct writer (e.g. PHPExcel_Writer_Excel5) you could also write the output to a file:

``` php
    
	public function indexAction($name)
    {
        $excelService = $this->get('xls.excel5');	
        //...load and modify or create php excel object
        $excelService->getStreamWriter()->write($filename);
    }
```

## Contributors

@pivasyk

@dirkbl

@DerStoffel

@artturi

@isqad88

@mazenovi

@gnat42

@jochenhilgers

@Squazic
