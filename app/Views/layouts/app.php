<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Archivero S3</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- Custom styles -->
    <style>
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Navigation -->
    <nav class="shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="<?= base_url('dashboard') ?>" class="flex items-center">
                    <img src="<?= base_url('logo.png') ?>" alt="Archivero S3 Logo" class="h-8 w-auto">
                </a>
                
                <!-- Navigation Links -->
                <?php if (session()->get('user_id')): ?>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link px-3 py-2 rounded-lg flex items-center">
                        <i class="bi bi-speedometer2 mr-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('files/upload') ?>" class="nav-link px-3 py-2 rounded-lg flex items-center">
                        <i class="bi bi-file-earmark-arrow-up mr-2"></i>Archivos
                    </a>
                    <?php if (session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('admin/users') ?>" class="nav-link px-3 py-2 rounded-lg flex items-center">
                        <i class="bi bi-people mr-2"></i>Usuarios
                    </a>
                    <?php endif; ?>
                    <div class="relative inline-block text-left"></div>
                        <button class="nav-link px-3 py-2 rounded-lg flex items-center">
                            <i class="bi bi-person-circle mr-2"></i>
                            <?= esc(session()->get('username')) ?>
                        </button>
                    </div>
                    <div class="relative inline-block text-left">
                        <a href="<?= base_url('logout') ?>" class="nav-link px-3 py-2 rounded-lg text-red-400 hover:text-white">
                            <i class="bi bi-box-arrow-right mr-2"></i>Salir
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 flex-grow">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> Archivero S3. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>