<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<!-- Main Content -->
<main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Archivos</h1>
            <a href="/files/upload"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">Subir Nuevo
                Archivo</a>
        </div>

        <!-- Files Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre del Archivo</th>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subido Por</th>
                        <?php endif; ?>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamaño
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha de Subida</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= esc($file['original_name']) ?>
                            </td>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= esc($file['username']) ?>
                                </td>
                            <?php endif; ?>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= number_format($file['file_size'] / 1024, 2) ?> KB
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('Y-m-d H:i', strtotime($file['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="copyToClipboard('<?= $file['s3_url'] ?>')" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="bi bi-clipboard"></i> Copiar URL
                                </button>
                                <a href="<?= $file['s3_url'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="bi bi-download"></i> Descargar
                                </a>
                                <a href="/files/delete/<?= $file['id'] ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar este archivo?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function copyToClipboard(url) {
        navigator.clipboard.writeText(url).then(() => {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
            toast.textContent = 'URL copiada al portapapeles';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }).catch(() => {
            alert('Error al copiar URL');
        });
    }
</script>
<?= $this->endSection() ?>