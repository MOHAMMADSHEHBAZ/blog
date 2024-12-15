<?php
include "db_connect.php";
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">All Posts</h1>

        <div id="postsContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            
        </div>
    </div>

    <script>
        async function fetchPosts() {
            try {
                const response = await fetch('fetch_posts.php');
                const posts = await response.json();

                const postsContainer = document.getElementById('postsContainer');

                posts.forEach(post => {
                    const postElement = document.createElement('div');
                    postElement.classList.add('bg-white', 'rounded-md', 'shadow-md', 'p-4');

                    postElement.innerHTML = `
                        <img src="uploads/${post.image}" alt="${post.title}" class="w-full h-40 object-cover rounded-md mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">${post.title}</h2>
                        <p class="text-gray-600 mt-2">${post.description.substring(0, 100)}</p>
                    `;

                    postsContainer.appendChild(postElement);
                });
            } catch (error) {
                console.error('Error fetching posts:', error);
            }
        }
        fetchPosts();
    </script>
</body>
</html>