<?php

$id_artikel = (int)($segments[2] ?? 0);
if (!$id_artikel) {
    echo '<div style="color:red;">Error: ID Artikel tidak ditemukan.</div>';
    return;
}

$error = '';

$artikel = $db->get('artikel', "id = $id_artikel");

if (!$artikel) {
    echo '<div style="color:red;">Artikel dengan ID ' . $id_artikel . ' tidak ditemukan.</div>';
    return;
}

$judul_lama = $artikel['judul'];
$isi_lama = $artikel['isi'];

$form = new Form(BASE_URL . 'artikel/ubah/' . $id_artikel, "Simpan Perubahan");

$form->addField("judul", "Judul Artikel"); 
$form->addField("isi", "Isi Artikel", "textarea");

$form->setFieldValue('judul', $judul_lama);
$form->setFieldValue('isi', $isi_lama);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_baru = trim($_POST['judul'] ?? '');
    $isi_baru = trim($_POST['isi'] ?? '');
    
    if (empty($judul_baru) || empty($isi_baru)) {
        $error = 'Judul dan Isi artikel wajib diisi.';
    } else {
        $data = [
            'judul' => $judul_baru,
            'isi' => $isi_baru
        ];
        
        $simpan = $db->update('artikel', $data, "id = $id_artikel"); 

        if ($simpan) { 
            $_SESSION['flash_message'] = "Artikel ID $id_artikel berhasil diubah!";
            header('Location: ' . BASE_URL . 'artikel');
            exit;
        } else { 
            $error = 'Gagal mengubah data.';
        }
    }

    if ($error) {
        $form->setFieldValue('judul', $judul_baru);
        $form->setFieldValue('isi', $isi_baru);
    }
}
?>

<h2>Ubah Artikel ID: <?= $id_artikel ?></h2>
<?php if ($error): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px; background-color: #fff0f0;"><?= $error ?></div>
<?php endif; ?>

<?php
$form->displayForm();
?>
<p><a href="<?= BASE_URL ?>artikel" class="btn">Batal</a></p>