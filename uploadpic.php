<?php
echo "Script started.\n";
require 'vendor/autoload.php'; // AWS SDK for PHP

use Aws\S3\S3Client;

function generatePresignedUrl($bucketName, $objectKey, $region = 'us-east-2', $expiration = 3600) {
    // Create an S3 client
    $s3 = new S3Client([
        'region'  => $region,
        'version' => 'latest',
        'credentials' => [
            'key'    => 'AKIA2UC27YWOYD2KJINM', 
            'secret' => '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', 
        ],
    ]);

    try {
        // Generate a presigned URL
        $cmd = $s3->getCommand('PutObject', [
            'Bucket' => $bucketName,
            'Key'    => $objectKey,
        ]);

        $request = $s3->createPresignedRequest($cmd, "+{$expiration} seconds");

        // Return the presigned URL
        return (string)$request->getUri();

    } catch (Exception $e) {
        echo "Error generating presigned URL: " . $e->getMessage();
        return null;
    }
}


$bucketName = 'replogs3'; // Your S3 bucket name
$objectKey = 'uploads/example-image.jpg'; // The file path
$url = generatePresignedUrl($bucketName, $objectKey);

if ($url) {
    echo "Presigned URL: $url\n";
} else {
    echo "Failed to generate presigned URL.\n";
}
?>