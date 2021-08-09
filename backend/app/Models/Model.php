<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Model
 * @package App\Models
 *
 * @method static self find($id)
 * @method static self first()
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
}
