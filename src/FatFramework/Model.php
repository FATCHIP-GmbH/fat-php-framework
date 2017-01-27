<?php

namespace FatFramework;

class Model
{
    /**
     * Copy a data row
     * 
     * @param int $id
     * 
     * @return boolean $id new ID
     */
    public function copy($id) {
        $this->loadById($id);
        $this->id = false;
        $this->save();
        return $this->id;
    }

    /**
     * Delete Dataset
     *
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $sSql = "DELETE FROM " . $this->getTableName() . " WHERE id = :id";
        $dbc = FatFramework/Registry::get('dbc');
        $stmt = $dbc->prepare($sSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
     * Overwrite this with your model extension
     * 
     * @return string Tablename
     */
    public function getTableName()
    {
        return 'default';
    }
    
    /**
     * Insert new dataset
     * 
     * @return void
     */
    /**
     * Insert New Dataset
     *
     * @param void
     * @return void
     */
    public function insert()
    {
        $aParam = array();
        $first = true;
        $sKeys = "";
        $sValues = "";
        foreach ($this as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $sKeys .= ", ";
                $sValues .= ", ";
            }
            $sKeys .= $key;
            $sValues .= ":" . $key;
            $aParam[$key] = $value;

        }
        $sql = "INSERT INTO " . $this->getTableName() . " (" . $sKeys . ") VALUES (" . $sValues . ")";
        $dbc = FatFramework/Registry::get('dbc');
        $stmt = $dbc->prepare($sql);
        $stmt->execute($aParam);
    }

    /**
     * Loads a dataset by its primary identifier.
     * 
     * @param bool $id /ID of the dataset to load
     * @param bool $blAdditionalValues/ Load related table data true or false
     * @return  bool $blSuccess True or false
     */
    public function loadById($id = false, $blAdditionalValues = false) {
        $blSuccess = false;

        $sQuery = "SELECT * FROM " . $this->getTableName();
        if ($id) {
            $sQuery .= " WHERE id = :id";
        }
        $sQuery .= " LIMIT 1";
        $dbc = FatFramework/Registry::get('dbc');
        $stmt = $dbc->prepare($sQuery);

        if ($id){
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        $oResult = $stmt->fetchObject();
        if (is_object($oResult)) {
            $this->assign($oResult);
            $blSuccess = true;
        } else {
            echo "ERROR: Could not load " . $this->getTableName() . " with given id: " . $id . "!";
            exit;
        }

        return $blSuccess;
    }
    
    /**
     * Loads an array of dataset-objects
     *
     * @param bool $sAdditionalWhere
     * @param bool $sOrderBy
     * @return array
     */
    public function loadList($sAdditionalWhere = false, $sOrderBy = false, $blAdditionalValues = false)
    {
        $aRows = array();
        $sQuery = "SELECT * FROM " . $this->getTableName();
        if ($sAdditionalWhere != false) {
            $sQuery .= " WHERE " . $sAdditionalWhere;
        }
        if ($sOrderBy != false) {
            $sQuery .= " ORDER BY " . $sOrderBy;
        }
        $dbc = FatFramework/Registry::get('dbc');
        $stmt = $dbc->prepare($sQuery);
        $stmt->execute();

        while ($oRow = $stmt->fetchObject()) {
            $oDataset = new $this;
            $oDataset->loadByID($oRow->id, $blAdditionalValues);
            $aRows[] = $oDataset;
        }
        return $aRows;
    }
    
    /**
     * Either insert or update dataset
     * 
     * @return void
     */
    public function save()
    {
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
    
    /**
     * Update dataset
     *
     * @param void
     * @return void
     */
    public function update()
    {
        $aParam = array();
        $sql = "UPDATE " . $this->getTableName() . " SET";
        $first = true;
        foreach ($this as $property => $value) {
            if ($first) {
                $first = false;
                $sql .= " $property=:$property";
            } else {
                $sql .= ", $property=:$property";
            }
            $aParam[":$property"] = $value;
        }
        $sql .= " WHERE id = :id";
        $aParam[":id"] = $this-id;
        $dbc = FatFramework/Registry::get('dbc');
        $stmt = $dbc->prepare($sql);
        $stmt->execute($aParam);
    }
    
    /**
     * Assign database result as object-properties.
     * 
     * @return void
     */
    protected function assign($arrayOrObject)
    {
        if (is_array($arrayOrObject) || is_object($arrayOrObject)) {
            foreach ($arrayOrObject as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}

