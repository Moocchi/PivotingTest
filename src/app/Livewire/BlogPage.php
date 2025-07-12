<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;

class BlogPage extends Component
{
    public function render()
    {
        $blogs = Blog::latest()->get(); // Ambil semua data blog terbaru

        return view('livewire.blog-page', [
            'blogs' => $blogs
        ]);
    }
}
