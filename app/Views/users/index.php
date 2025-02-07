<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>User Management<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">User Management</h2>
        <a href="<?= base_url('admin/users/create') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="bi bi-person-plus me-2"></i> Add User
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($user['username']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($user['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($user['role']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= date('Y-m-d H:i', strtotime($user['created_at'])) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md inline-flex items-center">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php if ($user['id'] !== session()->get('user_id')): ?>
                                <form action="<?= base_url('admin/users/delete/' . $user['id']) ?>" method="post" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md inline-flex items-center">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (isset($pager)): ?>
            <div class="mt-4">
                <?= $pager->links() ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?= $this->endSection() ?>