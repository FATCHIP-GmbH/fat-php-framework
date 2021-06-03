<?php

namespace FatFramework;
use \PDO;

class Model
{
    /**
     * Copy a data row
     * 
     * @param int $id Id of row to copy
     * 
     * @return boolean $id New Id
     */
    public function copy($id) {
        $this->loadById($id);
        $this->id = false;
        $this->save();
        return $this->id;
    }

    /**
     * Delete a row
     *
     * @param $id Id of row to delete
     *
     * @return void
     */
    public function delete($id)
    {
        $sSql = "DELETE FROM " . $this->getTableName() . " WHERE id = :id";
        $dbc = Registry::get('dbc');
        $stmt = $dbc->prepare($sSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
     * Overwrite this with your model extension
     * 
     * @return string Table name
     */
    public function getTableName()
    {
        return 'default';
    }
    
    /**
     * Insert new row
     *
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
        $dbc = Registry::get('dbc');
        $stmt = $dbc->prepare($sql);
        $stmt->execute($aParam);
        $this->id = $dbc->lastInsertId();
    }

    /**
     * Loads a row by its primary identifier.
     * 
     * @param bool $id                  ID of the row to load
     * @param bool $blAdditionalValues  Load related table data true or false
     *
     * @return  null|boolean $blSuccess True or false
     */
    public function loadById($id = false, $blAdditionalValues = false) {
        $blSuccess = false;

        $sQuery = "SELECT * FROM " . $this->getTableName();
        if ($id) {
            $sQuery .= " WHERE id = :id";
        }
        $sQuery .= " LIMIT 1";
        $dbc = Registry::get('dbc');
        $stmt = $dbc->prepare($sQuery);

        if ($id) {
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
     * Loads an array of objects
     *
     * @param bool $sAdditionalWhere    Optional WHERE statement in SQL
     * @param bool $sOrderBy            Optional SORT statement
     * @param bool $blAdditionalValues  Should joined objects be loaded
     *
     * @return array $aRows
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
        $dbc = Registry::get('dbc');
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
     * Either insert or update row
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
     * Update a row
     *
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
        $aParam[":id"] = $this->id;
        $dbc = Registry::get('dbc');
        $stmt = $dbc->prepare($sql);
        $stmt->execute($aParam);
    }
    
    /**
     * Assign database result as object-properties
     *
     * @param mixed $arrayOrObject Array or object
     *
     * @return void
     */
    public function assign($arrayOrObject)
    {
        if (is_array($arrayOrObject) || is_object($arrayOrObject)) {
            foreach ($arrayOrObject as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Get number of entries of a table
     *
     * @param $sAdditionalWhere
     * @return mixed
     */
    public function getTotalNrOfRecords($sAdditionalWhere ){
        $sQuery = "SELECT COUNT(*) as records FROM " . $this->getTableName();
        if ($sAdditionalWhere != false) {
            $sQuery .= " WHERE " . $sAdditionalWhere;
        }

        $dbc = Registry::get('dbc');
        $stmt = $dbc->prepare($sQuery);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}

