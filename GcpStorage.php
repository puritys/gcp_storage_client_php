<?php
require __DIR__ . "/vendor/autoload.php";
require_once "GcpStorageUploadObject.php";
use Google\Cloud\Core\ServiceBuilder;
use Google\Cloud\Storage\StorageClient;

class GcpStorageClient {
    private $projectId; 
    private $bucketName;
    private $crenentialFile;
    private $storage;
    private $bucket;

    public function __construct($projectId, $bucketName, $crenentialFile) {
        $this->projectId = $projectId;
        $this->bucketName = $bucketName;
        $this->crenentialFile = $crenentialFile;
        $config = [
            'keyFilePath' => $crenentialFile,
            'projectId'          => $projectId,
        ];
        $this->storage = new StorageClient($config);
        $this->bucket = $this->storage->bucket($bucketName);
    }

    public function printBucket()
    {
        foreach ($this->storage->buckets() as $bucket) {
            printf('Bucket: %s' . PHP_EOL, $bucket->name());
        }
    }

    public function upload($uploadObj) {
        $ret = $this->bucket->upload(
             fopen($uploadObj->getLocalFile(), 'r'),
             $uploadObj->getUploadOptions()
        );
        return $ret;
    }

    public function delete($obj) {
        $obj = $this->bucket->object($obj);
        return $obj->delete();
    }

}
