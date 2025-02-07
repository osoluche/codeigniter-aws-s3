<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Subir Archivo</h2>
            <a href="<?= base_url('dashboard') ?>" class="text-pink-600 hover:text-pink-700 font-medium">
                ← Volver al Panel
            </a>
        </div>
        
        <?php if (session()->has('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline"><?= session('error') ?></span>
            </div>
        <?php endif; ?>

        <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">¡Archivo subido exitosamente!</span>
        </div>
        
        <form action="<?= base_url('files/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-6" id="uploadForm">
            <div class="space-y-4">
                <label class="block">
                    <span class="text-gray-700">Seleccionar Archivo</span>
                    <p class="text-sm text-gray-500 mb-2">Tipos de archivo permitidos: .txt, .doc, .pdf, .xls, .pptx (Tamaño máximo: 10MB)</p>
                    <input type="file" 
                           name="file" 
                           class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-pink-50 file:text-pink-600
                                  hover:file:bg-pink-100
                                  cursor-pointer"
                           accept=".txt,.doc,.docx,.pdf,.xls,.xlsx,.pptx"
                           required
                           id="fileInput">
                    <div id="uploadProgress" class="hidden mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-pink-600 h-2.5 rounded-full" style="width: 0%" id="progressBar"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1" id="progressText">0%</p>
                    </div>
                </label>
            </div>
            
            <div class="flex items-center justify-end">
                <button type="submit" 
                        class="bg-[#ec008c] hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg
                               transition duration-200 ease-in-out transform hover:scale-105">
                    Subir Archivo
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>