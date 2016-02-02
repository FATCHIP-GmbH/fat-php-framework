<?php

namespace FatFramework;

class Model
{
    /**
     * copy a data row
     * @param int $id
     * @return int $id new ID
     */
    public function copy($id){
        $this->loadById($id);
        $this->id = false;
        $this->save();
        return $this->id;
    }
    
    /**
     * overwrite this with your model extension
     * @return string
     */
    public function getTableName()
    {
        return 'default';
    }
    
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
    
    public function loadById($id, $blAdditionalValues = false) {
        $blSuccess = false;
        if ($id) {
            $sql = mysql_query("SELECT * FROM " . $this->getTableName() . " WHERE id = '".$id."'");
            $oResult = mysql_fetch_object($sql);
            if (is_object($oResult)) {
                $this->assign($oResult);
                $blSuccess = true;
            } else {
                echo "ERROR: Could not load " . $this->getTableName() . " with given id: ".$id."!";
                exit;
            }
        }
        return $blSuccess;
    }
    
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
        while (($oRow = mysql_fetch_object($sql)) != false) {
            $oDataset = new $this;
            $oDataset->loadById($oRow->id, $blAdditionalValues);
            $aRows[] = $oDataset;
        }
        return $aRows;
    }
    
    public function save()
    {
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
    
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
        $sql .= "WHERE id = " . $this->id;
        
        mysql_query($sql);
    }
    
    protected function assign($arrayOrObject)
    {
        if(is_array($arrayOrObject) || is_object($arrayOrObject)){
            foreach ($arrayOrObject as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}

