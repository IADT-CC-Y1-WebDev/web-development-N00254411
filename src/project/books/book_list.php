<?php
require_once 'php/lib/config.php';
require_once 'php/lib/utils.php';
require_once 'php/lib/forms.php';

try {
    $books = Book::findAll();
    $publishers = Publisher::findAll();
    $formats = Format::findAll();
} 
catch (PDOException $e) {
    die("<p>PDO Exception: " . $e->getMessage() . "</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
         
        
        <title>Books</title>
    </head>
    <body>
        <div class="width-12">
            <?php require 'php/inc/flash_message.php'; ?>
        </div>
        <div class="container">
             <div class="width-12">
                <h1>Book Storage</h1>
            </div>
        </div>
            <div class="container">
            <?php if (!empty($books)) { ?>
                <div class="width-12">
                    <form>
                        <div class="filters">
                            <div class="button">
                                <a href="book_create.php?id=">Add New Book</a>
                            </div>
                            <label for="title_filter">Title:</label>
                            <input type="text" id="title_filter" name="title_filter">
                        <div>
                    <div>
            <label class="publisherFilter" for="publisherFilter"> Publisher:</label>
            
                <select id="publisherFilter" name="publisherFilter">
                    <option value="">All Publishers</option>
                    <?php foreach ($publisher_id as $publisher): ?>
                        <option value="<?= htmlspecialchars($publisher) ?>">
                            <?= htmlspecialchars($publisher) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
                            <button type="button" id="apply_filters">Apply Filters</button>
                            <button type="button" id="clear_filters">Clear Filters</button>
                    <form id="filters_books">
                    <div class="filters">
                        <div class="button">
                            <a href="book_create.php">Add New Book</a>
                        </div>
                             <label for="title_filter" class="labeling">Title:</label>
                            <input type="text" id="title_filter" name="title_filter" >

                            <div class="input">
                                <label for="publisher_filter" class="labeling">Publishers:</label>
                                <select id="publisher_filter" name="publisher_filter">
                                    <option value="">All Publishers</option>
                                    <?php foreach ($publishers as $publisher) { ?>
                                        <option value="<?= h($publisher->id) ?>"><?= h($publisher->name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label for="format_filter" class="labeling">Formats:</label>
                            <select id="format_filter" name="format_filter">
                                <option value="">All Formats</option>
                                <?php foreach ($formats as $format) { ?>
                                    <option value="<?= h($format->id) ?>"><?= h($format->name) ?></option>
                                <?php } ?>
                            </select>
                    
                            <div class="input">
                            <label  for="sort_by" class="labeling">Sort:</label>
                                <select id="sort_by" name="sort_by" >
                                    <option value="title_asc">Title A–Z</option>
                                    <option value="year_desc">Year (newest first)</option>
                                    <option value="year_asc">Year (oldest first)</option>
                                </select>
                             </div>
                        <div class="input">
                            <button type="button"  id="apply_filters" class="button-group1">Apply Filters</button>
                            <button type="button"  id="clear_filters" class="button-group2">Clear Filters</button>
                        </div>
                    </div> 
                </form>
             </div>
            <?php } ?>
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
                                <p>Description: <?= h($book->description) ?></p>
                                
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
            <?php } ?>
        </div>
        <script src="./js/filters.js"></script>
    </body>
</html>