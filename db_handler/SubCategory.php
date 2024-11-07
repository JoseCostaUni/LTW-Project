
<?php

class SubCategory {
    private $subCategoryId;
    private $name;

    public function __construct($subCategoryId, $name) {
        $this->subCategoryId = $subCategoryId;
        $this->name = $name;
    }

    public function getSubCategoryId() {
        return $this->subCategoryId;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
}

?>