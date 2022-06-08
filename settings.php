<?php
require 'header.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="row">
        <div class="column1">
            <h1 class="settingsH1">Settings</h1>
            <hr class="settingsHR">
            <form action="includes/settings.inc.php" method="POST">
                <button class="columnBlockItem" type="submit" name="accountSettings">Personal information</button>
                <button class="columnBlockItem" type="submit" name="changeEmail">Email</button>
                <button class="columnBlockItem" type="submit" name="changePassword">Password</button>
            </form>
        </div>
        <div class="column2">
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "newemailnotvalid") {
                    echo '<p class="signup-error">New email is not valid!</p>';
                } else if ($_GET['error'] == "repeatedemailnotvalid") {
                    echo '<p class="signup-error">Repeated email is not valid!</p>';
                } else if ($_GET['error'] == "emailsnotequal") {
                    echo '<p class="signup-error">Emails are not equal!</p>';
                } else if ($_GET['error'] == "emptyfields") {
                    echo '<p class="signup-error">Fill in all fields!</p>';
                } elseif ($_GET['error'] == "passwordsnotequal") {
                    echo '<p class="signup-error">Passwords not equal!</p>';
                } elseif ($_GET['error'] == "wrongpassword") {
                    echo '<p class="signup-error">Your current password is wrong!</p>';
                } elseif ($_GET['error'] == "wrongemail") {
                    echo '<p class="signup-error">Your current email is wrong!</p>';
                }
            }
            ?>

            <?php
            $currentClickedButton = "";

            if (isset($_SESSION['currentClickedSettingsButton'])) {
                $currentClickedButton = $_SESSION['currentClickedSettingsButton'];
            }

            if ($currentClickedButton == "accountSettings") {
            ?>
                <h2>Personal information settings</h2>
                <div class="row2">
                    <div class="column3">
                        <form action="includes/settingsAction.inc.php" method="POST">
                            <p>First name:</p>
                            <input class="settingsInput" type="text" name="firstName" placeholder="First name" value='<?php echo $_SESSION['firstName'] ?>'>
                            <p>Email address:</p>
                            <input class="settingsInput" type="text" name="emailAddress" placeholder="Email address" value='<?php echo $_SESSION['userEmail']; ?>'>
                            <p>Profession:</p>
                            <input class="settingsInput" type="text" name="profession" placeholder="Profession" value='<?php echo $_SESSION['profession'] ?>'>
                    </div>

                    <div class="column4">
                        <p>Last name:</p>
                        <input class="settingsInput" type="text" name="lastName" placeholder="Last name" value='<?php echo $_SESSION['lastName'] ?>'>
                        <p>Phone number:</p>
                        <input class="settingsInput" type="text" name="phoneNumber" placeholder="Phone number" value='<?php echo $_SESSION['phoneNumber'] ?>'>
                        <p>Company:</p>
                        <input class="settingsInput" type="text" name="companyName" placeholder="Company" value='<?php echo $_SESSION['companyName'] ?>'>
                        <button class="settingsButton" name="submitPersonalInformation" type="submit">Save changes</button>
                    </div>

                    </form>
                </div>

            <?php
            } elseif ($currentClickedButton == "changeEmail") {
            ?>

                <div class="settingsForm">
                    <h2>Change email</h2>
                    <form action="includes/settingsAction.inc.php" method="POST">
                        <p>Current email:</p>
                        <input class="settingsInput" type="text" name="currentEmail" placeholder="Current email" value='<?php echo $_SESSION['userEmail'] ?>'>
                        <p>New email:</p>
                        <?php
                        if (isset($_GET['newEmail'])) {
                            $newEmail = $_GET['newEmail'];
                            echo '<input class="settingsInput" type="text" name="newEmail" placeholder="New email" value="' . $newEmail . '">';
                        } else {
                            echo '<input class="settingsInput" type="text" name="newEmail" placeholder="New email">';
                        }
                        ?>
                        <p>Repeat new email:</p>
                        <?php
                        if (isset($_GET['repeatedEmail'])) {
                            $repeatedEmail = $_GET['repeatedEmail'];
                            echo '<input class="settingsInput" type="text" name="repeatNewEmail" placeholder="Repeat email" value= "' . $repeatedEmail . '">';
                        } else {
                            echo '<input class="settingsInput" type="text" name="repeatNewEmail" placeholder="Repeat email">';
                        }

                        ?>
                        <br>
                        <input class="settingsButtonV2" type="submit" name="submitChangingEmail" value="Change email">
                    </form>
                </div>

            <?php
            } elseif ($currentClickedButton == "changePassword") {
                echo '      
                <div class="settingsForm">
                <h2>Change password</h2>
            <form action="includes/settingsAction.inc.php" method="POST">
                <p>Current password:</p>
                <input class="settingsInput"  type="password" name="currentPassword" placeholder="Current password">
                <p>New password:</p>
                <input class="settingsInput"  type="password" name="newPassword" placeholder="New password">
                <p>Repeat new password:</p>
                <input class="settingsInput"  type="password" name="repeatNewPassword" placeholder="Repeat password">
                <br>
                <input class="settingsButtonV2" type="submit" name="submitChangingPassword" value="Change password"> 
            </form>
            </div>
            ';
            }

            ?>
        </div>
    </div>

</body>

</html>