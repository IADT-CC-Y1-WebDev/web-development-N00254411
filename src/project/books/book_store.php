<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    // Initialize form data array
    $data = [];
    // Initialize errors array
    $errors = [];

    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Get form data
    $data = [
        'title' => $_POST['title'] ?? null,
        'author' => $_POST['author'] ?? null,
        'year' => $_POST['year'] ?? null,
        'isbn' => $_POST['isbn'] ?? null,
        'publisher_id' => $_POST['publisher_id'] ?? "",
        'description' => $_POST['description'] ?? null,
        'format_ids' => $_POST['format_ids'] ?? "",
        'cover_filename' => $_FILES['cover_filename'] ?? null
    ];

    // Define validation rules
    $year = date('Y');
    $rules = [
        'title' => "required|nonempty|min:5|max:255",
        'author' => "required|nonempty|min:5|max:255",
        'year' => "required|nonempty|integer|minvalue:1900|maxvalue:" . $year,
        'publisher_id' => "required|nonempty|integer",
        'description' => "required|nonempty|min:10",
        'isbn' => "required|nonempty|min:13",
        'format_ids' =>  "required|nonempty|array|minvalue:1|maxvalue:4",
        'cover_filename' => 'required|file|image|mimies:jpg,jpeg,png|max_file_size:5242880'
    ];

    // Validate all data (including file)
    $validator = new Validator($data, $rules);

    if ($validator->fails()) {
        // Get first error for each field
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }

        throw new Exception('Validation failed.');
    }

    // All validation passed - now process and save
    // Verify genre exists
    $publisher_id = Book::findById($data['publisher_id']);
    if (!$publisher_id) {
        throw new Exception('Selected publisher does not exist.');
    }

    // Process the uploaded image (validation already completed)
    $uploader = new ImageUpload(__DIR__ . '/images/');
    $cover_filename = $uploader->process($_FILES['cover_filename']);

    if (!$cover_filename) {
        throw new Exception('Failed to process and save the image.');
    }

    // Create new book instance
    $book = new Book();
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->year = $data['year'];
    $book->publisher_id = $data['publisher_id'];
    $book->isbn = $data['isbn'];
    $book->format_ids = $data['format_ids'];
    $book->description = $data['description'];
    $book->cover_filename = $cover_filename;

    // Save to database
    $book->save();
    // Create platform associations
    if (!empty($data['format_ids']) && is_array($data['format_ids'])) {
        foreach ($data['format_ids'] as $formatId) {
            // Verify platform exists before creating relationship
            if (Format::findById($formatId)) {
                BookFormat::create($book->id, $formatId);
            }
        }
    }

    // Clear any old form data
    clearFormData();
    // Clear any old errors
    clearFormErrors();

    // Set success flash message
    setFlashMessage('success', 'Book stored successfully.');

    // Redirect to book details page
    redirect('book_view.php?id=' . $book->id);
}
catch (Exception $e) {
    // Error - clean up uploaded image
    if (isset($cover_filename) && $cover_filename) {
        $uploader->deleteImage($cover_filename);
    }

    // Set error flash message
    setFlashMessage('error', 'Error: ' . $e->getMessage());

    // Store form data and errors in session
    setFormData($data);
    setFormErrors($errors);

    redirect('book_create.php');
}
