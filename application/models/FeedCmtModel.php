<?php
    namespace application\models;
    use PDO;

    class FeedCmtModel extends Model{
        public function insfeedCmt(&$param){
            $sql = "INSERT INTO t_feed_cmt
                    (ifeed, iuser, cmt)
                    VALUES
                    (:ifeed, :iuser, :cmt)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($param["ifeed"], $param["iuser"], $param["cmt"]));
            return intval($this->pdo->lastInsertId());
        }

        public function selfeedCmt(&$param){
            $sql = "SELECT G.*, COUNT(G.icmt) - 1 AS ismore
                    FROM (
                        SELECT A.icmt, A.cmt, A.regdt, A.ifeed,
                                B.iuser, B.nm AS writer, B.mainimg AS writerimg
                        FROM t_feed_cmt A
                        INNER JOIN t_user B
                        ON A.iuser = B.iuser
                        WHERE A.ifeed = :ifeed
                        ORDER BY A.icmt DESC
                        LIMIT 2
                    ) G
                    GROUP BY G.ifeed";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(array($param["ifeed"]));
                    return $stmt->fetch(PDO::FETCH_OBJ);
                    //JSON객체로 추가
        }
    }