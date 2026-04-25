<?php
require_once 'php/lib/config.php';
require_once 'php/lib/utils.php';

try {
    $books = Book::findAll();
} 
catch (PDOException $e) {
    die("<p>PDO Exception: " . $e->getMessage() . "</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
        <?php include 'php/inc/flash_message.php'; ?>
        
        <title>Books</title>
    </head>
    <body>
        <div class="container">
             <div class="width-12">
                <h1>Book Storage</h1>
            </div>
        </div>
            <div class="container">
            <?php if (!empty($books)) { ?>
                <div class="width-12">
                    <form id="filters" class="filters">
                        <div class="filters">
                        <div class="button">
                            <a href="book_create.php">Add New Book</a>
                        </div>
                            <label  for="title_filter" class="labeling">Title:</label>
                            <input type="text" id="title_filter" name="title_filter" placeholder="Part of a title">

                            <label  for="publisher_id_filter" class="labeling">Publisher:</label>
                            <select id="publisher_id_filter" name="publisher_id_filter">
                                <option value="">All Publishers</option>
                                <?php foreach ($publisher_id as $publisher) { ?>
                                     <option value="<?= htmlspecialchars($publisher) ?>">
                            <?= htmlspecialchars($publisher) ?>
                        </option>
                                <?php } ?>
                            </select>
                            <label  for="format_ids_filter" class="labeling">Format:</label>
                            <select id="format_ids_filter" name="format_ids_filter">
                                <option value="">All Formats</option>
                                <?php foreach ($format_ids as $format) { ?>
                                    <option value="<?= htmlspecialchars($format->id) ?>"><?= htmlspecialchars($format->name) ?></option>
                                <?php } ?>
                            </select>
                        <div >
                            <div class="input">
                        <label  for="sort_by">Sort:</label>
                            <div>
                                <select id="sort_by" name="sort_by">
                                    <option value="title_asc">Title A–Z</option>
                                    <option value="year_desc">Year (newest first)</option>
                                    <option value="year_asc">Year (oldest first)</option>
                                </select>
                            </div>
                            <button class="button-group1" type="submit" id="apply_filters">Apply Filters</button>
                            <button class="button-group2"type="button" id="clear_filters">Clear Filters</button>
                        </div>
                     </div>
                    </form>
                </div>
             </div>
            <?php } ?>
          </div>


            <div class="width-12 header">
                <!-- <?php require 'php/inc/flash_message.php'; ?> -->
            </div>

        <div class="container">
            <?php if (empty($books)) { ?>
                <p>No books found.</p>
            <?php } else { ?>
                <div class="width-12 cards">
                    <?php foreach ($books as $book) { ?>
                        <div class="card">
                            <div class="top-content">
                                <h2><?= h($book->title) ?></h2>
                                <p>Author: <?= h($book->author) ?></p>
                                <p>Release Year: <?= h($book->year) ?></p>
                                
                            </div>
                            <div class="bottom-content">
                                <img src="images/<?= h($book->cover_filename) ?>" alt="Image for <?= h($book->title) ?>" />
                                <div class="actions">
                                    <a href="book_view.php?id=<?= h($book->id) ?>">View</a>/ 
                                    <a href="book_edit.php?id=<?= h($book->id) ?>">Edit</a>/ 
                                    <a href="book_delete.php?id=<?= h($book->id) ?>">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <script src="js/filters.js"></script>
            <?php } ?>
        </div>
        
    </body>
</html>