<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogdetails extends Model
{
     protected $fillable = [
    'name',
    'author',
    'title',
    'slug',
    'description',
    'meta_title',
    'meta_keywords',
    'meta_description',
    'top_content',
    'bottom_content',
    'image_banner',
    'ratingcount',
    'ratingvalue',
    'heading',
    'about_blog',
    'paragraph1',
    'paragraph2',
    'paragraph3',
    'paragraph4',
    'paragraph5',
    'paragraph6',
    'faqq1',
    'faqa1',
    'faqq2',
    'faqa2',
    'faqq3',
    'faqa3',
    'faqq4',
    'faqa4',
    'faqq5',
    'faqa5',
    'image',
    'status',
];

     protected $guarded = [];
}
