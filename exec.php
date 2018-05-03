<?php
require __DIR__ . "/GcpStorage.php";

$n = $_SERVER['argc'];
$param;
for ($i = 1; $i < $n; $i+=2) {
    $key = preg_replace('/^\-{2,2}/', '', $_SERVER['argv'][$i]);
    $value = $_SERVER['argv'][$i + 1]; 
    $param[$key] = $value;
}

if (empty($param['projectId']) || empty($param['bucketName']) || empty($param['credentialFile'])) {
    echo "Please input --projectId, --bucketName, --credentialFile";
    exit(1);
}
if (!is_file($param['credentialFile'])) {
    echo "credential file " . $param['crendentialFile'] . " is not exist.";
    exit(1);
}
if (!empty($param['dir']) && !is_dir($param['dir'])) {
    echo "Directoruy " . $param['dir'] . " is not exist";
    exit(1);
}

$s = new GcpStorageClient($param['projectId'], $param['bucketName'], $param['credentialFile']);

if (!empty($param['printBucket'])) {
    $s->printBucket();
} else if (!empty($param['uploadFile']) && !empty($param['filename'])) {
    // upload a file
    $o = new GcpStorageUploadObject();
    $o->setName($param['filename']);
    $o->setLocalFile($param['uploadFile']);
    $o->setPublic();
    $storageObj = $s->upload($o);
    echo "gcUri = " . $storageObj->gcsUri() . "\n";
    print_r($storageObj->info());
} else if (!empty($param['deleteObj'])) {
    $ret = $s->delete($param['deleteObj']);
}

