<?php

namespace application\models;

use PDO;

class FeedModel extends Model
{
    public function insFeed(&$param)
    {
        $sql = "INSERT INTO t_feed
                (location, ctnt, iuser)
                VALUES
                (?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($param["location"], $param["ctnt"], $param["iuser"]));
        return intval($this->pdo->lastInsertID());
    }

    /*public function insImgs(&$param)
    {
        $sql = "UPDATE t_user 
                SET mainimg = ?
                ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($this->saveDirectory . "/" . gen_uuid_v4() . "/" . $this->ext));
        return $this->pdo->lastInsertID();
    }*/

    public function insFeedImg(&$param)
    {
        $sql = "INSERT INTO t_feed_img
                (ifeed, img)
                VALUES
                (?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($param["ifeed"], $param["img"]));
    }
}
