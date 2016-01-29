<?php

namespace FatFramework;

class Model
{
    public function insert($sTableName)
    {
        $sql = "INSERT INTO " . $sTableName . " (";
        $firstkey = true;
        foreach ($this as $key => $value) {
            if ($firstkey) {
                $firstkey = false;
                $sql .= "$key";
            } else {
                $sql .= ", $key";
            }
        }
        $sql .=") VALUES (";
        $firstvalue = true;
        foreach ($this as $key => $value) {
            if ($firstvalue) {
                $firstvalue = false;
                $sql .= "'$value'";
            } else {
                $sql .= ", '$value'";
            }
        }
        $sql .=")";
        mysql_query($sql);
        $this->id = mysql_insert_id();
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

