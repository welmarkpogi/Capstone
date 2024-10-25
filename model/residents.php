<?php

include "../bootstrap/index.php";

use function _\camelCase as _camelCase;

/**
 * Function to calculate age based on birthdate
 */
function calculateAge($birthdate) {
    $birthDate = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    return $age;
}

if (isset($_POST["register-resident"])) {
    try {
        $national_id = getBody("national_id", $_POST);
        $citizenship = getBody("citizenship", $_POST);
        $address = getBody("address", $_POST);
        $fname = getBody("fname", $_POST);
        $mname = getBody("mname", $_POST);
        $lname = getBody("lname", $_POST);
        $alias = getBody("alias", $_POST);
        $birthplace = getBody("birthplace", $_POST);
        $birthdate = getBody("birthdate", $_POST);
        $age = calculateAge($birthdate); // Automatically calculate age
        $civil_status = getBody("civil_status", $_POST);
        $gender = getBody("gender", $_POST);
        $purokId = getBody("purok_id", $_POST);
        $voter_status = getBody("voter_status", $_POST);
        $identified_as = getBody("identified_as", $_POST);
        $email = getBody("email", $_POST);
        $number = getBody("number", $_POST);
        $occupation = getBody("occupation", $_POST);
        $username = getBody("username", $_POST);
        $password = getBody("password", $_POST);
        $password_confirm = getBody("password_confirm", $_POST);
        $is_pwd = getBody("is_pwd", $_POST);
        $is_4ps = getBody("is_4ps", $_POST);
        $is_senior = $age > 60; // Determine if senior citizen based on age

        $profileimg = getBody("profileimg", $_POST);

        $requiredFields = [
            "National ID" => $national_id,
            "Citizenship" => $citizenship,
            "Address" => $address,
            "First Name" => $fname,
            "Middle Name" => $mname,
            "Last Name" => $lname,
            "Alias" => $alias,
            "Birth Place" => $birthplace,
            "Birth Date" => $birthdate,
            "Civil Status" => $civil_status,
            "Gender" => $gender,
            "Purok" => $purokId,
            "Voter Status" => $voter_status,
            "Email" => $email,
            "Contact Number" => $number,
            "Occupation" => $occupation,
            "Username" => $username,
            "Password" => $password,
            "Password Confirmation" => $password_confirm,
        ];

        /**
         * Check required fields
         */
        $emptyRequiredField = array_find_key($requiredFields, fn($item) => empty($item));

        if ($emptyRequiredField) {
            $_SESSION["message"] = "<b>$emptyRequiredField</b> is required!";
            $_SESSION["status"] = "danger";

            if ($_SERVER["HTTP_REFERER"]) {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                return $conn->close();
            }

            header("location: ../user-register.php");
            return $conn->close();
        }

        /**
         * Check password
         */
        if ($password != $password_confirm) {
            $_SESSION["message"] = "Please confirm your password!";
            $_SESSION["status"] = "danger";

            if ($_SERVER["HTTP_REFERER"]) {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                return $conn->close();
            }

            header("location: ../user-register.php");
            return $conn->close();
        }

        /**
         * Handle profile image
         */
        $profileCamera = getBody("profileimg", $_POST); // base 64 image
        $profileFile = $_FILES["img"];

        $imgFilename = empty($profileCamera) ? null : $profileCamera;

        if ($profileFile["name"]) {
            $uniqId = uniqid(date("YmdhisU"));
            $ext = pathinfo($profileFile["name"], PATHINFO_EXTENSION);
            $imgFilename = "$uniqId.$ext";
            $imgDir = "../assets/uploads/$imgFilename";

            move_uploaded_file($profileFile["tmp_name"], $imgDir);
        }

        /**
         * Create account
         */
        $find_username = $db
            ->from("users")
            ->where("username", $username)
            ->first()
            ->exec();

        if ($find_username) {
            $_SESSION["message"] = "Username is already taken";
            $_SESSION["status"] = "danger";

            if ($_SERVER["HTTP_REFERER"]) {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                return $conn->close();
            }

            header("location: ../user-register.php");
            return $conn->close();
        }

        $account_id = (function () use ($db) {
            $imgFilename = $GLOBALS["imgFilename"];
            $username = $GLOBALS["username"];
            $password = sha1($username);

            $result = $db
                ->insert("users")
                ->values([
                    "username" => $username,
                    "password" => $password,
                    "user_type" => "user",
                    "avatar" => $imgFilename,
                ])
                ->exec();

            return $result["id"];
        })();

        $result = $db
            ->insert("residents")
            ->values([
                "national_id" => $national_id,
                "citizenship" => $citizenship,
                "firstname" => $fname,
                "middlename" => $mname,
                "lastname" => $lname,
                "alias" => $alias,
                "birthplace" => $birthplace,
                "birthdate" => $birthdate,
                "age" => $age, // Save automatically calculated age
                "civilstatus" => $civil_status,
                "gender" => $gender,
                "purok_id" => $purokId,
                "voterstatus" => $voter_status,
                "identified_as" => $identified_as,
                "phone" => $number,
                "email" => $email,
                "occupation" => $occupation,
                "address" => $address,
                "account_id" => $account_id,
                "is_4ps" => $is_4ps,
                "is_pwd" => $is_pwd,
                "is_senior" => $is_senior,
            ])
            ->exec();

        $_SESSION["message"] = "Resident registered";
        $_SESSION["status"] = "success";

        if ($_SERVER["HTTP_REFERER"]) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            return $conn->close();
        }

        header("location: ../user-register.php");
        return $conn->close();
    } catch (Exception $e) {
        echo "<pre>";
        var_dump($e);
        echo "</pre>";
        throw $e;
    }
}

