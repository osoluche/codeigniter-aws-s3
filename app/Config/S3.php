<?php

namespace Config;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use RuntimeException;

class S3 extends \CodeIgniter\Config\BaseConfig
{
    public function getS3Client()
    {
        return new S3Client([
            'version' => 'latest',
            'region'  => 'us-west-2',
            'credentials' => [
                'key'    => env('aws.access_key_id'),
                'secret' => env('aws.secret_access_key')
            ]
        ]);
    }

    public function uploadToS3($fileStream, $s3Key, $contentType)
    {
        $s3Client = $this->getS3Client();
        
        try {
            $result = $s3Client->putObject([
                'Bucket' => env('aws.s3_bucket'),
                'Key'    => $s3Key,
                'Body'   => $fileStream,
                'ContentType' => $contentType
            ]);
            
            return $result['ObjectURL'] ?? null;
        } catch (AwsException $e) {
            $errorMessage = sprintf(
                'S3 Upload Error: %s. Error Code: %s. Request ID: %s',
                $e->getMessage(),
                $e->getAwsErrorCode(),
                $e->getAwsRequestId()
            );
            log_message('error', $errorMessage);
            throw new RuntimeException($errorMessage);
        }
    }
}