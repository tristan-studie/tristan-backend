<?php
class Status
{
    /**
     * @var int
     */
    public $id = null;
    /**
     * @var string
     */
    public $status = null;
    /**
     *
     *
     * @param assoc
     */

    public function __construct($data = array())
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        if (isset($data['status'])) $this->status = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['status']);
    }

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    //Get list of all Statusses
    public static function getStatus($numRows = 1000000, $order = "ASC")
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM status
          ORDER BY " . $conn->quote($order) . " LIMIT :numRows";

        $st = $conn->prepare($sql);
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        $st->execute();
        $statusList = array();

        while ($row = $st->fetch())
        {
            $status = new Status($row);
            $statusList[] = $status;
        }

        $conn = null;
        return (array(
            "results" => $statusList
        ));
    }

}
