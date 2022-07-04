<?php
namespace application\models;
use PDO;
//$pdo -> lastInsertId();

class UserModel extends Model {
    public function insUser(&$param) {
        $sql = "INSERT INTO t_user
                ( email, pw, nm ) 
                VALUES 
                ( :email, :pw, :nm )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $param["email"]);
        $stmt->bindValue(":pw", $param["pw"]);
        $stmt->bindValue(":nm", $param["nm"]);
        $stmt->execute();
        return $stmt->rowCount();

    }
    public function selUser(&$param) {
        $sql = "SELECT * FROM t_user
                WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $param["email"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function selUserProfile (&$param) {
        $feediuser = $param["feediuser"];
        $loginiuser = $param["loginiuser"];
        $sql = "SELECT iuser, email, nm, cmt, mainimg
        ,(SELECT COUNT(ifeed) FROM t_feed WHERE iuser = {$feediuser}) AS feedcnt
        ,(SELECT COUNT(fromiuser) FROM t_user_follow WHERE fromiuser = {$feediuser} AND toiuser = {$loginiuser}) AS youfme
        ,(SELECT COUNT(fromiuser) FROM t_user_follow WHERE fromiuser = {$loginiuser} AND toiuser = {$feediuser}) AS mefyou
        ,(SELECT COUNT(fromiuser) FROM t_user_follow WHERE fromiuser = {$feediuser}) AS following
	    ,(SELECT COUNT(toiuser) FROM t_user_follow WHERE toiuser = {$feediuser}) AS follower
        FROM t_user
        WHERE iuser = {$feediuser}";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute(array());
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    



    //--------------------------follow----------------------------//
    public function insFollow(&$param){
        $toiuser = $param["toiuser"];
        $fromiuser = $param["fromiuser"];
        $sql = "INSERT INTO t_user_follow
                (fromiuser, toiuser)
                VALUES
                (:fromiuser, :toiuser)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($fromiuser, $toiuser));
        return $stmt->rowCount();
    }

    public function delFollow(&$param){
        $toiuser = $param["toiuser"];
        $fromiuser = $param["fromiuser"];
        $sql = "DELETE FROM t_user_follow
                WHERE fromiuser = :fromiuser 
                AND toiuser = :toiuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($fromiuser, $toiuser));
        return $stmt->rowCount();

    }
}