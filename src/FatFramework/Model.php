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
     * delete dataset
     * @param integer $id
     */
    public function delete($id)
    {
        $sQuery = "DELETE FROM " . $this->getTableName() . " WHERE id = '" . $id . "'";
        mysql_query($sQuery);
    }
    
    /**
     * overwrite this with your model extension
     * @return string
     */
    public function getTableName()
    {
        return 'default';
    }
    
    /**
     * insert new dataset
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
    
    public function loadById($id = false, $blAdditionalValues = false) {
        $blSuccess = false;
        
        $sQuery = "SELECT * FROM " . $this->getTableName() . " WHERE id = '".$id."'";
        $sQuery .= " LIMIT 1";
        $sql = mysql_query($sQuery);
        $oResult = mysql_fetch_object($sql);
        if (is_object($oResult)) {
            $this->assign($oResult);
            $blSuccess = true;
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
        while (is_resource($sql) && ($oRow = mysql_fetch_object($sql)) != false) {
            $oDataset = new $this;
            $oDataset->loadById($oRow->id, $blAdditionalValues);
            $aRows[$oRow->id] = $oDataset;
        }
        if (empty($aRows)) {
            $aRows = false;
        }
        return $aRows;
    }
    
    /**
     * either insert or update dataset
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
     * update dataset
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
    
    public function assign($arrayOrObject)
    {
        if(is_array($arrayOrObject) || is_object($arrayOrObject)){
            foreach ($arrayOrObject as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}
