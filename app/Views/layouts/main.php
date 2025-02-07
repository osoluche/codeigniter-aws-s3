<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivero S3</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ec008c',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <?php if (session()->get('user_id')): ?>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <!-- Logo -->
                        <img src="<?= base_url('logo.png') ?>" alt="Archivero S3 Logo" class="h-8 w-auto">
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="/dashboard" class="inline-flex items-center px-1 pt-1 text-primary hover:text-primary-dark">
                            Dashboard
                        </a>
                        <a href="/files/upload" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-primary">
                            Upload File
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <form action="/logout" method="post" class="ml-4">
                        <button type="submit" class="text-gray-500 hover:text-primary">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
</body>
</html>