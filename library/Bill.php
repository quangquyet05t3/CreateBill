<?php
/**
 * Created by PhpStorm.
 * User: van
 * Date: 5/21/2017
 * Time: 1:04 PM
 */

require_once $_SERVER["DOCUMENT_ROOT"] . "/library/DataAccess.php";

class Bill {

    public $dal;

    function __construct() {
        $this->dal = new DataAccess();
    }

    public function saveBill($id, $customerName, $allData, $total, $totalQuantity) {
        try {
            if($allData!='[]') {
                $db = $this->dal->connect();
                $sqlDelete = "DELETE FROM bill WHERE id=:id";
                $stmtDelete = $db->prepare($sqlDelete);
                $paramDeletes = array(':id' => $id);
                $stmtDelete->execute($paramDeletes);

                $sqlInsert = "INSERT INTO bill(id, customer_name, all_data, total, date_created, total_quantity) values (:id, :customer_name, :all_data, :total, :date_created, :total_quantity)";
                $stmtInsert = $db->prepare($sqlInsert);
                $paramInserts = array(
                    ':id' => $id,
                    ':customer_name' => $customerName,
                    ':all_data' => $allData,
                    ':total' => $total,
                    ':date_created' => date('Y-m-d H:i:s', $id),
                    ':total_quantity' => $totalQuantity,
                );
                $stmtInsert->execute($paramInserts);
                $result = $db->lastInsertId();
                return $result;
            }
        }catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteBill($id) {
        try {
            $sql = "DELETE FROM bill WHERE id=:id";
            $db = $this->dal->connect();
            $stmt = $db->prepare($sql);
            $params = array(':id' => $id);
            $stmt->execute($params);
            $result = $db->lastInsertId();
            $db = null;
            return $result;
        }catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }


} 