if (isset($_POST["update-resident"])) {
    $resident_id = getBody("resident_id", $_POST);
    $national_id = getBody("national_id", $_POST);
    $citizenship = getBody("citizenship", $_POST);
    $address = getBody("address", $_POST);
    $fname = getBody("fname", $_POST);
    $mname = getBody("mname", $_POST);
    $lname = getBody("lname", $_POST);
    $alias = getBody("alias", $_POST);
    $birthplace = getBody("birthplace", $_POST);
    $birthdate = getBody("birthdate", $_POST);
    $age = calculateAge($birthdate); // Automatically calculate age
    $civil_status = getBody("civil_status", $_POST);
    $gender = getBody("gender", $_POST);
    $purok_id = getBody("purok_id", $_POST);
    $voter_status = getBody("voter_status", $_POST);
    $identified_as = getBody("identified_as", $_POST);
    $email = getBody("email", $_POST);
    $number = getBody("number", $_POST);
    $occupation = getBody("occupation", $_POST);
    $is_pwd = getBody("is_pwd", $_POST);
    $is_4ps = getBody("is_4ps", $_POST);
    $username = getBody("username", $_POST);
    $password = getBody("password", $_POST);
    $password_confirm = getBody("password_confirm", $_POST);

    $requiredFields = [
        "National ID" => $national_id,
        "Citizenship" => $citizenship,
        "Address" => $address,
        "First Name" => $fname,
        "Middle Name" => $mname,
        "Last Name" => $lname,
        "Alias" => $alias,
        "Birth Place" => $birthplace,
        "Birth Date" => $birthdate,
        "Civil Status" => $civil_status,
        "Gender" => $gender,
        "Purok" => $purok_id,
        "Voter Status" => $voter_status,
        "Email" => $email,
        "Contact Number" => $number,
        "Occupation" => $occupation,
        "Username" => $username,
    ];

    /**
     * Check required fields
     */
    $emptyRequiredField = array_find_key($requiredFields, fn($item) => empty($item));

    if ($emptyRequiredField) {
        $_SESSION["message"] = "<b>$emptyRequiredField</b> is required!";
        $_SESSION["status"] = "danger";

        if ($_SERVER["HTTP_REFERER"]) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            return $conn->close();
        }

        header("location: ../user-edit.php");
        return $conn->close();
    }

    /**
     * Update resident
     */
    $result = $db
        ->update("residents")
        ->set([
            "national_id" => $national_id,
            "citizenship" => $citizenship,
            "firstname" => $fname,
            "middlename" => $mname,
            "lastname" => $lname,
            "alias" => $alias,
            "birthplace" => $birthplace,
            "birthdate" => $birthdate,
            "age" => $age, // Save automatically calculated age
            "civilstatus" => $civil_status,
            "gender" => $gender,
            "purok_id" => $purok_id,
            "voterstatus" => $voter_status,
            "identified_as" => $identified_as,
            "phone" => $number,
            "email" => $email,
            "occupation" => $occupation,
            "address" => $address,
            "is_4ps" => $is_4ps,
            "is_pwd" => $is_pwd,
        ])
        ->where("id", $resident_id)
        ->exec();

    $_SESSION["message"] = "Resident updated";
    $_SESSION["status"] = "success";

    if ($_SERVER["HTTP_REFERER"]) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return $conn->close();
    }

    header("location: ../user-edit.php");
    return $conn->close();
}
