<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Event\User;

use App\Entity\Bookmark;

/**
 * Description of BookmarkDeletedEvent
 *
 * @author Phoenix
 */
class BookmarkDeletedEvent {
    public function __construct(private Bookmark $bookmark) {
    }
    
    public function getBookmark()
    {
        return $this->bookmark;
    }
    
}
