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
        'release_date' => $_POST['release_date'] ?? null,
        'genre_id' => $_POST['genre_id'] ?? null,
        'description' => $_POST['description'] ?? null,
        'format_ids' => $_POST['format_ids'] ?? [],
        'cover' => $_FILES['cover'] ?? null
    ];

    // Define validation rules
    $rules = [
        'id' => 'required|integer',
        'title' => 'required|notempty|min:1|max:255',
        'release_date' => 'required|notempty',
        'genre_id' => 'required|integer',
        'description' => 'required|notempty|min:10|max:5000',
        'format_ids' => 'required|array|min:1|max:10',
        'cover' => 'file|cover|mimes:jpg,jpeg,png|max_file_size:5242880' // optional -- no required rule
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
    $book = Game::findById($data['id']);
    if (!$book) {
        throw new Exception('Game not found.');
    }

    // Verify genre exists
    $genre = Genre::findById($data['genre_id']);
    if (!$genre) {
        throw new Exception('Selected genre does not exist.');
    }

    // Verify platforms exist
    foreach ($data['format_ids'] as $platformId) {
        if (!Platform::findById($platformId)) {
            throw new Exception('One or more selected platforms do not exist.');
        }
    }

    // Process the uploaded cover (validation already completed)
    $imageFilename = null;
    $uploader = new ImageUpload();
    if ($uploader->hasFile('cover')) {
        // Delete old cover
        $uploader->deleteImage($book->image_filename);
        // Process new cover
        $imageFilename = $uploader->process($_FILES['cover']);
        // Check for processing errors
        if (!$imageFilename) {
            throw new Exception('Failed to process and save the cover.');
        }
    }
    
    // Update the book instance
    $book->title = $data['title'];
    $book->release_date = $data['release_date'];
    $book->genre_id = $data['genre_id'];
    $book->description = $data['description'];
    if ($imageFilename) {
        $book->image_filename = $imageFilename;
    }

    // Save to database
    $book->save();

    // Delete existing platform associations
    GamePlatform::deleteByGame($book->id);
    // Create new platform associations
    if (!empty($data['format_ids']) && is_array($data['format_ids'])) {
        foreach ($data['format_ids'] as $platformId) {
            GamePlatform::create($book->id, $platformId);
        }
    }

    // Clear any old form data
    clearFormData();
    // Clear any old errors
    clearFormErrors();

    // Set success flash message
    setFlashMessage('success', 'Game updated successfully.');

    // Redirect to book details page
    redirect('game_view.php?id=' . $book->id);
}
catch (Exception $e) {
    // Error - clean up uploaded cover
    if ($imageFilename) {
        $uploader->deleteImage($imageFilename);
    }

    // Set error flash message
    setFlashMessage('error', 'Error: ' . $e->getMessage());

    // Store form data and errors in session
    setFormData($data);
    setFormErrors($errors);

    // Redirect back to edit page if there is an ID; otherwise, go to index page
    if (isset($data['id']) && $data['id']) {
        redirect('game_edit.php?id=' . $data['id']);
    }
    else {
        redirect('index.php');
    }
}
