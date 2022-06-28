<?php

namespace application\controllers;

class FeedController extends Controller
{
    public function index()
    {
        $this->addAttribute(_JS, ["feed/index"]);
        $this->addAttribute(_MAIN, $this->getView("feed/index.php"));
        return "template/t1.php";
    }

    public function rest()
    {
        switch (getMethod()) {
            case _POST:

                if (!is_array($_FILES) || !isset($_FILES["imgs"])) {
                    return ["result" => 0];
                }
                $iuser = getIuser();
                $param = [
                    "location" => $_POST["location"],
                    "ctnt" => $_POST["ctnt"],
                    "iuser" => getIuser()
                ];

                $ifeed = $this->model->insFeed($param);

                foreach ($_FILES["imgs"]["name"] as $key => $OriginName) {

                    $saveDirectory = _IMG_PATH . "/feed/" . $ifeed;
                    if (!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true);
                    }

                    $tempName = $_FILES["imgs"]["tmp_name"][$key];
                    $randomFileName = getRandomFileNm($OriginName);
                    if (move_uploaded_file($tempName, $saveDirectory . "/" . $randomFileName)) {
                        $param = [
                            "img" => $randomFileName,
                            "ifeed" => $ifeed
                        ];
                        $this->model->insFeedImg($param);
                    };
                    //
                    //
                }

                // return ["result" => $r];

                // debug 확인.(파일이 등록 됬는지)
                // print getIuser();
                // if (is_array($_FILES)) {
                //     foreach ($_FILES['imgs']['name'] as $key => $value) {
                //         print "key : {$key}, value: {$value} <br>";
                //     }
                // }
                // print "ctnt : " . $_POST["ctnt"] . "<br>";
                // print "location : " . $_POST["location"] . "<br>";
        }
    }
}
