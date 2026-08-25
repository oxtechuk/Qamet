<?php

declare(strict_types=1);

$file = __DIR__.'/../vendor/livewire/livewire/src/Features/SupportFileUploads/TemporaryUploadedFile.php';

if (! file_exists($file)) {
    return;
}

$contents = file_get_contents($file);

$targetDimensions = 'stream_copy_to_stream($this->storage->readStream($this->path), $tmpFile = tmpfile());';
if (str_contains($contents, $targetDimensions)) {
    $replacementDimensions = <<<'PHP'
        $stream = $this->storage->readStream($this->path);

        if (! is_resource($stream)) {
            return false;
        }

        $tmpFile = tmpfile();

        if (! is_resource($tmpFile)) {
            return false;
        }

        stream_copy_to_stream($stream, $tmpFile);

        $meta = stream_get_meta_data($tmpFile);

        return isset($meta['uri']) ? @getimagesize($meta['uri']) : false;
PHP;
    $contents = str_replace("        stream_copy_to_stream(\$this->storage->readStream(\$this->path), \$tmpFile = tmpfile());\n\n        return @getimagesize(stream_get_meta_data(\$tmpFile)['uri']);", $replacementDimensions, $contents);
    file_put_contents($file, $contents);
    echo "[Patch] Applied PHP 8.4 fix to Livewire TemporaryUploadedFile::dimensions()\n";
}
