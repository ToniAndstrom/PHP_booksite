<?php
// If the user is not logged in, redirect them back to login.php.
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}
// if the form has been sent, add the book to the data file

// In order to protect against cross-site scripting attacks (i.e. basic PHP security), remove HTML tags from all input.
// There's a function for that. E.g.
// $title = strip_tags($_POST["title"]);
$json = file_get_contents("books.json");
$books = json_decode($json, true);


if (isset($_POST["add-book"])) {
    $new_book = array(
        'id' => isset($_POST["bookid"]) ? strip_tags($_POST["bookid"]) : "",
        "title" => isset($_POST["title"]) ? strip_tags($_POST["title"]) : "",
        "author" => isset($_POST["author"]) ? strip_tags($_POST["author"]) : "",
        "publishing_year" => isset($_POST["year"]) ? strip_tags($_POST["year"]) : "",
        "genre" => isset($_POST["genre"]) ? strip_tags($_POST["genre"]) : "",
        "description" => isset($_POST["description"]) ? strip_tags($_POST["description"]) : ""
        );
        echo("BOOK ADDED!");

    array_push($books, (object) $new_book);
    file_put_contents("books.json", json_encode($books));
} 

if (isset($_POST["add-book"]) &&
!isset($_POST["bookid"]) ||
!isset($_POST["title"]) ||
!isset($_POST["author"]) ||
!isset($_POST["year"]) ||
!isset($_POST["genre"]) ||
!isset($_POST["description"])
) {
echo("Please fill in all the fields");
}

?>
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
                <li><a href="admin.php">Admin Home</a></li>
                <li><a href="addbook.php">Add a New Book</a></li>
                <li><a href="login.php?logout">Log Out</a></li>
            </ul>
        </nav>
        <main>
            <h2>Add a New Book</h2>
            <form action="addbook.php" method="post">
                <p>
                    <label for="bookid">ID:</label>
                    <input type="number" id="bookid" name="bookid">
                </p>
                <p>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title">
                </p>
                <p>
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author">
                </p>
                <p>
                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year">
                </p>
                <p>
                    <label for="genre">Genre:</label>
                    <select id="genre" name="genre">
                        <option value="Adventure">Adventure</option>
                        <option value="Classic Literature">Classic Literature</option>
                        <option value="Coming-of-age">Coming-of-age</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Historical Fiction">Historical Fiction</option>
                        <option value="Horror">Horror</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Romance">Romance</option>
                        <option value="Science Fiction">Science Fiction</option>
                    </select>
                </p>
                <p>
                    <label for="description">Description:</label><br>
                    <textarea rows="5" cols="100" id="description" name="description"></textarea>
                </p>
                <p><input type="submit" name="add-book" value="Add Book"></p>
            </form>
        </main>
    </div>
</body>

</html>