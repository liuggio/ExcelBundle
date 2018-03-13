<?php
@trigger_error('\PHPExcel_Writer_IWriter is deprecated use \PhpOffice\PhpSpreadsheet\Writer\IWriter instead', E_DEPRECATED);
/**
 * Interface PHPExcel_Writer_IWriter
 *
 * @deprecated
 */
interface PHPExcel_Writer_IWriter
{
    /**
     * Save PhpSpreadsheet to file.
     *
     * @param string $pFilename Name of the file to save
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function save($pFilename);
}
