// Helper function to show messages
function showMessage(elementId, message, isError = false) {
    const element = document.getElementById(elementId);
    element.textContent = message;
    element.className = `mt-2 text-sm ${isError ? 'text-red-600' : 'text-green-600'}`;
}

// Helper function to make API calls
async function callApi(action, data = {}) {
    try {
        const formData = new FormData();
        formData.append('action', action);
        for (const [key, value] of Object.entries(data)) {
            formData.append(key, value);
        }

        const response = await fetch('api.php', {
            method: 'POST',
            body: formData
        });

        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        throw new Error('Failed to call API');
    }
}

// Change Access Code
document.getElementById('changeCodeForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const newCode = document.getElementById('newCode').value;
    try {
        const result = await callApi('change_code', { newCode });
        showMessage('codeMessage', result.message, !result.success);
        if (result.success) {
            document.getElementById('newCode').value = '';
        }
    } catch (error) {
        showMessage('codeMessage', error.message, true);
    }
});

// Menu and Footer
async function loadMenuFooter() {
    try {
        const result = await callApi('get_menu_footer');
        if (result.success) {
            document.getElementById('primaryMenu').value = JSON.stringify(result.data.primaryMenu, null, 2);
            document.getElementById('footerContent').value = result.data.footerContent;
        }
    } catch (error) {
        showMessage('menuFooterMessage', error.message, true);
    }
}

document.getElementById('menuFooterForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const primaryMenu = document.getElementById('primaryMenu').value;
    const footerContent = document.getElementById('footerContent').value;
    try {
        const result = await callApi('save_menu_footer', { primaryMenu, footerContent });
        showMessage('menuFooterMessage', result.message, !result.success);
    } catch (error) {
        showMessage('menuFooterMessage', error.message, true);
    }
});

// Blog Posts
let currentPosts = [];

async function loadBlogPosts() {
    try {
        const result = await callApi('get_blog_posts');
        if (result.success) {
            currentPosts = result.posts;
            displayBlogPosts();
        }
    } catch (error) {
        console.error('Failed to load blog posts:', error);
    }
}

function displayBlogPosts() {
    const container = document.getElementById('blogPostsList');
    container.innerHTML = '';
    
    currentPosts.forEach(post => {
        const postElement = document.createElement('div');
        postElement.className = 'bg-gray-50 p-4 rounded shadow mb-4';
        postElement.innerHTML = `
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-semibold">${post.name}</h3>
                    <p class="text-sm text-gray-600">${post.description}</p>
                    <p class="text-xs text-gray-500">Slug: ${post.slug}</p>
                    <p class="text-xs text-gray-500">Time: ${post.time}</p>
                    <span class="inline-block px-2 py-1 text-xs ${post.published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'} rounded">
                        ${post.published ? 'Published' : 'Draft'}
                    </span>
                </div>
                <div class="space-x-2">
                    <button onclick="editPost('${post.id}')" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deletePost('${post.id}')" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(postElement);
    });
}

function editPost(postId) {
    const post = currentPosts.find(p => p.id === postId);
    if (post) {
        document.getElementById('postId').value = post.id;
        document.getElementById('postName').value = post.name;
        document.getElementById('postDescription').value = post.description;
        document.getElementById('postSlug').value = post.slug;
        document.getElementById('postPublished').checked = post.published;
        document.getElementById('postTime').value = post.time;
        document.getElementById('blogPostFormContainer').classList.remove('hidden');
    }
}

async function deletePost(postId) {
    if (confirm('Are you sure you want to delete this post?')) {
        try {
            const result = await callApi('delete_blog_post', { postId });
            if (result.success) {
                await loadBlogPosts();
                showMessage('blogPostMessage', result.message);
            }
        } catch (error) {
            showMessage('blogPostMessage', error.message, true);
        }
    }
}

document.getElementById('addPostBtn').addEventListener('click', () => {
    document.getElementById('blogPostForm').reset();
    document.getElementById('postId').value = '';
    document.getElementById('blogPostFormContainer').classList.remove('hidden');
});

document.getElementById('cancelPostBtn').addEventListener('click', () => {
    document.getElementById('blogPostForm').reset();
    document.getElementById('blogPostFormContainer').classList.add('hidden');
});

document.getElementById('blogPostForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = {
        postId: document.getElementById('postId').value,
        postName: document.getElementById('postName').value,
        postDescription: document.getElementById('postDescription').value,
        postSlug: document.getElementById('postSlug').value,
        postPublished: document.getElementById('postPublished').checked,
        postTime: document.getElementById('postTime').value
    };

    try {
        const result = await callApi('save_blog_post', formData);
        if (result.success) {
            document.getElementById('blogPostForm').reset();
            document.getElementById('blogPostFormContainer').classList.add('hidden');
            await loadBlogPosts();
            showMessage('blogPostMessage', result.message);
        }
    } catch (error) {
        showMessage('blogPostMessage', error.message, true);
    }
});

// Initialize
loadMenuFooter();
loadBlogPosts();
