<?php

namespace App\Event\User;

use App\Entity\Bookmark;


/**
 * Description of BookmarkCreatedEvent
 *
 * @author Phoenix
 */
class BookmarkCreatedEvent {
    public function __construct(private Bookmark $bookmark) {
    }
    
    public function getBookmark() {
        return $this->bookmark;
    }
}
