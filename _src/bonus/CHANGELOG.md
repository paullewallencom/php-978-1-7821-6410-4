* `edit-post.php` redirects to `view-post.php` after save
* `view-post.php` has edit and delete links
* Removed calls to `Comment::setPublicationDate()` and `Post::setPublicationDate()` from `LoadAuthorData`
* `LoadPostData.php` and `LoadCommentData.php` now use the author system
* Added authors names to `index.php` and `view-post.php`
* Post author support has been added to `edit-post.php`
* Some Behat tests