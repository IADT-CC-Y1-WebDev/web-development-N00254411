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
        'id' => $_POST['id'] ?? null,
        'title' => $_POST['title'] ?? null,
        'author' => $_POST['author'] ?? null,
        'publisher_id' => $_POST['publisher_id'] ?? null,
        'year' => $_POST['year'] ?? null,
        'isbn' => $_POST['isbn'] ?? null,
        'format_ids' => $_POST['format_ids'] ?? [],
        'description' => $_POST['description'] ?? null,
        
        'cover_filename' => $_FILES['cover_filename'] ?? null
    ];

    // Define validation rules
    $rules = [
        'id' => 'required|integer',
        'title' => 'required|notempty|min:1|max:255',
        'author' => 'required|notempty|min:1|max:255',
        'publisher_id' => 'required|integer',
        'year' => 'required|notempty',
        'isbn' => 'required|nonempty|min:13',
        'format_ids' => 'required|array|min:1|max:10',
        'description' => 'required|notempty|min:10|max:5000',
        'cover_filename' => 'file|cover|mimes:jpg,jpeg,png|max_file_size:5242880' // optional -- no required rule
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

    // Find existing book
    $book = Book::findById($data['id']);
    if (!$book) {
        throw new Exception('book not found.');
    }

    // Verify publisher_ids exists
    $publisher_ids = Book::findById($data['publisher_id']);
    if (!$publisher_ids) {
        throw new Exception('Selected publisher does not exist.');
    }

    // Verify platforms exist
    foreach ($data['format_ids'] as $fomatId) {
        if (!Format::findById($fomatId)) {
            throw new Exception('One or more selected Formats do not exist.');
        }
    }

    // Process the uploaded cover (validation already completed)
    $coverFilename = null;
    $uploader = new ImageUpload();
    if ($uploader->hasFile('cover_filename')) {
        // Delete old cover
        $uploader->deleteImage($book->cover_filename);
        // Process new cover
        $coverFilename = $uploader->process($_FILES['cover']);
        // Check for processing errors
        if (!$coverFilename) {
            throw new Exception('Failed to process and save the cover.');
        }
    }
    
    // Update the book instance
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->publisher_id = $data['publisher_id'];
    $book->year = $data['year'];
    $book->isbn = $data['isbn'];
    $book->format_ids = $data['format_ids'];
    $book->description = $data['description'];
    if ($coverFilename) {
        $book->cover_filename = $coverFilename;
    }

    // Save to database
    $book->save();

    // Delete existing fomat associations
    BookFormat::deleteByBook($book->id);
    // Create new fomat associations
    if (!empty($data['format_ids']) && is_array($data['format_ids'])) {
        foreach ($data['format_ids'] as $formatId) {
            BookFormat::create($book->id, $formatId);
        }
    }

    // Clear any old form data
    clearFormData();
    // Clear any old errors
    clearFormErrors();

    // Set success flash message
    setFlashMessage('success', 'Book updated successfully.');

    // Redirect to book details page
    redirect('book_view.php?id=' . $book->id);
}
catch (Exception $e) {
    // Error - clean up uploaded cover
    if ($cover_filename) {
        $uploader->deleteImage($cover_filename);
    }

    // Set error flash message
    setFlashMessage('error', 'Error: ' . $e->getMessage());

    // Store form data and errors in session
    setFormData($data);
    setFormErrors($errors);

    // Redirect back to edit page if there is an ID; otherwise, go to index page
    if (isset($data['id']) && $data['id']) {
        redirect('book_edit.php?id=' . $data['id']);
    }
    else {
        redirect('book_list.php');
    }
}
