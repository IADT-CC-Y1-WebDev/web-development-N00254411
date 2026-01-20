<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statements Exercises - PHP Introduction</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/examples/01-php-introduction/02-statements.php">View Example &rarr;</a>
    </div>

    <h1>Statements Exercises</h1>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Age Classifier</h2>
    <p>
        <strong>Task:</strong> 
        Create a variable for age. Use if/else statements to classify and 
        display the age group: "Child" (0-12), "Teenager" (13-19), "Adult" 
        (20-64), or "Senior" (65+).
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $age = 50;
        
        if ($age < 13 ){
            echo "Child";
        } else if ($age < 21 && $age >12){
            echo "Teenager";
        } else if ($age < 65 && $age >20){
            echo "Adult";
        } else if ($age >= 65){
            echo "Senior ";
        }
            
        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Day of the Week</h2>
    <p>
        <strong>Task:</strong> 
        Create a variable for the day of the week (use a number 1-7). Use 
        a switch statement to display whether it's a "Weekday" or "Weekend", 
        and the day name.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here

        $weekDays = rand(1,7);
        switch($weekDays){
            case 1: 
                echo "Today is Monday, it is a weekday!";
                break;
            case 2:
                echo "Today is Tuesday,  is it a weekday!";
                break;
            case 3: 
                echo "Today is Wednesday , it is a weekday!";
                break;
            case 4:
                echo "Today is Thursday, it is a weekday!";
                break;
            case 5: 
                echo "Today is Friday, it is a weekday!";
                break;
            case 6: 
                echo "Today is Saturday, it is the weekend!!";
                break;
            case 7: 
                echo "Today is Sunday, It is the weekend!!";
                break;
        }

        

        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: Multiplication Table</h2>
    <p>
        <strong>Task:</strong> 
        Use a for loop to create a multiplication table for a number of your 
        choice (1 through 10). Display each line in the format "X × Y = Z".
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $X = rand(1,10);
        
        for ($i = 0; $i <= 10; $i++) {
            $Z = $X * $i;
            echo "<p>$X x $i = $Z</p>";
        }

        ?>
    </div>

    <!-- Exercise 4 -->
    <h2>Exercise 4: Countdown Timer</h2>
    <p>
        <strong>Task:</strong> 
        Create a countdown from 10 to 0 using a while loop. Display each number, 
        and when you reach 0, display "Blast off!"
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        ?>
    </div>

</body>
</html>
