Symfony2 Excel bundle
============
This Bundle permits to create easly Excel object.
This is just a dependency injection that links

3 Objects:

The container in this bundle, 

The StreamWrapper in the n3bStreamresponse

and a Writer.
 
You could create your own writer extending  ``n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamWriterInterface``

or you could use the Huge Xls library called PHPExcel.

With PHPExcel you can create: xls, ods, pdf and more.



## INSTALLATION

1 Add the following entry to ``deps`` the run ``php bin/vendors install``.

``` yaml 
[n3bStreamresponse]
    git=https://github.com/liuggio/Symfony2-StreamResponse.git
    target=n3b/src/n3b/Bundle/Util/HttpFoundation/StreamResponse

[phpExcel]
    git=https://github.com/liuggio/PHPExcel.git
    target=phpexcel

[liuggioExcelBundle]
    git=http://github.com/liuggio/ExcelBundle.git
    target=/bundles/liuggio/ExcelBundle
```

2 Register the bundle in ``app/AppKernel.php``

``` php
    $bundles = array(
        // ...
        new liuggio\ExcelBundle\liuggioExcelBundle(),
    );
```

3  Register namespace in ``app/autoload.php``

``` php
    $loader->registerNamespaces(array(
         // ...
         'n3b\\Bundle\\Util\\HttpFoundation\\StreamResponse'  => __DIR__.'/../vendor/n3b/src',
         
         'liuggio'              => __DIR__.'/../vendor/bundles',
     ));
```


4  Register the prefix for the library

``` php
     $loader->registerPrefixes(array(
         'Twig_Extensions_' => __DIR__.'/../vendor/twig-extensions/lib',
         'Twig_'            => __DIR__.'/../vendor/twig/lib',
          // ...
         'PHPExcel'         => __DIR__.'/../vendor/phpexcel/lib/PHPExcel/Classes',
     ));
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

if you need PDF, or XLS7 see and modify ``liuggio\ExcelBundle\Resources\config\services.yml`` 






## TEST

