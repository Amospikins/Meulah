<?php


class Dashboards
{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Get All Projects
   

    // Get Projects By ID
    public function getTotalProfit($userid)
    {
        $this->db->query("SELECT username, SUM(profit) as totalProfit, SUM(loss) as totalLoss FROM transactions WHERE username = :userid AND status = 1 AND checks = 0 GROUP BY username");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->single();

        return $results;
    }
    public function getTotalProfitBtc($userid)
    {
        $this->db->query("SELECT username, SUM(profit) as totalProfit, SUM(loss) as totalLoss FROM transactions WHERE username = :userid AND assets = 1 AND status = 1 GROUP BY username");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->single();

        return $results;
    }
    public function getTotalProfitEth($userid)
    {
        $this->db->query("SELECT username, SUM(profit) as totalProfit, SUM(loss) as totalLoss FROM transactions WHERE username = :userid AND assets = 2 AND status = 1 GROUP BY username");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->single();

        return $results;
    }
    public function getTotalProfitLtc($userid)
    {
        $this->db->query("SELECT username, SUM(profit) as totalProfit, SUM(loss) as totalLoss FROM transactions WHERE username = :userid AND assets = 3 AND status = 1 GROUP BY username");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->single();

        return $results;
    }
    public function getTotalProfitXrp($userid)
    {
        $this->db->query("SELECT username, SUM(profit) as totalProfit, SUM(loss) as totalLoss FROM transactions WHERE username = :userid AND assets = 4 AND status = 1 GROUP BY username");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->single();

        return $results;
    }
    public function getTransaction($userid)
    {
        $this->db->query("SELECT transactions.username, transactions.assets, transactions.amount, transactions.status, transactions.checks FROM transactions WHERE transactions.username = :userid");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->resultset();

        return $results;
    }
    public function getCountTransactions($userid)
    {
        $this->db->query("SELECT username FROM transactions WHERE username = :userid AND status = 1 AND checks = 0");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->countrow();

        return $results;
    }
    public function getBtcBalance($userid)
    {
        $this->db->query("SELECT username, SUM(amount) as totalAmount FROM transactions WHERE username = :userid AND status = 1 AND checks = 0 GROUP BY username");        

        $this->db->bind(':userid', $userid);
        $results = $this->db->single();

        return $results;
    }
    public function getEthBalance($data)
    {
        $this->db->query("SELECT username, SUM(amount) as totalAmount FROM transactions WHERE username = :userid AND assets = 2 AND status = 1 GROUP BY username");        

        $this->db->bind(':userid', $data);
        $results = $this->db->single();

        return $results;
    }
    public function getLtcBalance($data)
    {
        $this->db->query("SELECT username, SUM(amount) as totalAmount FROM transactions WHERE username = :userid AND assets = 3 AND status = 1 GROUP BY username");        

        $this->db->bind(':userid', $data);
        $results = $this->db->single();

        return $results;
    }
    public function getWithdrawal($data)
    {
        $this->db->query("SELECT username, SUM(amount) as totalAmount FROM transactions WHERE username = :userid AND status = 1 AND checks = 1 GROUP BY username");        

        $this->db->bind(':userid', $data);
        $results = $this->db->single();

        return $results;
    }
    public function getXrpBalance($data)
    {
        $this->db->query("SELECT username, SUM(amount) as totalAmount FROM transactions WHERE username = :userid AND assets = 4 AND status = 1 GROUP BY username");        

        $this->db->bind(':userid', $data);
        $results = $this->db->single();

        return $results;
    }

   
    public function addTrasaction($data)
    {
        // Prepare Query
        $this->db->query('INSERT INTO transactions (username, assets, invtype, amount) VALUES (:username, :assets, :invtype, :amount)');
        // Bind Values
        $this->db->bind(':username', $data['user_id']);
        $this->db->bind(':invtype', $data['assetHold2']);
        $this->db->bind(':assets', $data['assetHold67']);
        $this->db->bind(':amount', $data['amountHold']);
        
        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function addWithdrawal($data)
    {
        // Prepare Query
        $this->db->query('INSERT INTO transactions (username, assets,  amount, status, checks) VALUES (:username, :assets, :amount, :status, :checks)');
        // Bind Values
        $this->db->bind(':username', $data['user_id']);
        $this->db->bind(':assets', $data['assetHold2']);
        $this->db->bind(':amount', $data['amountHold']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':checks', $data['checks']);
        
        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // Update Post
   

    public function deletePost($id){
        // Prepare Query
        $this->db->query('DELETE FROM posts WHERE id = :id');

        // Bind Values
        $this->db->bind(':id', $id);

        //Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

}