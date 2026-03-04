<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method.');
    }
    if (!array_key_exists('id', $_GET)) {
        throw new Exception('No book ID provided.');
    }
    $id = $_GET['id'];

    $book = Book::findById($id);
    if ($book === null) {
        throw new Exception("Book not found.");
    }

    $BookFormat = Format::findByGame($book->id);
    $bookFormatIds = [];
    foreach ($BookFormat as $format) {
        $bookFormatsIds[] = $format->id;
    }

    $publishers = Publisher::findAll();
    $formats = Format::findAll();
}
catch (PDOException $e) {
    setFlashMessage('error', 'Error: ' . $e->getMessage());
    redirect('/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
        <title>Edit Book</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12">
                <?php require 'php/inc/flash_message.php'; ?>
            </div>
            <div class="width-12">
                <h1>Edit Book</h1>
            </div>
            <div class="width-12">
                <form action="game_update.php" method="POST" enctype="multipart/form-data">
                    <div class="input">
                        <input type="hidden" name="id" value="<?= h($book->id) ?>">
                    </div>
                    <div class="input">
                        <label class="special" for="title">Title:</label>
                        <div>
                            <input type="text" id="title" name="title" value="<?= old('title', $book->title) ?>" required>
                            <p><?= error('title') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="year">Release Year:</label>
                        <div>
                            <input type="date" id="year" name="year" value="<?= old('year', $book->year) ?>" required>
                            <p><?= error('year') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="publisher_ids">Publisher:</label>
                        <div>
                            <select id="publisher_ids" name="publisher_ids" required>
                                <?php foreach ($publishers as $publisher) { ?>
                                    <option value="<?= h($publisher->id) ?>" <?= chosen('publisher_ids', $publisher->id, $book->publisher_ids) ? "selected" : "" ?>>
                                        <?= h($publisher->name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p><?= error('publisher_ids') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="description">Description:</label>
                        <div>
                            <textarea id="description" name="description" required><?= old('description', $book->description) ?></textarea>
                            <p><?= error('description') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special">Formats:</label>
                        <div>
                            <?php foreach ($formats as $platform) { ?>
                                <div>
                                    <input type="checkbox" 
                                        id="platform_<?= h($platform->id) ?>" 
                                        name="format_ids[]" 
                                        value="<?= h($platform->id) ?>"
                                        <?= chosen('format_ids', $platform->id, $gamePlatformsIds) ? "checked" : "" ?>
                                    >
                                    <label for="platform_<?= h($platform->id) ?>"><?= h($platform->name) ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <p><?= error('format_ids') ?></p>
                    </div>
                    <div><img src="images/<?= $book->image_filename ?>" /></div>
                    <div class="input">
                        <label class="special" for="cover_filename">Image (optional):</label>
                        <div>
                            <input type="file" id="cover_filename" name="cover_filename" accept="cover_filename/*">
                            <p><?= error('cover_filename') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <button class="button" type="submit">Update Book</button>
                        <div class="button"><a href="index.php">Cancel</a></div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
// Clear form data after displaying
clearFormData();
// Clear errors after displaying
clearFormErrors();
?>