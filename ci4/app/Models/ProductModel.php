<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Product;

class ProductModel extends Model
{
    protected $table         = 'product';
    protected $allowedFields = ['id', 'product_type', 'name'];
    protected $returnType    = Product::class;
    protected $useTimestamps = true;
    protected $validationRules    = [
        'name'     => 'required|alpha_numeric_space|min_length[3]',
        'product_type'        => 'required|is_natural'
    ];
}