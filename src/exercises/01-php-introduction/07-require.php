<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libraries Exercises - PHP Introduction</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/examples/01-php-introduction/07-require.php">View Example &rarr;</a>
    </div>

    <h1>Libraries Exercises</h1>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Create a Navigation Include</h2>
    <p><strong>Task:</strong> Create a file called inc/navigation.php that contains an HTML navigation menu with at least 4 links. Then use require to include it in this page twice (at the top and bottom).</p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        require "inc/navigation.php";


        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Create a Utility Library</h2>
    <p><strong>Task:</strong> Create a file called lib/utilities.php with three functions: truncate($text, $length) - truncates text to specified length, formatPrice($amount) - formats a number as currency, getCurrentYear() - returns current year. Use require_once to import it and test all functions.</p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        require_once "lib/utilities.php";
        echo truncate("This is a long piece of text that needs to be truncated.", 20) . "<br>";
        echo formatPrice(1234.567) . "<br>";    
        echo "Current Year: " . getCurrentYear();

            

        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: Multiple Libraries</h2>
    <p><strong>Task:</strong> Create two library files: lib/validators.php (with a function isValidEmail($email)) and lib/formatters.php (with a function formatPhoneNumber($number)). Import both using require_once and demonstrate using both functions.</p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        require_once "lib/validators.php";
        require_once "lib/formatters.php";  
        $email = "test@example.com";
        if (isValidEmail($email)) {
            echo "Valid email address.<br>";
        } else {
            echo "Invalid email address.<br>";
        }
        echo formatPhoneNumber("1234567890");
        ?>
    </div>

</body>
</html>
