<?php $__env->startSection('title', 'Modifier un membre'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Modifier : <?php echo e($member->name); ?></h1>

    <form method="POST" action="<?php echo e(route('admin.crew.update', $member)); ?>" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div>
            <label for="name" class="block text-sm font-medium mb-2">Nom *</label>
            <input type="text" name="name" id="name" value="<?php echo e(old('name', $member->name)); ?>"
                   class="w-full px-4 py-2 rounded border <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="slug" class="block text-sm font-medium mb-2">Slug</label>
            <input type="text" name="slug" id="slug" value="<?php echo e(old('slug', $member->slug)); ?>"
                   class="w-full px-4 py-2 rounded border">
            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="role" class="block text-sm font-medium mb-2">Rôle (FR) *</label>
            <input type="text" name="role" id="role" value="<?php echo e(old('role', $member->role)); ?>"
                   class="w-full px-4 py-2 rounded border <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="role_en" class="block text-sm font-medium mb-2">Rôle (EN)</label>
            <input type="text" name="role_en" id="role_en" value="<?php echo e(old('role_en', $member->role_en)); ?>"
                   class="w-full px-4 py-2 rounded border">
            <?php $__errorArgs = ['role_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="bio" class="block text-sm font-medium mb-2">Biographie (FR)</label>
            <textarea name="bio" id="bio" rows="5"
                      class="w-full px-4 py-2 rounded border"><?php echo e(old('bio', $member->bio)); ?></textarea>
            <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="bio_en" class="block text-sm font-medium mb-2">Biographie (EN)</label>
            <textarea name="bio_en" id="bio_en" rows="5"
                      class="w-full px-4 py-2 rounded border"><?php echo e(old('bio_en', $member->bio_en)); ?></textarea>
            <?php $__errorArgs = ['bio_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="order" class="block text-sm font-medium mb-2">Ordre d'affichage</label>
            <input type="number" name="order" id="order" value="<?php echo e(old('order', $member->order)); ?>"
                   class="w-full px-4 py-2 rounded border" min="0">
            <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="image" class="block text-sm font-medium mb-2">Image</label>
            <?php if($member->image_path): ?>
                <img src="<?php echo e(asset('storage/' . $member->image_path)); ?>" alt="<?php echo e($member->name); ?>" class="w-32 h-32 object-cover rounded mb-2">
            <?php endif; ?>
            <input type="file" name="image" id="image" class="w-full px-4 py-2 rounded border" accept="image/*">
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="flex items-center gap-3">
            <input type="hidden" name="published" value="0">
            <input type="checkbox" name="published" id="published" value="1"
                   <?php echo e(old('published', $member->is_published) ? 'checked' : ''); ?>

                   class="w-5 h-5">
            <label for="published" class="text-sm font-medium">Publié</label>
        </div>

        
        <div class="flex gap-4">
            <button type="submit" class="btn-primary">
                Enregistrer
            </button>
            <a href="<?php echo e(route('admin.crew.index')); ?>" class="btn-outline">
                Annuler
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\space-tourism-all\resources\views/admin/crew_members/edit.blade.php ENDPATH**/ ?>