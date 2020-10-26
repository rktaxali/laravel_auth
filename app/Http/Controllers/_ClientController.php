<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;    // Ravi: added to use Http servie

class ClientController extends Controller
{
    public function getAllPosts()
    {
        $response = http::get('https://jsonplaceholder.typicode.com/posts'); // the url for  GET	/posts
        return $response->json();
    }

    public function getPostById($id)
    {
        $response = http::get('https://jsonplaceholder.typicode.com/posts/'.$id); 
        return $response->json();
    }
    
    // Creating a new post (using POST method in web.route)
    public function addPost()
    {
        $response = http::post('https://jsonplaceholder.typicode.com/posts/', 
            [
                'userId'=>  1,
                'title' => 'New Post',
                'body' => 'New Post Body',
            ]
        ); 
        return $response->json();
    }

    //Update a post using the put request 
    public function updatePostById($id)
    {
        $response = http::put('https://jsonplaceholder.typicode.com/posts/'.$id, 
            [
                'userId'=>  2,
                'title' => 'Updated Post',
                'body' => 'Updated post  Body',
            ]
        ); 
        return $response->json();
    }

    //delete post
    public function deletePost($id)
    {
        $response = http::delete('https://jsonplaceholder.typicode.com/posts/'.$id ); 
        return $response->json();
    }

}
