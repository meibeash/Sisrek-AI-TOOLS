<div class="max-w-md mx-auto">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Create account</h1>
        <p class="text-slate-500">Sign up to get personalized recommendations</p>
    </div>
    
    <?php if ($this->session->flashdata('error')): ?>
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
        <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>
    
    <div class="bg-white rounded-2xl border p-8">
        <form method="post" action="<?= base_url('auth/register') ?>">
            <div class="mb-5">
                <label class="block text-slate-700 text-sm font-medium mb-2">Name</label>
                <input type="text" name="name" required
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       placeholder="Your name">
            </div>
            
            <div class="mb-5">
                <label class="block text-slate-700 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       placeholder="you@example.com">
            </div>
            
            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required minlength="6"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       placeholder="Min 6 characters">
            </div>
            
            <button type="submit" 
                    class="w-full bg-slate-900 text-white py-3 rounded-xl font-medium hover:bg-slate-700 transition">
                Create Account
            </button>
        </form>
    </div>
    
    <p class="text-center text-slate-500 mt-6">
        Already have an account? 
        <a href="<?= base_url('auth/login') ?>" class="text-purple-600 hover:underline font-medium">Sign in</a>
    </p>
</div>
