<?php
checkIfuserIsNotLoggedIn();
require "parts/header.php"; 
?>
<form action="/post/add-comment.php" method="POST">
    <input type="hidden" name="post_id" value="<?= $post_id; ?>">
    <div class="mb-3">
        <label for="comment_content" class="form-label">Your Comment</label>
        <textarea class="form-control" id="comment_content" name="content" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit Comment</button>
</form>

<?php require 'parts/footer.php'; ?>