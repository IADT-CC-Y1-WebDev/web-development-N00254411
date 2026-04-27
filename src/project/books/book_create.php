<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    $book = Book::findAll();
    $publishers = Publisher::findAll();
    $formats = Format::findAll();
}
catch (PDOException $e) {
    setFlashMessage('error', 'Error: ' . $e->getMessage());
    redirect('/book_list.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <?php include 'php/inc/head_content.php'; ?>
        <title>View Book</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12">
                <?php require 'php/inc/flash_message.php'; ?>
            </div>
            <div class="width-12">
                
                <h1>Create Book</h1>
            </div>
            <div class="back">
            <div class="width-12">
                <form id="book_form" action="book_store.php" method="POST" enctype="multipart/form-data" novalidate>
                    <div id="error_summary_top" class="error-summary" style="display:none" role="alert"></div>
                    <div class="input">
                        <label class="special" for="title">Title:</label>
                        <div>
                            <input type="text" id="title" name="title" value="<?= old('title') ?>" required>
                            <p id="title_error"><?= error('title') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="author">Author:</label>
                        <div>
                            <input type="text" id="author" name="author" value="<?= old('author') ?>" required>
                            <p id="author_error"><?= error('author') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="year">Year:</label>
                        <div>
                            <input type="text" id="year" name="year" value="<?= old('year') ?>" required>
                            <p id="year_error"><?= error('year') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="isbn">ISBN:</label>
                        <div>
                            <input type="text" id="isbn" name="isbn" value="<?= old('isbn') ?>" required>
                            <p id="isbn_error"><?= error('isbn') ?></p>
                        </div>
                    </div>
                 <div class="input">
                        <label class="special" for="publisher_id">Publisher:</label>
                        <div>
                            <select id="publisher" name="publisher_id" required>
                                <option value="">Choose a publisher</option>
                                <?php foreach ($publishers as $publisher) { ?>
                                    <option value="<?= h($publisher->id) ?>" <?= chosen('publisher_id', $publisher->id) ? "selected" : "" ?>>
                                        <?= h($publisher->name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p id="publisher_id_error"><?= error('publisher_id') ?></p>
                        </div>
                    </div> 
                    <div class="input">
                        <label class="special" for="description">Description:</label>
                        <div>
                            <textarea id="description" name="description" required><?= old('description') ?></textarea>
                            <p id="description_error"><?= error('description') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special">Formats:</label>
                        <div>
                            <?php foreach ($formats as $format) { ?>
                                <div>
                                    <input type="checkbox" 
                                        id="format_<?= h($format->id) ?>" 
                                        name="format_ids[]" 
                                        value="<?= h($format->id) ?>"
                                        <?= chosen('format_ids', $format->id) ? "checked" : "" ?>
                                        >
                                    <label for="format_<?= h($format->id) ?>"><?= h($format->name) ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <p id="format_id_error"><?= error('format_ids') ?></p>
                    </div>
                    <div class="input">
                        <label class="special" for="cover_filename">Image (required):</label>
                        <div>
                            <input type="file" id="cover_filename" name="cover_filename" accept="images/*" required>
                            <p id="cover_filename_error"><?= error('cover_filename') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <button  id="submit_btn"class="button" type="submit">Store Book</button>
                        <div class="button"><a href="book_list.php">Cancel</a></div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    
        <script src="js/form_validation.js"></script>
    </body>
</html>
<?php
// Clear form data after displaying
clearFormData();
// Clear errors after displaying
clearFormErrors();
?>