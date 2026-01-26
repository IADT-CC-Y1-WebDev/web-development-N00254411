<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrays Exercises - PHP Introduction</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/examples/01-php-introduction/03-arrays.php">View Example &rarr;</a>
    </div>

    <h1>Arrays Exercises</h1>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Favorite Movies</h2>
    <p>
        <strong>Task:</strong> 
        Create an indexed array with 5 of your favorite movies. Use a for 
        loop to display each movie with its position (e.g., "Movie 1: 
        The Matrix").
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $movies = [
            "Halloween Town",
            "The Simpsons Movie",
            "My little pony",
            "Moshi Monster movie",
            "Wreck it Ralph"
        ];
        
        for ($i = 0; $i != count($movies);$i++){
            echo "Movie " . ($i+1) . ": " . $movies[$i] . "<br/>";
        }
        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Student Record</h2>
    <p>
        <strong>Task:</strong> 
        Create an associative array for a student with keys: name, studentId, 
        course, and grade. Display this information in a formatted sentence.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $student = [
            "name" => "Leoandro Dicaprio",
            "studentId" => "0927854",
            "course" => "film",
            "grade"=> "3rd year"
        ];

        $text = 
        "The students name is {$student['name']} and their student id is {$student['studentId']}, theyre in the course {$student['course']}, it is their {$student['grade']}";
        print("<p>$text</p>");
        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: Country Capitals</h2>
    <p>
        <strong>Task:</strong> 
        Create an associative array with at least 5 countries as keys and their 
        capitals as values. Use foreach to display each country and capital 
        in the format "The capital of [country] is [capital]."
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $countries = [
            "Ireland" => "Dublin",
            "Poland" => "Warsaw",
            "Sweden" => "stockholm",
            "Philippines"=> "Manila",
            "Thailand"=> "Bangkok"
        ];
        foreach ($countries as $country => $capital ) {
            echo "<p>The capital of $country is $capital</p>";
        }
        ?>
    </div>

    <!-- Exercise 4 -->
    <h2>Exercise 4: Menu Categories</h2>
    <p>
        <strong>Task:</strong> 
        Create a nested array representing a restaurant menu with at least 
        2 categories (e.g., "Starters", "Main Course"). Each category should 
        have at least 3 items with prices. Display the menu in an organized 
        format.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $Courses = [
            'starter course' => [
                'Tomato soup' => 6.00,
                'Garlic Bread'=> 6.50,
                'Clam soup'=> 7.00
            ],
            'Main course' => [
                'Lamb Legs and Potato' => 12.50,
                'Chicken curry and Rice' => 13.00,
                'Pork chops and potato' => 13.50,
            ]
        ];
       foreach ($Courses as $course => $food) {
    echo "<p>" . ucfirst($course) . " products:</p>";
    echo "<ul>";
    foreach ($food as $key => $price) {
        echo "<li>$key\t($price)</li>";
    }
    echo "</ul>";
}
        ?>
    </div>

</body>
</html>
