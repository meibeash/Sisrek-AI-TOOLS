<!-- Header -->
<div class="mb-10">
    <h1 class="text-3xl font-bold text-slate-800 mb-2">⭐ My Ratings</h1>
    <p class="text-slate-500">Tools you've rated</p>
</div>

<?php if (!empty($ratings)): ?>

<!-- Stats -->
<div class="bg-white rounded-2xl border p-6 mb-8 flex items-center justify-between">
    <div>
        <p class="text-3xl font-bold text-slate-800"><?= count($ratings) ?></p>
        <p class="text-slate-500 text-sm">Tools rated</p>
    </div>
    <a href="<?= base_url('recommendation') ?>" class="bg-purple-600 text-white px-5 py-2 rounded-full text-sm hover:bg-purple-700">
        View Recommendations →
    </a>
</div>

<!-- List -->
<div class="bg-white rounded-2xl border divide-y">
    <?php foreach($ratings as $r): ?>
    <div class="p-5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-600 font-semibold">
                <?= strtoupper(substr($r->company_name, 0, 1)) ?>
            </div>
            <div>
                <p class="font-medium text-slate-800"><?= htmlspecialchars($r->company_name) ?></p>
                <p class="text-slate-400 text-xs"><?= date('M d, Y', strtotime($r->created_at)) ?></p>
            </div>
        </div>
        <div class="flex items-center gap-1 text-yellow-400">
            <?php for($i = 1; $i <= 5; $i++): ?>
                <span class="<?= $i <= $r->rating ? 'text-yellow-400' : 'text-slate-200' ?>">★</span>
            <?php endfor; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php else: ?>

<div class="text-center py-20">
    <p class="text-5xl mb-4">⭐</p>
    <p class="text-slate-500 mb-6">You haven't rated any tools yet</p>
    <a href="<?= base_url('tools') ?>" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full hover:bg-slate-700">
        Start Rating
    </a>
</div>

<?php endif; ?>
