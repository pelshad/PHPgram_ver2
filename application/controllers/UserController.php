<?php

namespace application\controllers;

class UserController extends Controller
{

    //로그인
    public function signin()
    {
        switch (getMethod()) {
            case _GET:
                return "user/signin.php";
            case _POST:
                $email = $_POST["email"];
                $pw = $_POST["pw"];
                $param = ["email" => $email];
                $dbUser = $this->model->selUser($param);
                if (!$dbUser || !password_verify($pw, $dbUser->pw)) {
                    return "redirect:signin?email={$email}&err";
                }
                $dbUser->pw = null;
                $dbUser->regdt = null;
                $this->flash(_LOGINUSER, $dbUser);
                return "redirect:/feed/index";
        }
    }

    //회원가입
    public function signup()
    {
        switch (getMethod()) {
            case _GET:
                return "user/signup.php";
            case _POST:
                $email = $_POST["email"];
                $pw = $_POST["pw"];
                $hashedPw = password_hash($pw, PASSWORD_BCRYPT);
                $nm = $_POST["nm"];
                $param = [
                    "email" => $email,
                    "pw" => $hashedPw,
                    "nm" => $nm
                ];

                $this->model->insUser($param);

                return "redirect:signin";
        }
    }

    public function logout()
    {
        $this->flash(_LOGINUSER);
        return "redirect:/user/signin";
    }
}
