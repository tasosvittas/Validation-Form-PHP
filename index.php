<!DOCTYPE HTML>  
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            .error {color: #FF0000;}
        </style>
    </head>
    <body>  

        <?php
        // Δηλώσεις μεταβλητών και ανάθεση με κενή τιμή
        $nameErr = $emailErr = $genderErr = $websiteErr = "";
        $name = $email = $gender = $comment = $website = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {/* σε αυτό το block εντολών θα εξεταστούν οι μεταβλητές που ερχονται στο αρχείο με την μέθοδο post */
            if (empty($_POST["name"])) { /* Σύλληψη της name και ελεγχος για άδεια τιμή */
                $nameErr = "Name is required";
            } else {
                $name = test_input($_POST["name"]); /* Σύλληψη της name και ελεγχος για επιβλαβής χαρακτήρες δια μέσω της συνάρτησης test_input */
                if (!preg_match("/^[a-zA-Z ]*$/", $name)) {// έλεγχος της name για γραμματα και κενά
                    $nameErr = "Only letters and white space allowed";
                }
            }

            if (empty($_POST["email"])) {/* Σύλληψη της email και ελεγχος για άδεια τιμή */
                $emailErr = "Email is required";
            } else {
                $email = test_input($_POST["email"]); /* Σύλληψη της email και ελεγχος για επιβλαβής χαρακτήρες δια μέσω της συνάρτησης test_input */
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {/* έλεγχος της email για "@" και "." */
                    $emailErr = "Invalid email format";
                }
            }

            if (empty($_POST["website"])) {/* Σύλληψη της website και ελεγχος για άδεια τιμή */
                $website = "";
            } else {
                $website = test_input($_POST["website"]); /* Σύλληψη της website και ελεγχος για επιβλαβής χαρακτήρες δια μέσω της συνάρτησης test_input */
                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {// εέλεγχος εάν η σύνταξη της διεύθυνσης URL είναι έγκυρη (αυτή η regular expression επιτρέπει επίσης τις παύλες στη διεύθυνση URL)
                    $websiteErr = "Invalid URL";
                }
            }

            if (empty($_POST["comment"])) {/* Σύλληψη της comment και ελεγχος για άδεια τιμή */
                $comment = "";
            } else {
                $comment = test_input($_POST["comment"]); /* Σύλληψη της comment και ελεγχος για επιβλαβής χαρακτήρες δια μέσω της συνάρτησης test_input */
            }

            if (empty($_POST["gender"])) {/* Σύλληψη της gender και ελεγχος για άδεια τιμή */
                $genderErr = "Gender is required";
            } else {
                $gender = test_input($_POST["gender"]); /* Σύλληψη της gender και ελεγχος για επιβλαβής χαρακτήρες δια μέσω της συνάρτησης test_input */
            }
        }

        function test_input($data) {
            $data = trim($data); /* καθαρισμός της data από τα κενά από τις δύο πλευρές της συμβολοσειράς */
            $data = stripslashes($data); /* καθαρισμός της data από τα back slashes */
            $data = htmlspecialchars($data); /* μετατροπή ορισμένων χαρακτήρες σε οντότητες HTML  */
            return $data;
        }
        ?>

        <h2>PHP Form Validation Example</h2>
        <p><span class="error">* required field</span></p>
        <form method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  <!-- η φόρμα θα στείλει τις μςταβλητές στο ίδιο αρχείο -->
            Name: <input type="text" name="name" value="<?php echo $name; ?>"><!-- ως τιμή το περιεχόμενο της name -->
            <span class="error">* <?php echo $nameErr; ?></span><!--  -->
            <br><br>
            E-mail: <input type="text" name="email" value="<?php echo $email; ?>"><!-- ως τιμή το περιεχόμενο της email -->
            <span class="error">* <?php echo $emailErr; ?></span><!--  -->
            <br><br>
            Website: <input type="text" name="website" value="<?php echo $website; ?>"><!-- ως τιμή το περιεχόμενο της website -->
            <span class="error"><?php echo $websiteErr; ?></span>
            <br><br>
            Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment; ?></textarea><!-- ως τιμή το περιεχόμενο της comment -->
            <br><br>
            Gender:
            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">Female <!-- εάν η gender εχει την τιμή female τότε check -->
            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male">Male <!-- εάν η gender εχει την τιμή male τότε check -->
            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "other") echo "checked"; ?> value="other">Other  <!-- εάν η gender εχει την τιμή other τότε check -->
            <span class="error">* <?php echo $genderErr; ?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit">  <!-- Αποστολή των μεταβλητών -->
        </form>

        <?php
        echo "<h2>Your Input:</h2>";
        echo $name;
        echo "<br>";
        echo $email;
        echo "<br>";
        echo $website;
        echo "<br>";
        echo $comment;
        echo "<br>";
        echo $gender;
        ?>

    </body>  
</html>