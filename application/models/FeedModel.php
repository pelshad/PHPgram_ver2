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
        return $stmt->rowCount();
    }

    public function selFeedList(&$param)
    {
        $sql = "SELECT A.ifeed, A.location, A.ctnt, A.iuser, A.regdt, C.nm
                AS writer, C.mainimg,
                IFNULL(E.cnt, 0) AS favCnt,
                IF(F.ifeed IS NULL, 0, 1) AS isFav

                FROM t_feed A INNER JOIN t_user C ON A.iuser = C.iuser

                LEFT JOIN (
                    SELECT ifeed, COUNT(ifeed) AS cnt
                    FROM t_feed_fav GROUP BY ifeed
                ) E
                ON A.ifeed = E.ifeed

                LEFT JOIN (
                    SELECT ifeed
                    FROM t_feed_fav WHERE iuser = :iuser
                ) F
                ON A.ifeed = F.ifeed

                ORDER BY A.ifeed DESC
                LIMIT :startIdx, :feedItemCnt";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($param["iuser"], $param["startIdx"], _FEED_ITEM_CNT));
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selFeedImgList($param){
        $sql = "SELECT img FROM t_feed_img WHERE ifeed = :ifeed";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($param["ifeed"]));
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /*     fav     */
    public function insFeedFav(&$param){
        $sql = "INSERT INTO t_feed_fav
        (ifeed, iuser)
        VALUES
        (?,?)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($param["ifeed"], $param["iuser"])); 
        // 오류터지면 기존거랑 확인
        return $result;
    }

    public function delFeedFav(&$param){
        $sql = "DELETE FROM t_feed_fav
                WHERE ifeed = ?
                AND iuser = ? ";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($param["ifeed"], $param["iuser"]));
        return $result;
    }

    public function selFeedAfterReg(&$param) {
        $sql = "SELECT A.ifeed, A.location, A.ctnt, A.iuser, A.regdt
                    , C.nm AS writer, C.mainimg
                    , 0 AS favCnt
                    , 0 AS isFav
                FROM t_feed A
                INNER JOIN t_user C
                ON A.iuser = C.iuser               
                WHERE A.ifeed = :ifeed
                ORDER BY A.ifeed DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($param["ifeed"]));
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

}

