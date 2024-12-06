<?php
session_start();

// Retrieve category from the URL
$category = $_GET['category'];

// Query products based on the category from your database
// Example: $products = queryProducts($category);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Gym - <?php echo ucfirst($category); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        header {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid #ccc;
            position: fixed;
            width: 100%;
            z-index: 2; /* Ensure header is above the blurred background */
        }

        header h1 {
            font-family: 'Bebas Neue', sans-serif;
            margin: 0;
            color: #09814A; /* Set header text color */
        }
    </style>
</head>

<body>
<header>
        <center><h1>Urban Gym</h1></center>
        <!-- Add any navigation links or elements you want in the header -->
    </header>

    <main>
        <section>
            <h2><?php echo ucfirst($category); ?></h2>
            <!-- Display products here -->
            <?php
            // Loop through $products and display product information
            // Example:
            /*
            foreach ($products as $product) {
                echo "<div>";
                echo "<p>{$product['name']}</p>";
                echo "<button>Add to Cart</button>";
                echo "</div>";
            }
            */
            ?>
        </section>
    </main>
</body>

</html>
