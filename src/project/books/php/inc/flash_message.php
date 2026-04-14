<?php
require_once 'php/lib/session.php';
require_once 'php/lib/utils.php';

startSession();
$flash = getFlashMessage();
if ($flash) { ?>
    <div class="flash-message <?= h($flash['type']) ?>">
        <?= h($flash['message']) ?>
</div>
<?php } else { ?>
    
    <div></div> 
<?php } ?>