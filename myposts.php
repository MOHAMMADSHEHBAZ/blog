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
        <h1 class="text-2xl font-bold text-gray-700 mb-6">My Posts</h1>

        <div id="postsContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            
        </div>
    </div>

    <script>
        async function fetchPosts() {
            try {
                const response = await fetch('fetch_myposts.php');
                const posts = await response.json();

                const postsContainer = document.getElementById('postsContainer');

                posts.forEach(post => {
                    const postElement = document.createElement('div');
                    postElement.classList.add('bg-white', 'rounded-md', 'shadow-md', 'p-4');

                    postElement.innerHTML = `
                        <img src="uploads/${post.image}" alt="${post.title}" class="w-full h-40 object-cover rounded-md mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">${post.title}</h2>
                        <p class="text-gray-600 mt-2">${post.description.substring(0, 100)}</p>
                        <p class="text-sm text-gray-500 mt-2">${post.active_status == 1 ? 'Active' : 'Not Active'}</p>
                        <div class="mt-4 flex gap-4">
                            <button onclick="deletePost(${post.id})" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
                            ${post.active_status == 0 ? `<button onclick="activatePost(${post.id})" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Activate</button>` : ""}
                        </div>
                        `;

                    postsContainer.appendChild(postElement);
                });
            } catch (error) {
                console.error('Error fetching posts:', error);
            }
        }

        fetchPosts();

        async function deletePost(postId) {
            if (!confirm('Are you sure you want to delete this post?')) return;

            try {
                const response = await fetch('delete_post.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: postId })
                });

                const result = await response.json();

                if (result.success) {
                    alert('Post deleted successfully');
                    fetchPosts();
                } else {
                    alert('Failed to delete post');
                }
            } catch (error) {
                console.error('Error deleting post:', error);
            }
            setTimeout(() => {
                alert('Post deleted successfully');
                window.location.reload();
            }, 2000);
        }

        async function activatePost(postId) {
            try {
                const response = await fetch('activate_post.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: postId })
                });

                const result = await response.json();
                if (result) {
                    alert('Post activated successfully!');
                    fetchPosts();
                } else {
                    alert('Failed to activate post');
                }
            } catch (error) {
                console.error('Error activating post:', error);
            }
            setTimeout(() => {
                alert('Your Post is now active successfully!');
                window.location.reload();
            }, 2000);
        }

    </script>
</body>
</html>