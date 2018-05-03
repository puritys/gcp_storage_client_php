<?php

class GcpStorageUploadObject {

    private $name;
    private $filePath;
    private $acl = GcpStorageAcl::PRIVATE;

    public function setPublic() {
        $this->acl = GcpStorageAcl::PUBLIC_READ; 
    }
    /**
     * 
     * @param String $path file path of local system
     */ 
    public function setLocalFile($path) {
        if (!is_file($path)) {
            $err = "file not found";
            error_log("Exception = " . $err);
            throw new Exception($err);
        }
        $this->filePath = $path;
    }

    public function getLocalFile() {
        return $this->filePath;
    }

    /**
     * set GCP object name
     *
     * @param String $name /xxx/yyy/a.jpg
     */ 
    public function setName($name) {
        $this->name = $name;
    }

    public function getUploadOptions() {
        $ret = [
            "name"          => $this->name,
            "predefinedAcl" => $this->acl 
        ];
        print_r($ret);
        return $ret;
    }
}


class GcpStorageAcl {
    const PUBLIC_READ        = "publicRead";
    const AUTH_READ          = "authenticatedRead";
    const OWNER_FULL_CONTROL = "bucketOwnerFullControl";
    const OWNER_READ         = "bucketOwnerRead";
    const PRIVATE            = "private";
    const PROJECT_PRIVATE    = "projectPrivate";
}
