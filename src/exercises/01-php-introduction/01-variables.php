<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variables Exercises - PHP Introduction</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/examples/01-php-introduction/01-variables.php">View Example &rarr;</a>
    </div>

    <h1>Variables Exercises</h1>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Personal Information</h2>
    <p>
        <strong>Task:</strong> 
        Create variables for your first name, last name, age, and city. 
        Then output a sentence using these variables that says "My name 
        is [first] [last], I am [age] years old and I live in [city]."
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $firstName = "Victoria";
        $lastName = "Connolly";
        $age = "18";
        $city = "Arklow";

        echo "My name is $firstName $lastName, i am $age years old and i live in $city";
        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Shopping Calculator</h2>
    <p>
        <strong>Task:</strong> 
        Create variables for three product prices and their quantities. 
        Calculate the subtotal for each product (price × quantity), then 
        calculate the total cost. Apply a 10% discount and display the 
        final price.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $price1 = 8.70;
        $price2 = 4.40;
        $price3 = 5.90;
        $quantity1 = 4;
        $quantity2 = 2;
        $quantity3 = 6;
        $discount = 0.9;
        
        $totalprice1 = $price1*$quantity1;
        $totalprice2 = $price2*$quantity2;
        $totalprice3 = $price3*$quantity3;

        $finalCost = ($totalprice1+$totalprice2+$totalprice3)*$discount;
        
        echo "The final cost is $finalCost";
        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: User Status</h2>
    <p>
        <strong>Task:</strong> 
        Create boolean variables for isStudent, hasDiscount, and isPremiumMember. 
        Use the ternary operator to display "Yes" or "No" for each status.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $isStudent = TRUE;
        $hasDiscount = TRUE;
        $isPremiumMember = FALSE;

        if ($isStudent == TRUE){
            echo " Is student :yes ";
        } else {
            echo "Is student :no ";
        }
        if ($hasDiscount == TRUE){
            echo "Has discount :yes ";
        } else {
            echo " Has discount :no ";
        }
        if ($isPremiumMember == TRUE){
             echo " Is Premium Memeber :yes";
        } else {
            echo "Is Premium Member :no ";
        }
           

        ?>
    </div>

</body>
</html>
