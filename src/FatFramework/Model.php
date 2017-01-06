<?php

namespace FatFramework;

class Model
{
    /**
     * Copy a data row
     * 
     * @param int $id
     * 
     * @return int $id new ID
     */
    public function copy($id){
        $this->loadById($id);
        $this->id = false;
        $this->save();
        return $this->id;
    }
    
    /**
     * Delete dataset
     * 
     * @param string $id ID of dataset to delete
     * 
     * @return void
     */
    public function delete($id)
    {
        $sQuery = "DELETE FROM " . $this->getTableName() . " WHERE id = '" . $id . "'";
        mysql_query($sQuery);
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
    public function insert()
    {
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
            $sValues .= "'" . $value . "'";
        }
        $sql = "INSERT INTO " . $this->getTableName() . " (" . $sKeys . ") VALUES (" . $sValues . ")";
        mysql_query($sql);
        $this->id = mysql_insert_id();
    }
    
    /**
     * Loads a dataset by its primary identifier.
     * 
     * @param string  $id                 ID of the dataset to load
     * @param boolean $blAdditionalValues Load related table data true or false
     * 
     * @return boolean $blSuccess True or false
     */ 
    public function loadById($id = false, $blAdditionalValues = false) {
        $blSuccess = false;
        
        $sQuery = "SELECT * FROM " . $this->getTableName();
        if ($id) {
            $sQuery .= " WHERE id = '" . $id . "'";
        }
        $sQuery .= " LIMIT 1";
        $sql = mysql_query($sQuery);
        $oResult = mysql_fetch_object($sql);
        if (is_object($oResult)) {
            $this->assign($oResult);
            $blSuccess = true;
        } else {
            echo "ERROR: Could not load " . $this->getTableName() . " with given id: ".$id."!";
            exit;
        }
        
        return $blSuccess;
    }
    
    /**
     * Loads an array of dataset-objects
     * 
     * @return array $aRows Array of dataset-objects
     */
    public function loadList($sAdditionalWhere = false, $sOrderBy = false, $blAdditionalValues = false)
    {
        $aRows = array();
        $sQuery = "SELECT id FROM " . $this->getTableName();
        if ($sAdditionalWhere != false) {
            $sQuery .= " WHERE " . $sAdditionalWhere;
        }
        if ($sOrderBy != false) {
            $sQuery .= " ORDER BY " . $sOrderBy;
        }
        $sql = mysql_query($sQuery);
        while (is_resource($sql) && ($oRow = mysql_fetch_object($sql)) != false) {
            $oDataset = new $this;
            $oDataset->loadById($oRow->id, $blAdditionalValues);
            $aRows[] = $oDataset;
        }
        if (empty($aRows)) {
            $aRows = false;
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
     * @return void
     */
    public function update()
    {
        $sql = "UPDATE " . $this->getTableName() . " SET";
        $first = true;
        foreach ($this as $property => $value) {
            if ($first) {
                $first = false;
                $sql .= " $property='".mysql_escape_string($value)."'";
            } else {
                $sql .= ", $property='".mysql_escape_string($value)."'";
            }
        }
        $sql .= "WHERE id = '" . $this->id . "'";
        
        mysql_query($sql);
    }
    
    /**
     * Assign database result as object-properties.
     * 
     * @return void
     */
    protected function assign($arrayOrObject)
    {
        if(is_array($arrayOrObject) || is_object($arrayOrObject)){
            foreach ($arrayOrObject as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}

