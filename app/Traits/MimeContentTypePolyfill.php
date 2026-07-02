<?php

namespace App\Traits;

trait MimeContentTypePolyfill
{
    /**
     * Boot the polyfill for mime_content_type function
     */
    protected static function bootMimeContentTypePolyfill()
    {
        if (!function_exists('mime_content_type')) {
            function mime_content_type($filename) {
                // Tenta usar finfo se disponível
                if (function_exists('finfo_open')) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    if ($finfo) {
                        $mime_type = finfo_file($finfo, $filename);
                        finfo_close($finfo);
                        return $mime_type;
                    }
                }
                
                // Fallback baseado na extensão do arquivo
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $mime_types = [
                    'png' => 'image/png',
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'bmp' => 'image/bmp',
                    'webp' => 'image/webp',
                    'svg' => 'image/svg+xml',
                    'ico' => 'image/x-icon',
                    'txt' => 'text/plain',
                    'pdf' => 'application/pdf',
                    'doc' => 'application/msword',
                    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'xls' => 'application/vnd.ms-excel',
                    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ];
                
                return $mime_types[$ext] ?? 'application/octet-stream';
            }
        }
    }
}