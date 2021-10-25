<?php
/**
 * Author: Jaron Kempson
 * Date: 10/25/21
 * File: Book.php
 * Description:
 */

namespace Thoughts\Models;


use Illuminate\Database\Eloquent\Model;

class Book extends Model {

    protected $table = 'books';
    protected $primaryKey = 'book_id';

}