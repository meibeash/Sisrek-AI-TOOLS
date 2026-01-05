<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Tools Recommender</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans">

<!-- Navbar -->
<nav class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center h-14">
            <a href="<?= base_url() ?>" class="font-bold text-lg text-slate-800">
                ✨ AI Tools
            </a>
            <div class="flex items-center gap-6">
                <a href="<?= base_url() ?>" class="text-slate-600 hover:text-slate-900 text-sm">Home</a>
                <a href="<?= base_url('tools') ?>" class="text-slate-600 hover:text-slate-900 text-sm">Explore</a>
                <?php if ($this->session->userdata('user_id')): ?>
                    <a href="<?= base_url('rating/my') ?>" class="text-slate-600 hover:text-slate-900 text-sm">My Ratings</a>
                    <a href="<?= base_url('auth/logout') ?>" class="text-sm bg-slate-900 text-white px-4 py-2 rounded-full hover:bg-slate-700">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" class="text-sm text-slate-600 hover:text-slate-900">Login</a>
                    <a href="<?= base_url('auth/register') ?>" class="text-sm bg-slate-900 text-white px-4 py-2 rounded-full hover:bg-slate-700">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-6 py-10">
