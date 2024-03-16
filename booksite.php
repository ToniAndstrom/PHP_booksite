<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="booksite.css">
</head>

<body>
    <div id="container">
        <header>
            <h1>Your Favorite Books</h1>
        </header>
        <nav id="main-navi">
            <ul>
                <li><a href="booksite.php">Home</a></li>
                <li><a href="booksite.php?genre=Adventure">Adventure</a></li>
                <li><a href="booksite.php?genre=Classic Literature">Classic Literature</a></li>
                <li><a href="booksite.php?genre=Coming-of-age">Coming-of-age</a></li>
                <li><a href="booksite.php?genre=Fantasy">Fantasy</a></li>
                <li><a href="booksite.php?genre=Historical Fiction">Historical Fiction</a></li>
                <li><a href="booksite.php?genre=Horror">Horror</a></li>
                <li><a href="booksite.php?genre=Mystery">Mystery</a></li>
                <li><a href="booksite.php?genre=Romance">Romance</a></li>
                <li><a href="booksite.php?genre=Science Fiction">Science Fiction</a></li>
            </ul>
        </nav>
        <main>
            <?php
            // Here you should display the books of the given genre (GET parameter "genre"). Check the links above for parameter values.
            // If the parameter is not set, display all books.
            $json = file_get_contents("books.json");
            $books = json_decode($json, true);

            if (isset ($_GET["genre"])) {
                $genre = $_GET["genre"];
                $filterBooks = [];
                foreach ($books as $book) {
                    if ($book["genre"] === $genre) {
                        $filterBooks[] = $book;
                    }
                }
            } else {
                $filterBooks = $books;
            }

            // Use the HTML template below and a loop (+ conditional if the genre was given) to go through the books in file  
            
            // You also need to check the cookies to figure out if the book is favorite or not and display correct symbol.
            // If the book is in the favorite list, add the class "fa-star" to the a tag with "bookmark" class.
            // If not, add the class "fa-star-o". These are Font Awesome classes that add a filled star and a star outline respectively.
            // Also, make sure to set the id parameter for each book, so the setfavorite.php page gets the information which book to favorite/unfavorite.
            ?>
            <h2>Genre Name or "All Books"</h2>
            <?php foreach ($filterBooks as $book): ?>
                <?php
                if (isset ($_COOKIE["favorites"])) {
                    $favorites = explode(",", $_COOKIE["favorites"]);
                } else {
                    $favorites = [];
                }
                $favoriteKey = in_array($book["id"], $favorites);
                if ($favoriteKey) {
                    $favoriteStar = 'fa-star';
                } else {
                    $favoriteStar = 'fa-star-o';
                }
                ?>
                <section class="book">
                    <a class="bookmark fa <?php echo $favoriteStar ?>" href="setfavorite.php?id=<?php echo $book['id'] ?>"></a>
                    <h3>
                        <?php echo $book['title'] ?>
                    </h3>
                    <p class="publishing-info">
                        <span class="author">
                            <?php echo $book["author"] ?>
                        </span>,
                        <span class="year">
                            <?php echo $book["publishing_year"] ?>
                        </span>
                    </p>
                    <p class="description">
                        <?php echo $book["description"] ?>
                    </p>
                </section>
            <?php endforeach; ?>

        </main>
    </div>
</body>

</html>