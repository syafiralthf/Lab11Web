<?php
$sql = "SELECT id, judul, tanggal_dibuat FROM artikel ORDER BY id DESC";
$artikels = $db->fetchAll($sql);
?>

<div class="content-center">

    <div class="card">

        <h2>Daftar Artikel</h2>

        <div class="action-center">
            <a href="<?= BASE_URL ?>artikel/tambah" class="btn">+ Tambah Artikel</a>
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert-success">
                <?= $_SESSION['flash_message'] ?>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($artikels): foreach ($artikels as $a): ?>
                <tr>
                    <td><?= $a['id'] ?></td>
                    <td><?= htmlspecialchars($a['judul']) ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($a['tanggal_dibuat'])) ?></td>
                    <td>
                        <a class="btn" href="<?= BASE_URL ?>artikel/ubah/<?= $a['id'] ?>">Ubah</a>
                        <a class="btn btn-danger"
                           href="<?= BASE_URL ?>artikel/hapus/<?= $a['id'] ?>"
                           onclick="return confirm('Yakin hapus artikel ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data artikel</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>