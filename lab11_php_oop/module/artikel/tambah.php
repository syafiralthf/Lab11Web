<?php

$error = '';
$judul = '';
$isi = '';

$form = new Form(BASE_URL . 'artikel/tambah', "Simpan Artikel");

$form->addField("judul", "Judul Artikel");
$form->addField("isi", "Isi Artikel", "textarea"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $judul = trim($_POST['judul'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    
    if (empty($judul) || empty($isi)) {
        $error = 'Judul dan Isi artikel wajib diisi.';
    } else {
        $data = [
            'judul' => $judul,
            'isi' => $isi,
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        ];

        $simpan = $db->insert('artikel', $data); 

        if ($simpan) { 
            $_SESSION['flash_message'] = "Artikel berhasil ditambahkan!";
            header('Location: ' . BASE_URL . 'artikel');
            exit;
        } else { 
            $error = 'Gagal menyimpan data ke database. Silakan coba lagi.';
        }
    }
}
?>

<h2>Tambah Artikel Baru</h2>
<?php if ($error): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px; background-color: #fff0f0;"><?= $error ?></div>
<?php endif; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form->setFieldValue('judul', $judul);
    $form->setFieldValue('isi', $isi);
}

// Tampilkan Form 
$form->displayForm();
?>