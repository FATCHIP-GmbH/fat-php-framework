<?php

namespace FatFramework;

class Model
{
    /**
     * copy a data row
     * @param int $id
     * @return int $id new ID
     */
    public function copy($sTableName, $id){
        $this->loadById($sTableName, $id);
        $this->id = null;
        $this->save();
        return $this->id;
    }
    
    public function insert($sTableName)
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
        $sql = "INSERT INTO " . $sTableName . " (" . $sKeys . ") VALUES (" . $sValues . ")";
        mysql_query($sql);
        $this->id = mysql_insert_id();
    }
    
    public function loadById($sTableName, $id) {
        $blSuccess = false;
        if ($sTableName && $id) {
            $sql = mysql_query("SELECT * FROM " . $sTableName . " WHERE id = ".$id);
            $oType = mysql_fetch_object($sql);
            if (is_object($oType)) {
                foreach ($oType as $key => $value) {
                    $this->$key = $value;
                }
                $blSuccess = true;
            } else {
                echo "ERROR: Could not load " . $sTableName . " with given id: ".$id."!";
                exit;
            }
        }
        return $blSuccess;
    }
    
    public function save($sTableName)
    {
        if ($this->id) {
            $this->update($sTableName);
        } else {
            $this->insert($sTableName);
        }
    }
    
    public function update($sTableName)
    {
        $sql = "UPDATE " . $sTableName . " SET";
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
}

