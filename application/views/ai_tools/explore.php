<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 mb-2">🔍 Explore AI Tools</h1>
    <p class="text-slate-500">Discover and search through our collection of AI tools</p>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-xl border p-6 mb-8">
    <form method="get" action="<?= base_url('tools') ?>" class="flex flex-col md:flex-row gap-4">
        <!-- Search Input -->
        <div class="flex-1 relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">🔍</span>
            <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" 
                   placeholder="Search by name, category, or keyword..." 
                   class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
        
        <!-- Category Filter -->
        <div class="md:w-64">
            <select name="category" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= ($selected_category ?? '') == $cat ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Search Button -->
        <button type="submit" 
                class="px-8 py-3 bg-slate-900 text-white rounded-xl font-medium hover:bg-slate-700 transition">
            Search
        </button>
        
        <?php if (!empty($search) || !empty($selected_category)): ?>
        <a href="<?= base_url('tools') ?>" 
           class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-medium hover:bg-slate-50 transition text-center">
            Clear
        </a>
        <?php endif; ?>
    </form>
</div>

<!-- Search Results Info -->
<?php if (!empty($search) || !empty($selected_category)): ?>
<div class="mb-6 flex items-center gap-2 text-slate-600">
    <span>Showing results</span>
    <?php if (!empty($search)): ?>
        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
            "<?= htmlspecialchars($search) ?>"
        </span>
    <?php endif; ?>
    <?php if (!empty($selected_category)): ?>
        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
            <?= htmlspecialchars($selected_category) ?>
        </span>
    <?php endif; ?>
    <span class="text-slate-400">(<?= count($tools) ?> tools found)</span>
</div>
<?php endif; ?>

<!-- Tools Grid -->
<?php if (!empty($tools)): ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <?php foreach ($tools as $tool): ?>
    <a href="<?= base_url('tools/detail/'.$tool->tool_id) ?>" 
       class="group bg-white rounded-xl p-5 border border-slate-200 hover:border-purple-300 hover:shadow-lg transition-all">
        
        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-violet-600 rounded-lg flex items-center justify-center text-white text-sm font-bold mb-4">
            <?= strtoupper(substr($tool->company_name, 0, 1)) ?>
        </div>
        
        <h3 class="font-semibold text-slate-800 group-hover:text-purple-600 mb-2">
            <?= htmlspecialchars($tool->company_name) ?>
        </h3>
        
        <p class="text-slate-400 text-sm mb-3"><?= htmlspecialchars($tool->category ?? 'AI Tool') ?></p>
        
        <!-- Rating Display -->
        <div class="flex items-center gap-1 mb-4">
            <?php 
            $avg = $tool->avg_rating ?? 0;
            $count = $tool->rating_count ?? 0;
            for($s = 1; $s <= 5; $s++): 
                $filled = $s <= round($avg);
            ?>
            <span class="text-sm <?= $filled ? 'text-yellow-400' : 'text-slate-200' ?>">★</span>
            <?php endfor; ?>
            <span class="text-xs text-slate-400 ml-1">
                <?php if ($count > 0): ?>
                    <?= $avg ?> (<?= $count ?>)
                <?php else: ?>
                    No ratings
                <?php endif; ?>
            </span>
        </div>
        
        <div class="flex items-center justify-between">
            <span class="text-xs px-2 py-1 rounded-full <?= strtolower($tool->subscription ?? '') === 'free' ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' ?>">
                <?= strtolower($tool->subscription ?? '') === 'free' ? 'Free' : ($tool->subscription ?? 'Paid') ?>
            </span>
            <span class="text-slate-400 text-sm">
                ↑ <?= number_format($tool->votes ?? 0) ?>
            </span>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center py-20 bg-white rounded-xl border">
    <p class="text-5xl mb-4">🔍</p>
    <p class="text-slate-500 mb-2">No tools found</p>
    <p class="text-slate-400 text-sm mb-6">Try a different search term or category</p>
    <a href="<?= base_url('tools') ?>" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full hover:bg-slate-700">
        View All Tools
    </a>
</div>
<?php endif; ?>
