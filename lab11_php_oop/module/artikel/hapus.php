<?php

$id_artikel = (int)($segments[2] ?? 0); 

if (!$id_artikel) {
    $_SESSION['flash_message'] = "Error: ID Artikel tidak valid untuk dihapus.";
    header('Location: ' . BASE_URL . 'artikel');
    exit;
}

$result = $db->delete('artikel', "id = $id_artikel");

if ($result) {
    $_SESSION['flash_message'] = "Artikel ID $id_artikel berhasil dihapus!";
} else {
    $_SESSION['flash_message'] = "Gagal menghapus artikel ID $id_artikel.";
}

header('Location: ' . BASE_URL . 'artikel');
exit;
?>