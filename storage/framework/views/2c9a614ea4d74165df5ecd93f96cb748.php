cat > resources/views/admin/users/_form.blade.php <<'BLADE'
<?php echo csrf_field(); ?>


<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name ?? '')); ?>" required>
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email ?? '')); ?>" required>
    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-3">
    <label class="form-label">Mot de passe <?php if(isset($user)): ?><small>(laisser vide pour ne pas changer)</small><?php endif; ?></label>
    <input type="password" name="password" class="form-control" <?php if(empty($user)): ?> required <?php endif; ?>>
    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-3">
    <label class="form-label">Confirmation mot de passe</label>
    <input type="password" name="password_confirmation" class="form-control" <?php if(empty($user)): ?> required <?php endif; ?>>
</div>


<div class="mb-3">
    <label class="form-label">Rôles</label>
    <div class="d-flex gap-3 flex-wrap">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleName => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="form-check">
                <input type="checkbox" class="form-check-input"
                       name="roles[]"
                       value="<?php echo e($roleName); ?>"
                       <?php if(in_array($roleName, old('roles', $userRoles ?? []))): echo 'checked'; endif; ?>>
                <span class="form-check-label"><?php echo e($roleName); ?></span>
            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php $__errorArgs = ['roles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mt-3">
    <button class="btn btn-primary">Enregistrer</button>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">Annuler</a>
</div>
BLADE
<?php /**PATH C:\laragon\www\space-tourism-all\resources\views/admin/users/_form.blade.php ENDPATH**/ ?>